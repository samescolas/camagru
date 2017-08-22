<?php

if (!class_exists('Controller'))
	require __DIR__ . '/../init.php';

class Del extends Controller {
	private $_user;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->_user->shield();
	}
	
	public function index($id = '') {
		if ($id == '') {
			Session::flash('bad', 'Something went wrong.');
			Redirect::to('home');
		}
		$image = $this->model('Image', array('image_id' => $id));
		$image->lookup();
		if ($image->userId != $this->_user->data()->id) {
			Session::flash('bad', 'You cannot delete another user\'s images.');
			Redirect::to('home');
		}
		$image->del();
		Session::flash('welcome', 'Image deleted');
		Redirect::to('home');
	}
}

?>
