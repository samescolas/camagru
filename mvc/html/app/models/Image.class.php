<?php

class Image {
	private $_db;
	public $filepath;
	public $filename;

	public function __construct($name = '') {
		$this->_db = Database::getInstance();
		if (Input::exists('file')) {
			if ($name != '')
				$this->filename = $name;
			else
				$this->filename = $_FILES['fileToUpload'];
		}
	}

	public function upload() {
		if ($this->checkFileSize() && $this->checkFileType()) {
			$destination =  __DIR__ . '/../../public/resources/uploads/';
			if (!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $destination . $_FILES['fileToUpload']['name'])) {
				throw new Exception("Something went wrong.");
			}
		} else {
			throw new Exception("Invalid file.");
		}
	}

	public function checkFileSize() {
		if ($_FILES['fileToUpload']['size'] <= Config::get('max_file_size'))
			return (true);
		return (false);
	}
	
	public function checkFileType() {
		$check = getimagesize($_FILES['fileToUpload']['tmp_name']);
		if ($check !== false)
			return (true);
		return (false);
	}

}
