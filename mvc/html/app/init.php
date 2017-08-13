<?php

session_start();

$GLOBALS['config'] = array(
	'max_file_size' => 500000,
	'mysql' => array(
		'host' => 'localhost',
		'username' => 'root',
		'password' => '' ,
		'db' => 'camagru'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800,
		'stamp' => 'registered'
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'camagru_token'
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
