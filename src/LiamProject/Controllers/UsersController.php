<?php
namespace LiamProject\Controllers;

use \LiamProject\View\View;
use \LiamProject\Models\Users\User;
use \LiamProject\Exceptions\InvalidArgumentException;

class UsersController
{
	private $view;

	public function __construct()
	{
		$this->view = new View(__DIR__ . '/../../../templates/');
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
		}
		$this->view->renderhtml('users/signUp.php', [], 200);	
	}
}