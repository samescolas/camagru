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
			$validation = $this->validate_form();
			if ($validation !== false && $validation->passed()) {
				try {
					$this->_image = $this->model('Image', array(
						'user_id' => $this->_user->data()->id,
						'title' => Input::get('title'),
						'description' => Input::get('description')
					));
					$this->_image->upload();
				} catch (Exception $e) {
					die($e->getMessage());
				}
			} else if ($validation !== false) {
				foreach($validation->errors() as $err) {
					echo "<p class=\"err-msg\">$err </p>";
				}
			}
		}
		$this->view('includes/header', array(
			'stylesheets' => array('header', 'form'),
			'navs' => array(
				'Logout' => 'logout',
				'Browse' => 'browse',
			)
		));
		$this->view('profile/upload');
		$this->view('includes/footer');
	}

	private function validate_form() {
		$validate = new Validate();
		$validate->check($_POST, array(
			'title' => array(
				'required' => true,
				'max' => 32
			),
			'description' => array(
				'required' => true
			)
		));
		if ($validate)
			return ($validate);
		return (false);
	}

}

?>
