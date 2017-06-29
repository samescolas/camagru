<?php

require_once 'core/init.php';

if (Session::exists('success')) {
	echo Session::flash('success');
}

if (Session::exists('home')) {
	echo Session::flash('home');
}

$user = new User();

if  ($user->isLoggedIn()) {
?>
	<p> <a href="welcome.php">Welcome, <?php echo escape($user->data()->username); ?>!</a></p>
	<p> <a href="update.php">Update Account</a></p>
	<p> <a href="changepassword.php">Change Password</a></p>
	<p> <a href="logout.php">Logout</a></p>
<?php
} else {
?>
	<p><a href="login.php">Login, idiot!</a></p>
<?php
}

?>
