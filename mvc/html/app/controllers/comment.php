<?php

if (!class_exists('Controller'))
	require __DIR__ . '/../init.php';

class Comment extends Controller {
	private $_user;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->_user->shield();
	}
	
	public function index($imageId = 0) {
		if (Input::exists()) {
			$comment = htmlspecialchars(Input::get('comment'));
			if ($comment != '' && $comment != NULL) {
				$this->_user->comment($imageId, $comment);
			}
			Redirect::to("images/$imageId");
		} else {
			Redirect::to("home");
		}
		die();
		if ($imageId <= 0) {
			Redirect::to(404);
		}
		$this->model('Image', array('image_id' => $imageId))->like($imageId, $this->_user->data()->id);
		Redirect::to('images/'.$imageId);
	}
}

?>
