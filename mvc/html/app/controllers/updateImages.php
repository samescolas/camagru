<?php

if (!class_exists('Controller'))
	require __DIR__ . '/../init.php';

class updateImage extends Controller {
	private $_user;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->_user->shield();
		$this->view('includes/header', array(
			'stylesheets' => array('header', 'form'),
			'scripts' => array('flash'),
			'navs' => array(
				'Logout' => 'logout',
				'Browse' => 'browse',
				'Upload Photo' => 'upload',
				'Home' => 'home'
			)
		));
	}
	
	public function index($data = '') {
		if (Input::exists()) {
			$this->_user->updatePassword(Input::get('newpw'));
			Session::flash('welcome', 'Password updated.');
			Redirect::to('home');
		}
		$this->view('forms/change_pass', array('token' => $token));
		$this->view('includes/footer');
	}

}

?>
