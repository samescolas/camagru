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
			'stylesheets' => array('header', 'browse'),
			'navs' => array(
				'Logout' => 'logout',
				'Change Password' => 'changepassword'
			)
		));
	}

	public function index($page=0) {
		if ($page == 0) {
			Redirect::to('browse/1');
		}
		$this->_images = $this->_user->getImages(True);
		$this->_pages = (count($this->_images) / 6) + 1;
		if (count($this->_images) <= 0) {
			echo "There are no images to display.";
		}
		if ($page < 0 || $page > $this->_pages) {
			Redirect::to(404);
		}
		echo "<div id=\"main-content\">";
		$toDisplay = array_slice($this->_images, ($page - 1) * 6, 6);
		foreach ($toDisplay as $img) {
			$this->view('dispimg', array(
				'all' => True,
				'comments' => True,
				'likes' => True,
				'image' => $img
			));
		}
		echo "</div>";
		$this->view('pagination', array(
			'base' => 'browse',
			'pages' => $this->_pages,
			'current' => $page
		));
		$this->view('includes/footer');
	}
}

?>
