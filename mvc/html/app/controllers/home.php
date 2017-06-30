<?php

session_start();

class Home extends Controller {

	public function index($name = '') {
		/*
		$this->view('home/index', array('name' => $user->name));
		*/
		$user = $this->model('User');
		
		if ($user->isLoggedIn()) {
			// load content
			echo "welcome!";
		} else {
			if (!Input::exists()) {
				$token = Token::generate();
				$this->view('home/register', array( 'token' => $token ));
			} else {
				if (Token::check(Input::get('token'))) {
					$validate = new Validate();
					$validate->check($_POST, array(
						'username' => array(
							'required' => true
						),
						'password' => array(
							'required' => true
						),
						'password_again' => array(
							'required' => true,
							'matches' => 'password'
						),
						'name' => array(
							'required' => true
						)
					));
					if ($validate->passed()) {
						echo "Valid!";
					} else {
						echo "Nope!";
					}
				}
			}
		}
	}

	public function hello($name1='', $name2='') {
		echo "hey, $name1!" . "<br />";
		echo "hey, $name2!" . "<br />";
	}

}

?>
