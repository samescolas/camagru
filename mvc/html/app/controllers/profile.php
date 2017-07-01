<?php

class Profile extends Controller {
	 private $_user = null;

	 public function index($username) {
		$user = $this->model('User');
		if (!$user->isLoggedIn())
			Redirect::to('home');
		$this->view('includes/header');
	 }

	 public function me() {
		$this->view('includes/header');
		die("my page");
	 }
}

?>
