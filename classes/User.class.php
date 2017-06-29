<?php

class User {
	private $_db;
	private $_data;
	private $_sessionName;
	private $_isLoggedIn;

	public function __construct($user = null) {
		$this->_db = Database::getInstance();
		$this->_sessionName = Config::get('session/session_name');

		if (!$user) {
			if (Session::exists($this->_sessionName)) {
				$user = Session::get($this->_sessionName);

				if ($this->find($user)) {
					$this->_isLoggedIn = true;
				} else {
					// logout
				}
			}
		} else {
			$this->find($user);
		}
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
		$this->setPass($passwd_fields);
	}

	public function find($user = null) {
		$tbls = 'users u left join shadow s on s.user_id = u.id';
		if ($user) {
			if (preg_match('/^\d+$/', $user)) {
					$data = $this->_db->get($tbls, array('s.user_id', '=', $user));
			} else {
				$data = $this->_db->get($tbls, array('u.username', '=', $user));
			}

			if ($data && $data->count()) {
				$this->_data = $data->first();
				return (true);
			}
		}
	}

	public function login($username = null, $password = null) {
		$user = $this->find($username);
		if ($user) {
			if ($this->data()->passwd === Hash::make($password, $this->data()->salt)) {
				Session::put($this->_sessionName, $this->data()->user_id);
				return (true);
			}
		}
		return (false);
	}

	public function logout() {
		Session::delete($this->_sessionName);
	}

	public function data() {
		return ($this->_data);
	}

	private function setPass($pw_fields) {
		if (!$pw_fields['user_id'] || !$this->_db->insert('shadow', $pw_fields)) {
			throw new Exception ('There was a prblem creating an account.');
		}
	}

	public function isLoggedIn() {
		return ($this->_isLoggedIn);
	}

}

?>
