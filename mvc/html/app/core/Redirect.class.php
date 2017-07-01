<?php

class Redirect {
	public static function to($location = null) {
		if ($location) {
			if (is_numeric($location)) {
				switch($location) {
					case 404:
						header('HTTP/1.1 404 Not Found');
						include 'includes/errors/404.php';
						exit();
					break ;
				}
			}

			$location = "http://" . $_SERVER['SERVER_NAME'] . "/$location/";
			header('Location: ' . $location);
			exit();
		}
	}
}

?>
