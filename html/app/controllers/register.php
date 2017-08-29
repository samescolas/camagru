<?php

if (!class_exists('Controller'))
	require __DIR__ . '/../init.php';

class Register extends Controller {
	private $_user;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->view('includes/header', array(
			'stylesheets' => array('header', 'form'),
			'scripts' => array('flash'),
			'navs' => array(
				'Login' => 'login'
			)
		));
	}

	public function index() {
		if ($this->_user->isLoggedIn())
			Redirect::to('home');

		if (Input::exists()) {
			$validation = $this->validate_form();
			if ($validation !== false && $validation->passed()) {
				$this->registerUser($this->_user);
				exit();
			} else if($validation !== false) {
				$validation->displayErrors();
			}
		}

		if (Session::get(Config::get('session/token_name')) !== null)
			$token = Session::get(Config::get('session/token_name'));
		else
			$token = Token::generate();
		$this->view('forms/register', array( 
			'token' => $token,
			'username' => Input::get('username'),
			'email' => Input::get('email')
		));
		$this->view('includes/footer');
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
			Session::flash('welcome', 'You have successfully registered!');
			header('Location: http://' . $_SERVER['SERVER_NAME'] . '/login');
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
			echo 'token probs';
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
