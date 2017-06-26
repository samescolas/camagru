#!/usr/bin/php
<?php

class Database {

	private $host = 'localhost';
	private $user = 'root';
	private $pass = '';
	private $dbname = "camagru";
	private $charset = 'utf8';

	public function __construct() {
		$dsn = "mysql:host=$this->host;charset=$this->charset";

		$opt = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false,
		];

		$pdo = new PDO($dsn, $this->user, $this->pass, $opt);
		$this->initialize($pdo);
	}

	private function initialize($pdo) {
		$pdo->exec(
			"DROP DATABASE " . $this->dbname . 
			"; CREATE DATABASE " . $this->dbname . ";"
		);

		$tables = ['users', 'shadow', 'imgs', 'likes', 'comments'];

		foreach($tables as $table) {
			$pdo->exec(
				"use " . $this->dbname . "; " .
				file_get_contents(__DIR__ . "/sql/create_$table.sql")
			);
		}
	}

}

$db = new Database();

?>
