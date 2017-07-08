<?php

class Profile extends Controller {
	private $_user = null;
	private $_db = null;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->_db = Database::getInstance();
		$this->_user->shield();
		$this->view('includes/header', array(
			'stylesheets' => array('header'),
			'navs' => array(
				'Logout' => 'logout',
				'Browse' => 'browse',
				'Upload Photo' => 'upload',
				'Update Profile' => 'update',
				'Home' => 'home'
			)
		));
		$this->view('includes/footer');
	}

	public function index($username = '') {
	}

	public function me($data = '') {
		echo "<img src=\"resources/uploads/11/test.png\" >";
	}
}

?>
