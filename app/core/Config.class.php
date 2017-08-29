<?php

class Config {

	public static function get($path = null) {
		if ($path != null) {
			$config = $GLOBALS['config'];
			$path = explode('/', $path);
			foreach ($path as $val) {
				if (isset($config[$val]))
					$config = $config[$val];
				else
					return ("");
			}
			return ($config);
		}
	}
}

?>
