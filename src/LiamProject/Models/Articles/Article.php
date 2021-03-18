<?php
namespace LiamProject\Models\Articles;

use \LiamProject\Models\Users\User;
use \LiamProject\Models\ActiveRecordEntity;

class Article extends ActiveRecordEntity
{
	protected $autorId;
	protected $title;
	protected $text;
	protected $createdAt;

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getAutor(): User
	{
		return User::getById($this->autorId);
	}

	public function getText(): string
	{
		return $this->text;
	}

	public function setTitle(string $title)
	{
		$this->title = $title;
	}

	public function setText(string $text)
	{
		$this->text = $text;
	}

	protected static function getTableName(): string
	{
		return 'articles';
	}
}