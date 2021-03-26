<?php
namespace LiamProject\Controllers;

use \LiamProject\View\View;
use \LiamProject\Models\Articles\Article;
use \LiamProject\Models\Users\UsersAuthService;

class MainController
{
	private $view;

	public function __construct()
	{
		$this->user = UsersAuthService::getUserByToken();
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->view->setVar('user', $this->user);
	}

	public function main()
	{
		//Получаем статьи из бд
		$articles = Article::getAll();

		$this->view->renderHtml('main/main.php', ['articles' => $articles]);
	}
}