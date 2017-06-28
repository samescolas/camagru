<?php

class User {
	private $_db;

	public function __construct($user = null) {
		$this->_db = Database::getInstance();
	}

	public function create($fields = array()) {
		$user_fields = array( 'username' => $fields['username']);
		if  ($this->_db->insert('users', $user_fields)) {
			$id = $this->_db->get('users', array(
				'username',
				'=',
				$fields['username']
			))->first()->id;
		}
		$passwd_fields = array(
			'user_id' => $id,
			'passwd' => $fields['password'],
			'salt' => $fields['salt']
		);

		if (!$id || !$this->_db->insert('shadow', $passwd_fields)) {
			throw new Exception ('There was a prblem creating an account.');
		}
	}

}

?>
