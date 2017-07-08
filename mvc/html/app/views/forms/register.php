<div class="main">
	<h2>Register</h2>
	<form action="register" method="post">
			<input autofocus="autofocus" type="text" name="username" placeholder="Username" id="username" value="<?=$data['username']?>" autocomplete="off" />
			<br />
		
			<input type="email" name="email" placeholder="Email address" id="email" value="<?=$data['email']?>" autocomplete="off" />
			<br />
	
			<input type="password" name="password" placeholder="Password" id="password" />
			<br />
	
			<input type="password" name="password_again" placeholder="Retype password" id="password_again" />
			<br />
	
		<input type="hidden" name="token" value="<?=$data['token']?>" />
	
		<input type="submit" value="Register" />
	</form>
</div>
