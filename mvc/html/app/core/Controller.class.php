<?php

class Controller {
	
	public function model($model, $args=null) {
		if (file_exists(__DIR__ . '/../models/' . $model . '.class.php')) {
			require_once __DIR__ . '/../models/' . $model . '.class.php';
			if ($args === null)
				return new $model();
			else
				return new $model($args);
		}
		return (null);
	}

	public function view($view, $data = array()) {
		require __DIR__ . '/../views/' . $view . '.php';
	}
}

?>
