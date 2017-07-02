<?php

class Image {
	private $_db;
	private $_saveDir;
	private $_filepath;
	public $title;
	public $description;
	public $userId;
	public $size;
	public $image;
	public $likes;
	public $comments;

	public function __construct($data = array()) {
		$this->_db = Database::getInstance();
		if (Input::exists('file')) {
			$this->userId = isset($data['user_id']) ? $data['user_id'] : '';
			$this->_saveDir= 'resources/uploads/' . $this->userId . '/';
			$this->_filepath = $this->_saveDir . $_FILES['fileToUpload']['name'];
			$this->size = getimagesize($_FILES['fileToUpload']['tmp_name']);
			if ($this->size !== false)
				$this->image = file_get_contents($_FILES['fileToUpload']['tmp_name']);
			$this->title = isset($data['title']) ? $data['title'] : '';
			$this->description = isset($data['description']) ? $data['description'] : '';
		}
	}

	public function upload() {
		if ($this->size !== false) {
			$this->store();
		} else {
			throw new Exception("Invalid file.");
		}
	}

	public function display($width = 25) {
		echo "<img src=\"" . $this->_filepath . "\" width=\"".$width."%\">";
		echo "<h1>".$this->title."</h1>";
		echo "<p>".$this->description."</p>";
	}

	public function store() {
		if (!file_exists($this->_saveDir))
			mkdir($this->_saveDir);
		file_put_contents($this->_filepath, $this->image);
		$this->_db->insert('images', array(
			'user_id' => $this->userId,
			'location' => $this->_filepath,
			'image_type' => $this->size['mime'],
			'title' => $this->title,
			'description' => $this->description
		));
	}	
}
