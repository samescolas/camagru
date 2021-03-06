<?php

class Image {
	private $_db;
	private $_saveDir;
	public $filepath;
	public $title;
	public $description;
	public $userId;
	public $imageId;
	public $size;
	public $image;
	public $likes;
	public $comments;
	public $userName;

	public function __construct($data = array()) {
		$this->_db = Database::getInstance();
		$this->userId = isset($data['user_id']) ? $data['user_id'] : '';
		$this->imageId = isset($data['image_id']) ? $data['image_id'] : -1;
		$this->_saveDir= 'resources/uploads/' . $this->userId . '/';
		$this->filepath = isset($data['filepath']) ? $data['filepath'] : '';
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

	public function like($imageId, $userId) {
		if ($imageId > 0 && $userId > 0) {
			$this->_db->insert('likes', array(
				'user_id' => $userId,
				'image_id' => $imageId
			));
		}
	}

	public function overlayImage($overlayId) {
		$filepath = __DIR__ . "/../../public/resources/imgs/$overlayId.png";
		return ($this->overlay(array(array(
			'filepath' => $filepath,
			'dstX' => 0,
			'dstY' => 100,
			'srcX' => 0,
			'srcY' => 0,
			'srcW' => 500,
			'srcH' => 500
		))));
	}

	private function overlay($overlayImages) {
		if (!isset($overlayImages)) {
			return (false);
		}
		$image = imagecreatefrompng($this->filepath);
		$image = imagescale($image, 500);
		foreach($overlayImages as $i) {
			$overlayImg = imagecreatefrompng($i['filepath']);
			$overlayImg = imagescale($overlayImg, 500);
			$success = imagecopy(
				$image,
				$overlayImg,
				$i['dstX'],
				$i['dstY'],
				$i['srcX'],
				$i['srcY'],
				$i['srcW'],
				$i['srcH']
			);
			if (!$success) {
				imagedestroy($image);
				return (false);
			}
		}
		return ($image);
	}

	public function lookup() {
		if (!isset($this->imageId)) {
			return ;
		}
		$img = $this->_db->get('images', array('id', '=', $this->imageId));
		$this->filepath = $img->first()->location;
		$this->title = $img->first()->title;
		$this->description = $img->first()->description;
		$this->userId = $img->first()->user_id;
		$this->likes = $this->getLikes();
		$this->comments = $this->getComments();
		$this->getImageUserName($this->userId);
	}

	private function getImageUserName($userId) {
		$this->userName = $this->_db->get('users', array('id', '=', $userId))->first()->username;
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
		echo "<img src=\"" . $this->filepath . "\" width=\"".$width."%\">";
		if ($all) {
			echo "<div id=\"title-wrapper\">";
				echo "<h1>".$this->title."</h1>";
				echo "<a id=\"likes\" href=\"like/".$this->imageId."\">&hearts; " . $this->getLikes() . "</a>";
			echo "</div>";
			echo "<p>".$this->description."</p>";
			foreach($this->comments as $c) {
				echo "<p class=\"comment\">" . $c->comment . "</p>";
			}
		}
	}

	public function displayEditMode($width=25) {
		echo "<img src=\"" . $this->filepath . "\" width=\"" . $width . "%\">";
		echo "<div id=\"title-wrapper\">";
		echo "<input type=\"text\" value=\"" . $this->title . "\"/>";
		echo "</div>";
		echo "<p><input type=\"text\" value=\"" . $this->description . "\"/></p>";
	}

	public function store() {
		if (!file_exists($this->_saveDir))
			mkdir($this->_saveDir);
		$this->filepath = $this->_saveDir . Token::create() . '.png';
		file_put_contents($this->filepath, $this->image);
		$q = $this->_db->insert('images', array(
			'user_id' => $this->userId,
			'location' => $this->filepath,
			'image_type' => 'image/png',//$this->size['mime'],
			'title' => $this->title,
			'description' => $this->description
		));
		if ($q) {
			$this->imageId = $this->_db->get('images', array('location', '=', $this->filepath))->first()->id;
		} else {
			throw new Exception('Something went wrong.');
		}
	}

	public function del() {
		$this->_db->del('images', array('id', '=', $this->imageId));
		unlink($this->filepath);

	}

	public function updateTitle($newTitle) {
		$title = htmlspecialchars($newTitle);
		if ($title == "") {
			return (-1);
		}
		$fields = array("title" => $title);
		if (!$this->_db->update('images', $this->imageId, $fields)) {
			throw new Exception('There was a problem updating your shit.');
		}
		return (1);
	}
}
