<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>Главная Страница</title>
	<link rel="stylesheet" type="text/css" href="/style.css">
</head>
<body>
	<table class="layout">
    <tr>
        <td colspan="2" class="header">
            <?= $title ?? 'Мой блог'; ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right">
            <?= !empty($user) ? 'Привет, ' . $user->getNickname() : 'Войдите на сайт' ?>
        </td>
    </tr>
    <tr>
        <td>