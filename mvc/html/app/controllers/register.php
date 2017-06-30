<?php

class Register extends Controller {
	public function index() {
		if (Input::exists() && $this->validate()) {
			$user = $this->model('User');
			$salt = Hash::salt(32);
			$this->registerUser($user, $salt);
		} else {
			$token = Token::generate();
			$this->view('home/register', array( 'token' => $token ));
		}
	}

	private function registerUser(User $user, $salt) {
		try {
			$user->create(array(
				'username' => Input::get('username'),
				'password' => Hash::make(Input::get('password'), $salt),
				'salt' => $salt
			));
		} catch (Exception $e) {
			die($e->getMessage());
		}
		Redirect::to('../home/welcome/' . Input::get('username'));
	}

	private function validate() {
		if (Token::check(Input::get('token'))) {
			$validate = new Validate();
			$validate->check($_POST, array(
				'username' => array(
					'required' => true,
					'min' => 8,
					'max' => 32,
					'unique' => 'users'
				),
				'password' => array(
					'required' => true,
					'min' => 8
				),
				'password_again' => array(
					'required' => true,
					'min' => 8,
					'matches' => 'password'
				)
			));
			return ($validate->passed());
		}
		return (false);
	}
}

?>
