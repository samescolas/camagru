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
				if ($rule == 'required' && $rule_value === true && empty($source[$item])) {
					$this->addError("$item is required");
				} else if (isset($source[$item])) {
					$value = $source[$item];
					switch($rule) {
						case 'filter':
							if (filter_var($value, $rule_value) === false)
								$this->addError("$item looks fishy...");
							break ;
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
		return ($this->_passed);
	}

	private function addError($error) {
		$this->_errors[] = $error;
	}

	public function errors() {
		return ($this->_errors);
	}
}

?>
