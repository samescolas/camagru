<form action="welcome/login" method="post" />
		<input type="text" name="username" placeholder="Username" id="username" value="<?=$data['username']?>" autocomplete="off" />
		<br />
		<input type="password" name="password" placeholder="Password" id="password" autocomplete="off" />
		<br />
		<input type="checkbox" name="remember" id="remember" value="on" />Remember me?
		<br />
	</div>

	<input type="hidden" name="token" value="<?=$data['token'] ?>" />
	<input type="submit" value="Login" />
</form>
