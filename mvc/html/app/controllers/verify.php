<?php

require_once __DIR__ . '/../init.php';

class Verify extends Controller {
	
	public function index($token, $username = '') {
		if ($username !== '') {
			$user = $this->model('User', $username);
			if ($user->verifyEmail($user->data()->user_id, $token)) {
				Redirect::to('../../home/');
			}
		}
		Redirect::to(404);
	}
}

?>
