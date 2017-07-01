<form action="login" method="post" />
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?=$data['username']?>" autocomplete="off" />
	</div>

	<div class="field">
		<label for="password">Password</label>
		<input type="password" name="password" id="password" autocomplete="off" />
	</div>

	<div class="field">
		<label for="remember">
			<input type="checkbox" name="remember" id="remember" value="on" />Remember me?
		</label>
	</div>

	<input type="hidden" name="token" value="<?=$data['token'] ?>" />
	<input type="submit" value="Login" />
</form>

<form action="register" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?=$data['username']?>" autocomplete="off" />
	</div>
	
	<div class="field">
		<label for="email">Email</label>
		<input type="email" name="email" id="email" value="<?=$data['email']?>" autocomplete="off" />
	</div>

	<div class="field">
		<label for="password">Choose a password</label>
		<input type="password" name="password" id="password" />
	</div>

	<div class="field">
		<label for="password_again">Please type your password again</label>
		<input type="password" name="password_again" id="password_again" />
	</div>

	<input type="hidden" name="token" value="<?=$data['token']?>" />

	<input type="submit" value="Register" />
</form>
