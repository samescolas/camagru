<?php

class Images extends Controller {
	private $_user = null;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->_user->shield();
		$this->view('includes/header', array(
			'scripts' => array('camagru'),
			'stylesheets' => array('header', 'images'),
			'navs' => array(
				'Logout' => 'logout',
				'Browse' => 'browse',
				'Upload Image' => 'upload',
				'Profile' => 'profile'
			)
		));
	}

	public function index($id = '') {
		$image = $this->model('Image', array(
			'image_id' => $id
		));
		$image->lookup();
		echo "<div id=\"image-container\">";
			$image->display();
		echo "</div>";
		if ($image->userId == $this->_user->data()->id) {
			// mine
		} else {
			// others
		}
		$this->view('includes/footer');
	}
}

?>
