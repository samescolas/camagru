<?php

if (!class_exists('Controller'))
	require __DIR__ . '/../init.php';

class Verify extends Controller {
	
	public function index($token, $username = '') {
		if ($username !== '') {
			$user = $this->model('User', $username);
			print_r($user);
			if ($user->verifyEmail($user->data()->id, $token)) {
				Redirect::to('../../home/');
			}
		}
		Redirect::to(404);
	}
}

?>
