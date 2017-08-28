<?php

class Browse extends Controller {
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
				'Profile' => 'profile'
			)
		));
	}

	public function index($page=1) {
		$this->_images = $this->_user->getImages(True);
		if (count($this->_images) <= 0) {
			echo "There are no images to display.";
		}
		if ($page < 0 || $page - 1 > count($this->_images) / 6) {
			Redirect::to(404);
		}
		if ($this->_images) {
			$this->view('home/profile', array('images' => array_slice($this->_images, ($page - 1) * 6, 6)));
		}
		 else {
			echo "Camagru hasn't taken any pictures yet, come back later!";
		}
		$this->view('includes/footer');
	}
}

?>
