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
					$this->addError(ucfirst($item) . " is required.");
				} else if (isset($source[$item])) {
					$value = $source[$item];
					switch($rule) {
						case 'filter':
							if (filter_var($value, $rule_value) === false)
								$this->addError(ucfirst($item) . " looks fishy...");
							break ;
						case 'nospace':
							if (preg_match('/\s/', $value) === 1)
								$this->addError(ucfirst($item) . " mustn't contain any spaces.");
							break ;
						case 'alnum':
							if (preg_match('/^[A-z0-9]*$/', $value) !== 1)
								$this->addError(ucfirst($item) . " may only contain letters & numbers.");
							break ;
						case 'regex':
							if (preg_match($rule_value, $value) !== 1)
								$this->addError(ucfirst($item) . " must match $rule_value.");
							break ;
						case 'min':
							if (strlen($value) < $rule_value)
								$this->addError(ucfirst($item) . " must be a min of $rule_value characters.");
							break ;
						case 'max':
							if (strlen($value) > $rule_value)
								$this->addError(ucfirst($item) . " must be a max of $rule_value characters.");
							break ;
						case 'matches':
							if ($value != $source[$rule_value])
								$this->addError("Field must match " . ucfirst($rule_value));
							break ;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item, '=', $value));
							if ($check->count()) {
								$this->addError(ucfirst($item) . " already exists");
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

	public function displayError($err) {
		echo "<div class=\"container\">";
		echo "<p class=\"error\">$err</p>";
		echo "<p class=\"error-close\">X</p>";
		echo  "</div>";
	}

	public function displayErrors() {
		echo "<div id=\"error-container\">";
		foreach($this->_errors as $err) {
			$this->displayError($err);
		}
		echo "</div>";
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
