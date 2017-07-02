<?php

if (!class_exists('Controller'))
	require_once __DIR__ . '/../init.php';

class Upload extends Controller {
	private $_user = null;
	private $_image = null;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->_user->shield();
		$this->_image = $this->model('Image');
	}

	public function index($username = '') {
		if (Input::exists('file')) {
			try {
				$this->_image->upload();
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}
		$this->view('profile/upload');
	}

	public function me() {
	
	}
}

?>
