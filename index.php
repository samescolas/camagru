<?php

require_once 'core/init.php';

$user = Database::getInstance()->update('users', 2, array(
	'username' => 'Lili'
));

?>
