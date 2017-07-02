<?php

require_once __DIR__ . '/../init.php';

class Welcome extends Controller {

	public function index($action = '') {
		echo Session::flash('welcome');
		echo Session::flash('probs');
		$user = $this->model('User');
		if ($user->isLoggedIn())
			Redirect::to('home');

		if ($action !== '' && Input::exists()) {
			$validation = $this->validate_form($action);
			if ($validation !== false && $validation->passed()) {
				if ($action == 'register') {
					$this->registerUser($user);
					Session::flash('welcome', 'You have successfully registered!');
				}
				else if ($action == 'login') {
					$this->loginUser($user);
				}
				Redirect::to('home');
			} else if($validation !== false) {
				foreach ($validation->errors() as $err) {
					echo "$err <br />";
				}
			}
		}
		$this->view('includes/header', array('stylesheets' => array('header')));
		$this->view('home/welcome', array( 
			'token' => Session::get(Config::get('session/token_name')),
			'username' => Input::get('username'),
			'email' => Input::get('email')
		));
	}

	private function loginUser(User $user) {
		$remember = Input::get('remember') === 'on' ? true : false;
		$login = $user->login(Input::get('username'), Input::get('password'), $remember);
		if (!$login) {
			Session::flash('probs', 'Invalid login credentials');
			Redirect::to('welcome');
		}
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

	private function validate_form($action) {
		if (!Token::check(Input::get('token'))) {
			echo 'token probs';
			return (false);
		}

		$validate = new Validate();
		if ($action == 'login') {
			$validate->check($_POST, array(
				'username' => array(
					'required' => true
				),
				'password' => array(
					'required' => true
				)
			));
			return ($validate);
		} else if ($action == 'register') {
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
