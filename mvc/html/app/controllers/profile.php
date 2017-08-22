<?php

class Profile extends Controller {
	private $_user = null;
	private $_db = null;
	private $_images = null;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->_db = Database::getInstance();
		$this->_images = array();
		$this->_user->shield();
		$this->view('includes/header', array(
			'stylesheets' => array('header', 'profile'),
			'navs' => array(
				'Logout' => 'logout',
				'Browse' => 'browse',
				'Upload Photo' => 'upload',
				'Change Password' => 'changepassword',
			)
		));
	}

	public function index($username = '') {
		$this->_images = $this->_user->getImages();
		if ($this->_images) {
			$this->view('home/profile', array ('images' => $this->_images));
		}
		 else {
			echo "You haven't taken any pictures yet, come back later!";
		}
		$this->view('includes/footer');
	}

	public function me($data = '') {
		echo "<img src=\"resources/uploads/11/test.png\" >";
	}
}

?>
