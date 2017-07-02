<?php

class User {
	private $_db;
	private $_data;
	private $_sessionName;
	private $_isLoggedIn;
	private $_cookieName;

	public function __construct($user = null) {
		$this->_db = Database::getInstance();
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');

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
		$user_fields = array(
			'username' => $fields['username'],
			'email' => $fields['email']
		);
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
		$this->find($id);
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

	public function shield() {
		if (!$this->isLoggedIn()) {
			Session::flash('welcome', 'Please log in first!');
			Redirect::to('home');
		}
	}

	public function update($fields = array(), $id = null) {
		/* If no user specified, use current. */
		if (!$id && $this->isLoggedIn()) {
			$id = $this->data()->user_id;
		}
		if (!$this->_db->update('users', $id, $fields)) {
			throw new Exception('There was a problem updating your shit.');
		}
	}

	public function updatePassword($fields) {
		if (!$this->_db->update('shadow', $this->data()->id, $fields)) {
			throw new Exception('Unable to update password');
		}
	}

	public function validateEmail($fields) {
		$token = Token::create();
		//$id = $this->_db->get('users', array('email', '=', $fields['email']))->first()->id;
		$this->_db->insert('email_verification', array(
			'user_id' => $this->data()->user_id,
			'token' => $token
		));
		$this->sendValidationEmail($fields, $token);
	}

	public function verifyEmail($id, $token) {
		$data = $this->_db->get('email_verification', array('user_id', '=', $id))->first();
		if ($data->token == $token) {
			$this->_db->del('email_verification', array('user_id', '=', $id));
			return (true);
		}
		return (false);
	}

	private function sendValidationEmail($fields, $token = null) {
		if (!$token) {
			$this->_db->del('email_verification', array('user_id', '=', $this->data()->user_id));
			return $this->validateEmail($fields);
		}
		$link = "http://" . $_SERVER['SERVER_NAME'] . "/verify/" . $token . "/" . $fields['username'];
		$msg = "Welcome to Camagru, " . $fields['username'] .
			"!\nPlease follow this link to verify your email address.\n";
		mail($fields['email'], "Email Verification", $msg . $link);
	}

	public function login($username = null, $password = null, $remember = false) {
		$user = $this->find($username);

		if (!$username && !$password && $this->exists()) {
			Session::put($this->_sessionName, $this->data()->user_id);
		} else {

			if ($user) {
				if ($this->data()->passwd === Hash::make($password, $this->data()->salt)) {
					Session::put($this->_sessionName, $this->data()->user_id);
		
					if ($remember) {
						$hash = Hash::unique();
						$hashCheck = $this->_db->get('sessions', array('user_id', '=', $this->data()->user_id));
						if (!$hashCheck->count()) {
	
							$this->_db->insert('sessions', array(
								'user_id' =>$this->data()->user_id,
								'hash' => $hash
							));
						} else {
							$hash = $hashCheck->first()->hash;
						}
						Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
					}
					return (true);
				}
			}
		}
		return (false);
	}

	public function logout() {
		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
		$this->_db->del('sessions', array('user_id', '=', $this->data()->user_id));
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

	public function exists() {
		if (!empty($this->_data))
			return (true);
		else
			return (false);
	}

}

?>
