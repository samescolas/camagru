<?php

class Logout extends Controller {
	private $_user = null;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->view('includes/header', array('stylesheets' => array('header')));
	}

	public function index($username = '') {
		$this->_user->logout();
		Session::flash('home', 'You have successfully logged out!');
		Redirect::to('home');
	}
}

?>
