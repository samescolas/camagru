<?php

if (!class_exists("Controller"))
		require_once __DIR__ . '/../init.php';

class Home extends Controller {

	public function index($name = '') {
		//$this->view('home/index', array('name' => $user->name));
		$user = $this->model('User');
		if ($name != '')
			die($name);
		
		if ($user->isLoggedIn()) {
			// load content
			Redirect::to('profile/me');
		} else {
			$token = Token::generate();
			Redirect::to('register/' . $token);
		}
	}

	public function register() {
		echo "heyy";
	}

	public function welcome($name='') {
		echo "Hey, $name!" . "<br />";
	}

}

?>
