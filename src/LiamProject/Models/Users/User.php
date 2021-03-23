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
		return $this->name;
	}

	public function getRole(): string
	{
		return $this->name;
	}

	public function getPasswordHash(): string
	{
		return $this->name;
	}

	public function getAuthToken(): string
	{
		return $this->name;
	}

	public function getCreatedAd(): string
	{
		return $this->name;
	}

	public static function getCount(): int
	{
		return self::$count;
	}

	protected static function getTableName(): string
	{
		return 'users';
	}

	public static function signUp(array $userData)
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
	}
}
