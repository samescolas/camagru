<?php

class Controller {
	
	public function model($model) {
		if (file_exists(__DIR__ . '/../models/' . $model . '.class.php')) {
			require_once __DIR__ . '/../models/' . $model . '.class.php';
			return new $model();
		}
		return (null);
	}

	public function view($view, $data = array()) {
		require_once __DIR__ . '/../views/' . $view . '.php';
	}
}

?>
