<?php

require_once __DIR__ . '/../init.php';

class Register extends Controller {

	/*
	** Validate and submit form. Token for CSRF protection.
	*/
	public function index($token) {
		if (Input::exists()) {
			$validation = $this->validate_form();
			if ($validation !== false && $validation->passed()) {
				$user = $this->model('User');
				$this->registerUser($user);
				Redirect::to('login');
			} else if($validation !== false) {
				foreach ($validation->errors() as $err) {
					echo "$err <br />";
				}
			}
		}
		$this->view('home/register', array( 
			'token' => $token,
			'username' => Input::get('username'),
			'email' => Input::get('email')
		));
	}

	private function registerUser(User $user) {
		$salt = Hash::salt(32);
		try {
			$user->create(array(
				'username' => Input::get('username'),
				'email' => Input::get('email'),
				'password' => Hash::make(Input::get('password'), $salt),
				'salt' => $salt
			));
			$user->validateEmail(array(
				'username' => Input::get('username'),
				'email' => Input::get('email')
			));
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	private function validate_form() {
		if (Token::check(Input::get('regtok'))) {
			$validate = new Validate();
			$validate->check($_POST, array(
				'username' => array(
					'required' => true,
					'min' => 8,
					'max' => 32,
					'unique' => 'users'
				),
				'email' => array(
					'name' => 'Email Address',
					'required' => true,
					'filter' => FILTER_SANITIZE_EMAIL,
					'filter' => FILTER_VALIDATE_EMAIL,
					'unique' => 'users'

				),
				'password' => array(
					'required' => true,
					'min' => 8
				),
				'password_again' => array(
					'required' => true,
					'matches' => 'password'
				)
			));
			return ($validate);
		}
		return (false);
	}
}

?>
