<?php

class Camagru extends Controller {
	private $_user = null;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->_user->shield();
		$this->view('includes/header', array(
			'scripts' => array('camagru'),
			'stylesheets' => array('header', 'camagru'),
			'navs' => array(
				'Home' => 'home',
				'Update Profile' => 'update',
				'Upload Photo' => 'upload',
				'Browse' => 'browse',
				'Logout' => 'logout'
			)
		));
	}

	public function index($username = '') {
		$this->view('camera/capture');
	}

	public function me($data = '') {
		echo "herE";
	}
}

?>
