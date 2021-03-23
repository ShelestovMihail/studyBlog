<?php include __DIR__ . '/../header.php'; ?>
<h1>Регистрация</h1>
<?php if (isset($error)) : ?>
<p class="errorMessage"><?= $error; ?></p>
<?php endif; ?>
<div class='signUpForm'>
	<form action='' method=post class="signUpForm">
		<label>
			Nickname: <input type="text" name="nickname" value='<?= $_POST["nickname"]; ?>'><br>
		</label>
		<label>
			Почта: <input type="email" name="email" value='<?= $_POST["email"]; ?>'><br>
		</label>
		<label>
			Пароль: <input type="password" name="password" value='<?= $_POST["password"]; ?>'><br>
		</label>
		<input type="submit" value="Зарегестрироваться"><br>
	</form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>