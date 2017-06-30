<?php require_once __DIR__ . '/../../init.php'; ?>
<form action="" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php escape(Input::get('username')); ?>" autocomplete="off" />
	</div>

	<div class="field">
		<label for="password">Choose a password</label>
		<input type="password" name="password" id="password" />
	</div>

	<div class="field">
		<label for="password_again">Please type your password again</label>
		<input type="password" name="password_again" id="password_again" />
	</div>

	<div class="field">
		<label for="name">Your name</label>
		<input type="text" name="name" id="name" />
	</div>

	<input type="hidden" name="token" value=<?=$data['token']?> />

	<input type="submit" value="Register" />
</form>
