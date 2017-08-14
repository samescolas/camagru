<?php 
foreach ($data['images'] as $i) {
	echo "<div class=\"img-wrapper\">";
		$i->display();
	echo "</div>";
}
?>
