<?php
namespace LiamProject\Controllers;

use \LiamProject\View\View;
use \LiamProject\Models\Articles\Article;

class MainController
{
	private $view;

	public function __construct()
	{
		$this->view = new View(__DIR__ . '/../../../templates/');
	}

	public function main()
	{
		//Получаем статьи из бд
		$articles = Article::getAll();

		$this->view->renderHtml('main/main.php', ['articles' => $articles]);
	}

	public function sayHi($name)
	{
		$this->view->renderHtml('main/hello.php', ['name' => $name, 'title' => 'Страница приветствия']);
	}

	public function sayBye($name)
	{
		echo 'Goodbye, ' . $name;
	}
}