<?php

class Home extends Controller {

	public function index($name = '') {
		$user = $this->model('User');
		$user->name = $name;

		$this->view('home/index', array('name' => $user->name));
	}

	public function hello($name1='', $name2='') {
		echo "hey, $name1!" . "<br />";
		echo "hey, $name2!" . "<br />";
	}

}

?>
