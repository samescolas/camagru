<?php

if (!class_exists('Controller'))
	require __DIR__ . '/../init.php';

class Test extends Controller {
	private $_user;

	public function __construct() {
		$this->_user = $this->model('User');
	}
	
	public function index($data = '') {
		$image = $this->model('Image', array(
			'user_id' => $this->_user->data()->id,
			'filepath' => __DIR__ . '/../../public/resources/uploads/1/46a2fe50ec75340185226d52a82dafcc.png'
		));

		$new = $image->overlayImage("grass");
		header('Content-Type: image/png');
		imagepng($new);
		imagedestroy($new);

	}
}

?>
