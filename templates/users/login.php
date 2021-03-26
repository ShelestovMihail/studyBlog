<?php include __DIR__ . '/../header.php'; ?>
<h1>Вход</h1>
<?php if (isset($error)) : ?>
<p class="errorMessage"><?= $error; ?></p>
<?php endif; ?>
<div class='loginForm'>
	<form action='/login' method=post>
		<label>
			Почта: <input type="email" name="email" value='<?= $_POST["email"]; ?>'><br>
		</label>
		<label>
			Пароль: <input type="password" name="password" value='<?= $_POST["password"]; ?>'><br>
		</label>
		<input type="submit" value="Войти"><br>
	</form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>