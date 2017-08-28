<?php

if (!class_exists('Controller'))
	require __DIR__ . '/../init.php';

class UpdateImg extends Controller {
	private $_user;

	public function __construct() {
		$this->_user = $this->model('User');
		$this->_user->shield();
		$this->view('includes/header', array(
			'stylesheets' => array('header', 'form'),
			'navs' => array(
				'Logout' => 'logout',
				'Browse' => 'browse',
				'Profile' => 'profile'
			)
		));
	}
	
	public function index($id=-1) {
		if (preg_match('/submit\/(\d+)/', $id, $matches)) {
			$this->submit($matches[1]);
		} else if ($id < 0) {
			Redirect::to('home');
		}
		$image = $this->model('Image', array('image_id' => $id));
		$image->lookup();
		if ($image->userId != $this->_user->data()->id) {
			Session::flash('bad', 'You cannot update another user\'s images.');
			Redirect::to('home');
		}
		$this->view('forms/updateimg', array (
			'id' => $id,
			'oldTitle' => $image->title
		));
	}

	public function submit($id=-1) {
		if ($id < 0) {
			Session::flash('bad', 'Image not found.');
			Redirect::to('home');
		}
		if (Input::exists() && '' !== Input::get('title')) {
			$image = $this->model('Image', array('image_id' => $id));
			$image->lookup();
			if ($image->userId != $this->_user->data()->id) {
				Session::flash('bad', 'You cannot update another user\'s images.');
				Redirect::to('home');
			}
			try {
				if ($image->updateTitle(Input::get('title')) < 0) {
					Redirect::to('home');
				} else {
					Redirect::to("images/$id");
				}
			} catch (Exception $e) {
				echo "Error: $e";
				Redirect::to('home');
			}
		} else {
			Redirect::to("updateimg/$id");
		}
	}

	public function del($id=-1) {
		Redirect::to("del/$id");
	}
}

?>
