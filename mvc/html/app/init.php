<?php

session_start();

$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => 'localhost',
		'username' => 'phpmyadmin',
		'password' => 'pass123' ,
		'db' => 'camagru'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	)
);

spl_autoload_register(function($class) {
	if (file_exists(__DIR__ . '/core/' . $class . '.class.php')) {
		require_once __DIR__ . '/core/' . $class . '.class.php';
	} else if (file_exists(__DIR__ . '/models/' . $class . '.class.php')) {
		require_once __DIR__ . '/models/' . $class . '.class.php';
	}
});

require_once __DIR__ . '/utils/sanitize.php';

?>
