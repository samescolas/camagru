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
			$image = $this->model('Image', array(
				'title' => 'Screenshot 1',
				'description' => 'Captured ' . date('Y-m-d H:m:s', time()),
				'user_id' => $this->_user->data()->id
			));
			echo "created image!!";
			$image->display();
				/*
			$image = Input::get('data');
			$data = preg_replace('/^data:image\/\w+;base64,/i', '', $image);
			echo $data;
			//file_put_contents("../test_img.png", $data);
			echo "I did it!";
			*/
		} else {
			print_r($_POST);
			print_r($_GET);
			print_r($_FILES);
			echo $data;
			echo "nope";
			die();
		}
	}
}

?>
