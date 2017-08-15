<?php

if (!class_exists('Controller'))
	require __DIR__ . '/../init.php';

class Verify extends Controller {
	
	public function index($token, $username = '') {
		if ($username !== '') {
			$user = $this->model('User', $username);
			if ($user->verifyEmail($user->data()->id, $token)) {
				Redirect::to('login');
			} else {
				Redirect::to('404');
			}
		}
		Redirect::to(404);
	}
}

?>
