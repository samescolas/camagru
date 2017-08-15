<?php

include __DIR__ . '/Image.class.php';

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
		Cookie::put(Config::get('remember/stamp'), '1', Config::get('remember/cookie_expiry'));
	}

	public function find($user = null) {
		if ($user) {
		$fields = "SELECT u.id, u.username, u.email, u.dt_joined, s.passwd, s.salt, v.token";
		$tbls = 
			"users u
			LEFT JOIN shadow s ON s.user_id = u.id
			LEFT JOIN email_verification v ON v.user_id = u.id";		
			if (preg_match('/^\d+$/', $user)) {
				$data = $this->_db->action($fields, $tbls, array('u.id', '=', $user));
			} else {
				$data = $this->_db->action($fields, $tbls, array('u.username', '=', $user));
			}

			if ($data && $data->count()) {
				$this->_data = $data->first();
				return (true);
			}
		}
		return (false);
	}

	public function shield() {
		if (!$this->isLoggedIn()) {
			Session::flash('welcome', 'Please log in first!');
			Redirect::to('home');
		} else if (!$this->isVerified()) {
			Redirect::to('email');
		}
	}

	public function getImages() {
		$ret = array();
		if (!$this->data()->id) {
			return (false);
		}
		$images = $this->_db->get('images', array('user_id', '=', $this->data()->id))->results();
		if (count($images)) {
			for ($i=0; $i<count($images); $i++) {
				$ret[] = new Image(array(
					'image_id' => $images[$i]->id,
					'user_id' => $this->data()->id,
					'title' => $images[$i]->title,
					'description' => $images[$i]->description,
					'filepath' => $images[$i]->location
				));
				$ret[$i]->getComments();
				$ret[$i]->getLikes();
			}
			return ($ret);
		}
		return (false);
	}

	public function isVerified() {
		if (!$this->isLoggedIn() || $this->data()->token) {
			return (false);
		}
		return (true);
	}

	public function update($fields = array(), $id = null) {
		/* If no user specified, use current. */
		if (!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		}
		if (!$this->_db->update('users', $id, $fields)) {
			throw new Exception('There was a problem updating your shit.');
		}
	}

	public function resendValidationEmail($fields) {
		$this->_db->del('email_verification', array('user_id', '=', $this->data()->id));
		$this->validateEmail($fields);
	}

	public function validateEmail($fields) {
		$token = Token::create();
		$this->_db->insert('email_verification', array(
			'user_id' => $this->data()->id,
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
			$this->_db->del('email_verification', array('user_id', '=', $this->data()->id));
			return $this->validateEmail($fields);
		}
		$link = "http://" . $_SERVER['SERVER_NAME'] . "/verify/" . $token . "/" . $fields['username'];
		$msg = "Welcome to Camagru, " . $fields['username'] .
			"!\nPlease follow this link to verify your email address.\n";
		mail(
			$fields['email'],
			"Email Verification",
			$msg . $link,
			null,
			'-f guru@camagru.com');
	}

	public function login($username = null, $password = null, $remember = false) {

		if (!$username && !$password && $this->exists()) {
			Session::put($this->_sessionName, $this->data()->id);
		} else {

			$user = $this->find($username);
			if ($user) {
				if ($this->data()->passwd === Hash::make($password, $this->data()->salt)) {
					Session::put($this->_sessionName, $this->data()->id);
		
					if ($remember) {
						$hash = Hash::unique();
						$hashCheck = $this->_db->get('sessions', array('user_id', '=', $this->data()->id));
						if (!$hashCheck->count()) {
	
							$this->_db->insert('sessions', array(
								'user_id' =>$this->data()->id,
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

	public function updatePassword($newpw) {
		$this->_db->del('shadow', array('user_id', '=', $this->data()->id));
		$salt = Hash::salt(32);
		$pw_fields = array(
			'user_id' => $this->data()->id,
			'passwd' => Hash::make($newpw, $salt),
			'salt' => $salt
		);
		$this->setPass($pw_fields);
	}

	public function logout() {
		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
		$this->_db->del('sessions', array('user_id', '=', $this->data()->id));
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
