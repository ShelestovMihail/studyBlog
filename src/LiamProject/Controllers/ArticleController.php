<?php
namespace LiamProject\Controllers;

use \LiamProject\Exceptions\NotFoundException;
use \LiamProject\View\View;
use \LiamProject\Models\Articles\Article;
use \LiamProject\Models\Users\User;
use \LiamProject\Models\Users\UsersAuthService;

class ArticleController
{
	private $view;

	public function __construct()
	{
		$this->user = UsersAuthService::getUserByToken();
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->view->setVar('user', $this->user);
	}

	public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        if (!$article) {
        	throw new NotFoundException();           
        }

        $autor = $article->getAutor();

        $this->view->renderHtml('articles/view.php', [
            'article' => $article,
            'autor' => $autor
        ]);
    }

    public function edit(int $articleId)
    {
        $article = Article::getById($articleId);

        if (!$article) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }
        echo 'Функционал готов, форма на подходе';
        $article->setTitle($article->getTitle() . ' new ver');
        $article->save();
    }

    public function create(): void
    {
        $autor = User::getById(2);

        $article = new Article();
        $article->setTitle('newasasd title');
        $article->setText('Новый текст123123');
        $article->setAutor($autor);

        $article->save();
    }

    public function delete(int $articleId)
    {
        $article = Article::getById($articleId);

        if($article === null) {
            echo 'Такой статьи не существует';
            return;
        }

        $article->delete();
        var_dump($article);
    }
}