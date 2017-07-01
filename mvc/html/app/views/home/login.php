<form action="" method="post" />
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" autocomplete="off" />
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

	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
	<input type="submit" value="Login" />
</form>
