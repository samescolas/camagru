<div class="main">
	<h2>Change Password</h2>
	<form action="changepassword" method="post">
			<input autofocus="autofocus" type="password" name="oldpw" placeholder="Current password" id="oldpw" autocomplete="off" />
			<br />
			<input type="password" name="newpw" placeholder="New password" id="newpw" autocomplete="off" />
			<br />
			<input type="password" name="new2" placeholder="New password again" id="new2" autocomplete="off" />
			<br />
	
		<input type="hidden" name="token" value="<?=$data['token'] ?>" />
		<input type="submit" value="Update" />
	</form>
</div>
