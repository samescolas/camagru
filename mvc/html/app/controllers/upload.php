<?php

class Upload extends Controller {
	 private $_user = null;

	 public function __construct() {
		$this->_user = $this->model('User');
		$this->_user->shield();
		echo "upload!";
	 }

	 public function index($username) {
	 }

	 public function me() {
		
	 }
}

?>
