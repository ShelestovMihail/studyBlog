<?php
namespace LiamProject\Models\Users;

use \LiamProject\Models\ActiveRecordEntity;
use \LiamProject\Exceptions\InvalidArgumentException;

class User extends ActiveRecordEntity
{
	protected $nickname;
	protected $email;
	protected $isConfirmed;
	protected $role;
	protected $passwordHash;
	protected $authToken;
	protected $createdAt;

	public function getNickname(): string
	{
		return $this->nickname;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getRole(): string
	{
		return $this->role;
	}

	public function getPasswordHash(): string
	{
		return $this->passwordHash;
	}

	public function getAuthToken(): string
	{
		return $this->authToken;
	}

	public function getCreatedAd(): string
	{
		return $this->createdAt;
	}

	public function activate(): void
	{
		$this->isConfirmed = 1;
		$this->save();
	}

	public function isActivated():bool
	{
		return (bool)$this->isConfirmed;
	}

	public static function getCount(): int
	{
		return self::$count;
	}

	protected static function getTableName(): string
	{
		return 'users';
	}

	public static function signUp(array $userData): User
	{
		self::validateUserData($userData);

		$user = new User();
		$user->nickname = $userData['nickname'];
		$user->email = $userData['email'];
		$user->passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
		$user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
		
		$user->save();
		return $user;
	}

	protected static function validateUserData(array $userData): void
	{
		foreach ($userData as $dataName => $data) {
			if (empty($data)) {
				throw new InvalidArgumentException('Не передан: ' . $dataName);
			}
		}
		if (!preg_match('|^[a-zA-Z0-9]+$|', $userData['nickname'])) {
			throw new InvalidArgumentException('Nickname может состоять только из латинских букв и цифр');
		}

		if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
			throw new InvalidArgumentException('Email Некорректен');
		}

		if (mb_strlen($userData['password']) < 8) {
			throw new InvalidArgumentException('Пароль должен бьть не менее 8 символов');
		}

		if (static::findOneByColumn('nickname', $_POST['nickname']) !== null) {
			throw new InvalidArgumentException('Пользователь с таким именем уже существует');
		}

		if (static::findOneByColumn('email', $_POST['email']) !== null) {
			throw new InvalidArgumentException('Пользователь с такой почтой уже существует');
		}
	}

	public static function login(array $loginData): User
		{
		if (empty($loginData['email'])) {
    	    throw new InvalidArgumentException('Не передан email');
    	}
	
    	if (empty($loginData['password'])) {
    	    throw new InvalidArgumentException('Не передан password');
    	}
	
    	$user = User::findOneByColumn('email', $loginData['email']);
    	if ($user === null) {	
    	    throw new InvalidArgumentException('Нет пользователя с таким email');
    	}
	
    	if (!password_verify($loginData['password'], $user->getPasswordHash())) {
    	    throw new InvalidArgumentException('Неправильный пароль');
    	}
	
    	if (!$user->isConfirmed) {
    	    throw new InvalidArgumentException('Пользователь не подтверждён');
    	}

    	$user->refreshAuthToken();
    	$user->save();

    	return $user;
	}

	private function refreshAuthToken(): void
	{
		$this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
	}
}
