<?php

if (!class_exists('Controller'))
	require __DIR__ . '/../init.php';

class Capture extends Controller {
	private $_user;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->_user->shield();
	}
	
	public function index($data = '') {
		if (Input::exists()) {
			$image = Input::get('image');
			echo $image[0];
		}
	}
}

?>
