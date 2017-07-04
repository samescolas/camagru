<?php

class Image {
	private $_db;
	private $_saveDir;
	private $_filepath;
	public $title;
	public $description;
	public $userId;
	public $imageId;
	public $size;
	public $image;
	public $likes = -1;
	public $comments;

	public function __construct($data = array()) {
		$this->_db = Database::getInstance();
		$this->userId = isset($data['user_id']) ? $data['user_id'] : '';
		$this->_saveDir= 'resources/uploads/' . $this->userId . '/';
		$this->_filepath = $this->_saveDir . Token::create() . '.png';
		$this->title = isset($data['title']) ? $data['title'] : '';
		$this->description = isset($data['description']) ? $data['description'] : '';
		if (Input::exists('file')) {
			$this->size = getimagesize($_FILES['fileToUpload']['tmp_name']);
			if ($this->size !== false)
				$this->image = file_get_contents($_FILES['fileToUpload']['tmp_name']);
		} else if ( Input::exists()) {
			$encoded = Input::get('data');
			$decoded = "";
			$limit = ceil(strlen($encoded)/256);
			for ($i=0; $i < $limit; $i++) {
				$decoded = $decoded . base64_decode(substr($encoded, $i*256,256));
			}
			$this->image = $decoded;
			//$this->image = base64_decode(Input::get('data'));
			if (!file_exists($this->_saveDir))
				mkdir($this->_saveDir);
			file_put_contents($this->_filepath, $this->image);
		}
	}

	public function upload() {
		if ($this->size !== false) {
			$this->store();
		} else {
			throw new Exception("Invalid file.");
		}
	}

	public function getLikes() {
		if ($this->likes < 0)
			$this->likes = $this->_db->get('likes', array('image_id', '=', $this->imageId))->count();
		return ($this->likes);
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
		$q = $this->_db->insert('images', array(
			'user_id' => $this->userId,
			'location' => $this->_filepath,
			'image_type' => $this->size['mime'],
			'title' => $this->title,
			'description' => $this->description
		));
		if ($q) {
			$this->imageId = $this->_db->get('images', array('location', '=', $this->_filepath))->first()->id;
		} else {
			throw new Exception('Something went wrong.');
		}
	}	
}
