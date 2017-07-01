<?php

class Home extends Controller {

	public function index($name = '') {
		//$this->view('home/index', array('name' => $user->name));
		$user = $this->model('User');
		
		if ($user->isLoggedIn()) {
			// load content
			echo "welcome!";
		} else {
			$token = Token::generate();
			$this->view('home/register', array('token', $token));
			Redirect::to('../register/' . $token);
		}
	}

	public function welcome($name='') {
		echo "Hey, $name!" . "<br />";
	}

}

?>
