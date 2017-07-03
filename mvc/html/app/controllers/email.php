<?php

class Email extends Controller {
	private $_user = null;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->view('includes/header', array('stylesheets' => array('header')));
		if (!$this->_user->isLoggedIn()) {
			Session::flash('welcome', 'Please log in!');
			Redirect::to('home');
		}
		//$this->view('');
	}

	public function index($username = '') {
		echo "Verify!";
	}

	public function me($data = '') {
		echo "herE";
	}
}

?>
