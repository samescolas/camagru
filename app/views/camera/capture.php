<div id="camera-wrapper">
	<div id="camera">
		<video id="video">Video stream not available.</video>
		<canvas id="canvas1"></canvas>
		<br />
		<button id="startbutton">O</button>
		<button id="savebutton">Save</button>
		<button id="deletebutton">Take another picture</button>
	</div>
	<div id="overlay-panel">
	<ul id="overlay-images">
		<li class="overlay-image"><img id="alien" src="resources/imgs/alien.png"></li>
		<li class="overlay-image"><img id="cat" src="resources/imgs/cat.png"></li>
		<li class="overlay-image"><img id="cactus" src="resources/imgs/cactus.png"></li>
		<li class="overlay-image"><img id="wave" src="resources/imgs/wave.png"></li>
		<li class="overlay-image"><img id="grass" src="resources/imgs/grass.png"></li>
	</ul>
	</div>
</div>
<div id="side-panel">
<?php
	if (isset($data['images']) && count($data['images']) > 0) {
		foreach($data['images'] as $img) {
			echo "<div class=\"user-image\">";
				echo "<a href=\"images/" . $img->imageId . "\">";
					$img->display(75, False);
				echo "</a>";
			echo "</div>";
		}
	}
?>
</div>
</div>
