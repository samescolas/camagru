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
<?php
} else {
?>
	<p><a href="login.php">Login, idiot!</a></p>
<?php
}

?>
