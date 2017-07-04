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
				'Logout' => 'logout',
				'Browse' => 'browse',
				'Upload Photo' => 'upload',
				'Update Profile' => 'update',
				'Home' => 'home'
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
