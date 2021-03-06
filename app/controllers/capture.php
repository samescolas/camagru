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
		if (Input::exists('file')) {
			$image = $this->model('Image', array(
				'title' => 'CAMAGRU',
				'description' => 'Captured ' . date('Y-m-d H:m:s', time()),
				'user_id' => $this->_user->data()->id
			));
			$image->upload();
			echo "<a href=\"images/" . $image->imageId . "\">";
			$image->display(25, False);
			echo "</a>";
		} else {
			Redirect::to('camagru');
		}
	}
}

?>
