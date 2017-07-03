<?php

if (!class_exists('Controller'))
	require __DIR__ . '/../init.php';

class Register extends Controller {
	private $_user;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->view('includes/header', array(
			'stylesheets' => array('header', 'form'),
			'scripts' => array('flash')
		));
	}

	public function index() {
		if (Session::exists('welcome') || Session::exists('bad')) {
			echo "<div id=\"flash-container\">";
			if (Session::exists('welcome'))
				echo "<p class=\"flash\">" . Session::flash('welcome') . "</p>";
			if (Session::exists('bad'))
				echo "<p class=\"flash\">" . Session::flash('bad') . "</p>";
			echo "</div>";
		}
		if ($this->_user->isLoggedIn())
			Redirect::to('home');

		if (Input::exists()) {
			$validation = $this->validate_form();
			if ($validation !== false && $validation->passed()) {
				$this->registerUser($this->_user);
				Session::flash('welcome', 'You have successfully registered!');
				Redirect::to('home');
			} else if($validation !== false) {
				$validation->displayErrors();
			}
		}

		$this->view('home/register', array( 
			'token' => Session::get(Config::get('session/token_name')),
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
		if (!Token::check(Input::get('token'))) {
			//echo 'token probs';
			return (false);
		}

		$validate = new Validate();
		$validate->check($_POST, array(
			'username' => array(
				'required' => true,
				'nospace' => true,
				'min' => 8,
				'max' => 32,
				'alnum' => true,
				'unique' => 'users'
			),
			'email' => array(
				'name' => 'Email Address',
				'nospace' => true,
				'required' => true,
				'filter' => FILTER_SANITIZE_EMAIL,
				'filter' => FILTER_VALIDATE_EMAIL,
				'unique' => 'users'
			),
			'password' => array(
				'required' => true,
				'min' => 8,
				'regex' => '/\d+/',
				'regex' => '/\W+/'
			),
			'password_again' => array(
				'required' => true,
				'matches' => 'password'
			)
		));
		return ($validate);
	}
}

?>
