<?php

require_once __DIR__ . '/../init.php';

class Register extends Controller {

	public function index() {
		if (Input::exists()) {
			$validation = $this->validate();
			if ($valdiation !== false && $validation->passed()) {
				$user = $this->model('User');
				$salt = Hash::salt(32);
				$this->registerUser($user, $salt);
				Redirect::to('../home/welcome/' . Input::get('username'));
			} else if($validation !== false) {
				foreach ($validation->errors() as $err) {
					echo "$err <br />";
				}
			}
		}
		$token = Token::generate();
		$this->view('home/register', array( 
			'token' => $token,
			'username' => Input::get('username'),
			'email' => Input::get('email')
		));
	}

	private function registerUser(User $user, $salt) {
		try {
			$user->create(array(
				'username' => Input::get('username'),
				'email' => Input::get('email'),
				'password' => Hash::make(Input::get('password'), $salt),
				'salt' => $salt
			));
		} catch (Exception $e) {
			die($e->getMessage());
		}
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
