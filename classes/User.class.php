<?php

	class User {
		private $db;
		private $username;

	
		public __construct(Database $db) {
			$this->db = $db;
		}

}

?>
