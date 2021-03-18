<?php
    $title = $title ?? 'Мой блог';
    include __DIR__ . '/../header.php'; 
?>
<h1><?= $article->gettitle(); ?></h2>
<p><?= $article->getText(); ?></p>
<hr>
<p class="autor">Автор: <?= $autor->getNickname(); ?></p>
<?php include __DIR__ . '/../footer.php'; ?>
