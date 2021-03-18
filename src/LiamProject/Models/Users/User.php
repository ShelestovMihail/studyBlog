<?php
namespace LiamProject\Models\Users;

use \LiamProject\Models\ActiveRecordEntity;

class User extends ActiveRecordEntity
{
	protected $nickname;
	protected $email;
	public $isConfirmed;
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
}
