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
	public $likes;
	public $comments;

	public function __construct($data = array()) {
		$this->_db = Database::getInstance();
		$this->userId = isset($data['user_id']) ? $data['user_id'] : '';
		$this->imageId = isset($data['image_id']) ? $data['image_id'] : -1;
		$this->_saveDir= 'resources/uploads/' . $this->userId . '/';
		$this->_filepath = isset($data['filepath']) ? $data['filepath'] : '';
		$this->title = isset($data['title']) ? $data['title'] : '';
		$this->description = isset($data['description']) ? $data['description'] : '';
		$this->comments = isset($data['comments']) ? $data['comments'] : $this->getComments();
		$this->likes = isset($data['likes']) ? $data['likes'] : $this->getLikes();
		if (Input::exists('file')) {
			$this->size = getimagesize($_FILES['data']['tmp_name']);
			if ($this->size !== false)
				$this->image = file_get_contents($_FILES['data']['tmp_name']);
		}
	}

	public function lookup() {
		if (!isset($this->imageId)) {
			return ;
		}
		$img = $this->_db->get('images', array('id', '=', $this->imageId));
		$this->_filepath = $img->first()->location;
		$this->title = $img->first()->title;
		$this->description = $img->first()->description;
		$this->userId = $img->first()->user_id;
		$this->likes = $this->getLikes();
		$this->comments = $this->getComments();
	}

	public function upload() {
		if ($this->size !== false) {
			$this->store();
		} else {
			throw new Exception("Invalid file.");
		}
	}

	public function getLikes() {
		if ($this->likes <= 0)
			$this->likes = $this->_db->get('likes', array('image_id', '=', $this->imageId))->count();
		return ($this->likes);
	}

	public function getComments() {
		if (isset($this->comments))
			return ($this->comments);
		$this->comments = $this->_db->get('comments', array('image_id', '=', $this->imageId))->results();
		return ($this->comments);
	}

	public function display($width = 25, $all=True) {
		echo "<img src=\"" . $this->_filepath . "\" width=\"".$width."%\">";
		if ($all) {
			echo "<h1>".$this->title."</h1>";
			echo "<p class=\"likes\">" . $this->getLikes() . "</p>";
			echo "<p>".$this->description."</p>";
			foreach($this->comments as $c) {
				echo "<p class=\"comment\">" . $c->comment . "</p>";
			}
		}
	}

	public function store() {
		if (!file_exists($this->_saveDir))
			mkdir($this->_saveDir);
		$this->_filepath = $this->_saveDir . Token::create() . '.png';
		file_put_contents($this->_filepath, $this->image);
		$q = $this->_db->insert('images', array(
			'user_id' => $this->userId,
			'location' => $this->_filepath,
			'image_type' => 'image/png',//$this->size['mime'],
			'title' => $this->title,
			'description' => $this->description
		));
		if ($q) {
			$this->imageId = $this->_db->get('images', array('location', '=', $this->_filepath))->first()->id;
		} else {
			throw new Exception('Something went wrong.');
		}
	}

	public function del() {
		$this->_db->del('images', array('id', '=', $this->imageId));
		if (unlink($this->_filepath)) {
		} else {
			echo $this->_filepath;
		}
		die();
	}
}
