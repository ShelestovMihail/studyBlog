<?php
    $title = $title ?? 'Мой блог';
    include __DIR__ . '/../header.php';
    foreach ($articles as $article): 
?>
<h2><a href="article/<?= $article->getId(); ?>"><?= $article->getTitle(); ?></a></h2>
<p><?= $article->getText(); ?></p>
<hr>
<?php 
    endforeach;
    include __DIR__ . '/../footer.php';
?>
