<?php

if (!class_exists("Controller"))
		require_once __DIR__ . '/../init.php';

class Home extends Controller {

	public function index($name = '') {
		$user = $this->model('User');
		
		if ($user->isLoggedIn()) {
			// load content
			Redirect::to('profile/me');
		} else {
			if (!Session::exists(Config::get('session/token_name')))
				Token::generate();
			Redirect::to('welcome');
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
