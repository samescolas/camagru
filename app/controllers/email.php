<?php

class Email extends Controller {
	private $_user = null;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->view('includes/header', array(
			'stylesheets' => array('header', 'form'),
			'navs' => array('Logout' => 'logout')
		));
		if (!$this->_user->isLoggedIn()) {
			Session::flash('welcome', 'Please log in!');
			Redirect::to('home');
		}
		Session::flash('welcome');
	}

	public function index($username = '') {
		if ($this->_user->isLoggedIn() && $this->_user->isVerified()) {
			Redirect::to('home');
		}
		Session::flash('welcome', 'Email sent!');
		echo "<h3>Please verify your email address.</h3><br />";
		echo "<form action=\"email/resend\">";
		echo "<input type=\"submit\" value=\"Resend email\">";
		echo "<form>";
		$this->view('includes/footer');
	}

	public function resend() {
		if (!$this->_user->isLoggedIn() && $this->_user->isVerified())
			Redirect::to('home');
		$this->_user->resendValidationEmail(array(
			'username' => $this->_user->data()->username,
			'email' => $this->_user->data()->email
		));
		Session::flash('welcome', 'Email sent!');
		Redirect::to('home');
	}
}

?>
