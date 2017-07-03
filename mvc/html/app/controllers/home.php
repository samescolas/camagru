<?php

if (!class_exists('Controller'))
		require_once __DIR__ . '/../init.php';

class Home extends Controller {
	private $_user;

	public function __construct() {
		$this->_user = $this->model('User');
	}

	public function index($name = '') {
		
		if ($this->_user->isLoggedIn() && $this->_user->isVerified()) {
			Redirect::to('camagru');
		}
		else if ($this->_user->isLoggedIn()) {
			Redirect::to('email');
		}
		else if (Cookie::exists(Config::get('remember/stamp'))) {
			Redirect::to('login');
		}
		if (!Session::exists(Config::get('session/token_name')))
			Token::generate();
		Redirect::to('register');
	}

	public function register() {
		echo "heyy";
	}

	public function welcome($name='') {
		echo "Hey, $name!" . "<br />";
	}

}

?>
