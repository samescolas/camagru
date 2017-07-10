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
				'Profile' => 'profile',
				'Home' => 'home'
			)
		));
	}

	public function index($username = '') {
		$images = $this->_user->getImages();
		if ($images) {
			for ($i=0; $i<$images->count(); $i++) {
				$this->_images[] = $this->model('Image', array (
					'user_id' => $this->_user->data()->id,
					'title' => $images->results()[$i]->title,
					'description' => $images->results()[$i]->description,
					'filepath' => $images->results()[$i]->location	
				));
			}
			$this->view('home/profile', array ('images' => $this->_images));
		} else {
			echo "You haven't taken any pictures yet, dumbass!";
		}
		$this->view('includes/footer');
	}

	public function me($data = '') {
		echo "<img src=\"resources/uploads/11/test.png\" >";
	}
}

?>
