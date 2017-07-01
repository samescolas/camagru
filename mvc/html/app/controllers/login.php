<?php

require_once __DIR__ . '/../init.php';

class Login extends Controller {
	
	public function index() {
		if (Input::exists()) {
			$validation = $this->validate_form();
			if ($validation !== false && $validation->passed()) {
				$user = $this->model('User', Input::get('username'));
				$remember = Input::get('remember') === 'on' ? true : false;
				$login = $user->login(Input::get('username'), Input::get('password'), $remember);
				if ($login)
					die("logged in!");
			} else {
				foreach ($validation->errors() as $err) {
					echo "$err <br />";
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
