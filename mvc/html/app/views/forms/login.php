<h2>Login</h2>
<form action="login" method="post" />
		<input autofocus="autofocus" type="text" name="username" placeholder="Username" id="username" value="<?=$data['username']?>" autocomplete="off" />
		<br />
		<input type="password" name="password" placeholder="Password" id="password" autocomplete="off" />
		<br />
		<input type="checkbox" name="remember" id="remember" value="on" />Remember me?
		<br />

	<input type="hidden" name="token" value="<?=$data['token'] ?>" />
	<input type="submit" value="Login" />
</form>
