<?php

if (!class_exists('Controller'))
	require __DIR__ . '/../init.php';

class UpdateImg extends Controller {
	private $_user;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->_user->shield();
		$this->view('includes/header', array(
			'stylesheets' => array('header'),
			'navs' => array(
				'Logout' => 'logout',
				'Browse' => 'browse',
				'Profile' => 'profile'
			)
		));
	}
	
	public function index($id = '') {
		if ($id == '') {
			Redirect::to('home');
		}
		$image = $this->model('Image', array('image_id' => $id));
		$image->lookup();
		if ($image->userId != $this->_user->data()->id) {
			Session::flash('bad', 'You cannot update another user\'s images.');
			Redirect::to('home');
		}
	}
}

?>
