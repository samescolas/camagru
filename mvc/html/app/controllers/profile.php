<?php

class Profile extends Controller {
	private $_user = null;

	public function __construct() {
		$this->_user = $this->model('User');
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
	}

	public function index($username = '') {
	}

	public function me($data = '') {
		echo "herE";
	}
}

?>
