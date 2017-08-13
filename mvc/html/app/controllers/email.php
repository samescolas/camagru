<?php

class Email extends Controller {
	private $_user = null;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->view('includes/header', array(
			'stylesheets' => array('header'),
			'navs' => array('Logout', 'logout')
		));
		if (!$this->_user->isLoggedIn()) {
			Session::flash('welcome', 'Please log in!');
			Redirect::to('home');
		}
	}

	public function index($username = '') {
		echo "<h3>Please verify your email address.</h3>";
		$this->view('includes/footer');
	}

	public function me($data = '') {
		echo "herE";
	}
}

?>
