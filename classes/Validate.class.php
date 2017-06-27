<?php

class Validate {
	private $_passed = false;
	private $_errors = array();
	private $_db = null;

	public function __construct() {
		$this->_db = Database::getInstance();
	}


	public function check($source, $items = array()) {
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				$value = $source[$item];
				if ($rule == 'required' && $rule_value && empty($value)) {
					$this->addError("$item is required");
				} else if (!empty($value)) {
					switch($rule) {
						case 'min':
							if (strlen($value) < $rule_value)
								$this->addError("$item must be a min of $rule_value characters.");
							break ;
						case 'max':
							if (strlen($value) > $rule_value)
								$this->addError("$item must be a max of $rule_value characters.");
							break ;
						case 'matches':
							if ($value != $source[$rule_value])
								$this->addError("$rule_value must match $item");
							break ;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item, '=', $value));
							if ($check->count()) {
								$this->addError("$item already exists");
							}
							break ;
					}
				}
			}
		}
		if (empty($this->errors())) {
				$this->_passed = true;
		}
	}

	public function passed() {
//		return ($this->_passed);
		return (false);
	}

	private function addError($error) {
		$this->_errors[] = $error;
	}

	public function errors() {
		return ($this->_errors);
	}
}

?>
