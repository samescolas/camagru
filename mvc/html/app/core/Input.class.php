<?php

class Input {
	public static function exists($type = 'post') {
		switch($type) {
			case 'post':
				return ((!empty($_POST)) ? true : false);
				break ;
			case 'get':
				return ((!empty($_GET)) ? true : false);
				break ;
			case 'file':
				return ((!empty($_FILES)) ? true : false);
				break ;
			default:
				return (false);
				break ;
		}
	}

	public static function get($item, $type='post') {
		switch($type) {
			case 'post':
				if (isset($_POST[$item]))
					return ($_POST[$item]);
				break ;
			case 'get':
				if (isset($_GET[$item]))
					return ($_GET[$item]);
				break ;
			case 'file':
				if (iisset($_FILES[$item]))
						return ($FILES[$item]);
		}
		return ("");
	}
}

?>
