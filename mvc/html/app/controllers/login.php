<?php

if (!class_exists('Controller'))
	require __DIR__ . '/../init.php';

class Login extends Controller {
	private $_user;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->view('includes/header', array(
			'stylesheets' => array('header', 'form'),
			'scripts' => array('flash'),
			'navs' => array(
				'Register' => 'register',
				'Browse' => 'browse',
				'Home' => 'home'
			)
		));
	}

	public function index() {
		if ($this->_user->isLoggedIn())
			Redirect::to('home');

		if (Input::exists()) {
			$validation = $this->validate_form();
			if ($validation !== false && $validation->passed()) {
				$this->loginUser();
			} else if($validation !== false) {
				$validation->displayErrors();
			}
		}
		if (Session::exists(Config::get('session/token_name')))
			$token  = Session::get(Config::get('session/token_name'));
		else
			$token = Token::generate();
		$this->view('forms/login', array( 
			'token' => $token,
			'username' => Input::get('username'),
			'email' => Input::get('email')
		));
		$this->view('includes/footer');
	}

	private function loginUser() {
		$remember = Input::get('remember') === 'on' ? true : false;
		$login = $this->_user->login(Input::get('username'), Input::get('password'), $remember);
		if (!$login) {
			Session::flash('bad', 'Invalid login credentials');
			Redirect::to('login');
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
				'required' => true
			),
			'password' => array(
				'required' => true
			)
		));
		return ($validate);
	}
}

?>
