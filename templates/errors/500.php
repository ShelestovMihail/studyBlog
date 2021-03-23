<?php
    $title = $title ?? 'Мой блог';
    include __DIR__ . '/../header.php'; 
?>
<h1>Произошла критическая ошибка!</h2>
<p><?= $error; ?></p>

<?php include __DIR__ . '/../footer.php'; ?>