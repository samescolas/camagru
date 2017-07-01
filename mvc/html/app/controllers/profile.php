<?php

class Profile extends Controller {
	 private $_user = null;

	 public function index() {
		die("profile");
		$user = $this->model('User');
		if (!$user->isLoggedIn())
			Redirect::to('home');
		$this->view('includes/header');
	 }
}

?>
