<?php
namespace LiamProject\Controllers;

use \LiamProject\View\View;
use \LiamProject\Models\Articles\Article;
use \LiamProject\Models\Users\User;

class ArticleController
{
	private $view;

	public function __construct()
	{
		$this->view = new View(__DIR__ . '/../../../templates/');
	}

	public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        /*$articleReflector = new \ReflectionObject($article);

        var_dump($articleReflector->getMethods());*/

        if (!$article) {
        	$this->view->renderHtml('errors/404.php', [], 404);
            return;
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

        $article->setTitle('New Title');
        var_dump($article);
    }
}