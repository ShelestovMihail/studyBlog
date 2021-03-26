<?php
namespace LiamProject\Controllers;

use \LiamProject\View\View;
use \LiamProject\Models\Users\User;
use \LiamProject\Exceptions\InvalidArgumentException;
use \LiamProject\Exceptions\UserNotFoundException;
use \LiamProject\Exceptions\InvalidCodeException;
use \LiamProject\Models\Users\UserActivationService;
use \LiamProject\Models\Users\UsersAuthService;
use \LiamProject\Services\EmailSender;

class UsersController
{
	private $view;

	public function __construct()
	{
		$this->user = UsersAuthService::getUserByToken();
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->view->setVar('user', $this->user);
	}

	public function signUp()
	{
		if (!empty($_POST)) {
			try {
				$user = User::signUp($_POST);
			} catch (InvalidArgumentException $e) {
				$this->view->renderhtml('users/signUp.php', ['error' => $e->getMessage()]);
				return;
			}

			if ($user instanceof User) {
				$code = UserActivationService::createActivationCode($user);

				EmailSender::send($user, 'Активация', 'userActivation.php', [
					'userId' => $user->getId(),
					'code' => $code
				]);

				$this->view->renderHtml('users/signUpSuccessful.php');
				return;
			}
		}
		$this->view->renderhtml('users/signUp.php', [], 200);	
	}

	public function activate(int $userId, string $activationCode)
	{
		$user = User::getById($userId);

		if ($user === null) {
			throw new UserNotFoundException("Пользователь с таким id не найден");
			
		}

		if ($user->isActivated()) {
			$this->view->renderHtml('users/activationSuccessfull.php');
			return;
		}

		$codeIsValid = UserActivationService::checkActivationCode($user, $activationCode);

		if ($codeIsValid) {
			$user->activate();
			UserActivationService::deleteCode($user);

			$this->view->renderHtml('users/activationSuccessfull.php');
		} else {
			UserActivationService::deleteCode($user);
			$code = UserActivationService::createActivationCode($user);

			EmailSender::send($user, 'Активация', 'userActivation.php', [
				'userId' => $user->getId(),
				'code' => $code
			]);
			
			throw new InvalidCodeException("Неправильный код, активация не завершена. На вашу почту отправленно повторно отправлено сообщение "); //нужно заново отправить почту удалить код из базы, 
		}
	}

	public function login()
	{
		if (!empty($_POST)) {
			try {
				$user = User::login($_POST);
				UsersAuthService::createToken($user);
				header('Location: /');
				return;
			} catch (InvalidArgumentException $e) {
				$this->view->renderhtml('users/login.php', ['error' => $e->getMessage()]);
				return;
			}
		}
		$this->view->renderHtml('users/login.php');
	}
}