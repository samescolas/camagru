<?php

class Camagru extends Controller {
	private $_user = null;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->_user->shield();
		$this->view('includes/header', array(
			'scripts' => array('camagru', 'overlay'),
			'stylesheets' => array('header', 'camagru'),
			'navs' => array(
				'Logout' => 'logout',
				'Browse' => 'browse',
				'Upload Image' => 'upload'
			)
		));
	}

	public function index($username = '') {
		$userImages = $this->_user->getImages();
		$this->view('camera/capture', array(
			'overlayUrls' => array(),
			'images' => $userImages
		));
		$this->view('includes/footer');
	}
}

?>
