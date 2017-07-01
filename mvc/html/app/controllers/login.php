<?php

require_once __DIR__ . '/../init.php';

class Login extends Controller {
	
	public function index() {
		$user = $this->model('User');
		if ($user->isLoggedIn()) {
			Redirect::to('home');
		}
		if (Input::exists()) {
			$validation = $this->validate_form();
			if ($validation !== false && $validation->passed()) {
				$remember = Input::get('remember') === 'on' ? true : false;
				$login = $user->login(Input::get('username'), Input::get('password'), $remember);
				if ($login)
					Redirect::to('home');
			} else if ($validation !== false) {
				foreach ($validation->errors() as $error) {
					echo "$error <br />";
				}
			}
		}
		$this->view('home/login');
	}

	private function validate_form() {
		if (Token::check(Input::get('token'))) {
			$validate = new Validate();
			$validate->check($_POST, array(
				'username' => array(
					'required' => true
				),
				'password' => array(
					'required' => true
				)
			));
			return ($validate);
		}
		return (false);
	}
}

?>
