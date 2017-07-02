<?php

if (!class_exists('Controller'))
	require_once __DIR__ . '/../init.php';

class Upload extends Controller {
	private $_user = null;
	private $_image = null;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->_user->shield();
	}

	public function index($username = '') {
		if (Input::exists('file')) {
			try {
				$this->_image = $this->model('Image', array(
					'user_id' => $this->_user->data()->id,
					'title' => Input::get('title'),
					'description' => Input::get('description')
				));
				$this->_image->upload();
				$this->_image->display();
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}
		$this->view('includes/header');
		$this->view('profile/upload');
	}

	public function me() {
	
	}
}

?>
