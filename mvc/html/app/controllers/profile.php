<?php

class Profile extends Controller {
	private $_user = null;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->_user->shield();
		$this->view('includes/header');
	}

	public function index($username = '') {
		echo "index";
	}

	public function me($data = '') {
		echo "herE";
	}
}

?>
