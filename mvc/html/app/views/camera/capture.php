<div id="camera-wrapper">
	<div id="camera">
		<video id="video">Video stream not available.</video>
		<canvas id="canvas">
			<img id="photo" alt="The screen capture will appear in this box.">
		</canvas>
		<br />
		<button id="startbutton">O</button>
		<button id="savebutton">Save</button>
		<button id="deletebutton">Delete</button>
	</div>
	<div id="overlay-panel">
	<ul id="overlay-images">
		<li><a href="#"><img src="http://www.pngpix.com/wp-content/uploads/2016/10/PNGPIX-COM-Alien-PNG-Transparent-Image-500x623.png"></li></a>
		<li><a href="#"><img src="http://www.pngpix.com/wp-content/uploads/2016/10/PNGPIX-COM-Alien-PNG-Transparent-Image-500x623.png"></li></a>
		<li><a href="#"><img src="http://www.pngpix.com/wp-content/uploads/2016/10/PNGPIX-COM-Alien-PNG-Transparent-Image-500x623.png"></li></a>
		<li><a href="#"><img src="http://www.pngpix.com/wp-content/uploads/2016/10/PNGPIX-COM-Alien-PNG-Transparent-Image-500x623.png"></li></a>
		<li><a href="#"><img src="http://www.pngpix.com/wp-content/uploads/2016/10/PNGPIX-COM-Alien-PNG-Transparent-Image-500x623.png"></li></a>
	</ul>
	</div>
</div>
<div id="side-panel">
<?php
	if (isset($data['images'])) {
		foreach($data['images'] as $img) {
			echo "<div class=\"user-image\">";
			$img->display(75, False);
			echo "</div>";
		}
	}
?>
</div>
</div>
