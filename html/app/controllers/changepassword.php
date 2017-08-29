<?php

if (!class_exists('Controller'))
	require __DIR__ . '/../init.php';

class ChangePassword extends Controller {
	private $_user;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->_user->shield();
		$this->view('includes/header', array(
			'stylesheets' => array('header', 'form'),
			'scripts' => array('flash'),
			'navs' => array(
				'Logout' => 'logout',
				'Browse' => 'browse',
			)
		));
	}
	
	public function index($data = '') {
		if (Input::exists()) {
			$validation = $this->validate_form();
			if ($validation !== false && $validation->passed()) {
			{
				$this->_user->updatePassword(Input::get('newpw'));
				Session::flash('welcome', 'Password updated.');
				Redirect::to('home');
			}
			} else if ($validation !== false) {
				$validation->displayErrors();
			}
		}
		if (Session::get(Config::get('session/token_name')) != null)
			$token = Session::get(Config::get('session/token_name'));
		else
			$token = Token::generate();
		$this->view('forms/change_pass', array('token' => $token));
		$this->view('includes/footer');
	}

	private function validate_form() {
		if (!Token::check(Input::get('token'))) {
			echo "Unable to validate form. Please try again.";
			die();
		}

		$validate = new Validate();
		$validate->check($_POST, array(
			'oldpw' => array(
				'required' => true
			),
			'newpw' => array(
				'required' => true,
				'min' => 8,
				'regex' => '/\d+/',
				'regex' => '/\W+/'
			),
			'new2' => array(
				'required' => true,
				'min' => 8,
				'regex' => '/\d+/',
				'regex' => '/\W+/',
				'matches' => 'newpw'
			)
		));
		return ($validate);
	}
}

?>
