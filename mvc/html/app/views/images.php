<div id="main-wrapper">
	<div id="title">
		<h1><?=$data['image']->title ?></h1>
		<div id="settings-img-container">
		<?php if ($data['mine']) {
			echo "<a href=\"/updateimg/" . $data['image']->imageId . "\"><img id=\"settings-img\" src=\"resources/imgs/settings.png\"/ align=\"right\"></a>";} 
		?>
		</div>
	</div>
	<div id="image-container">
		<img id="main-img" src="<?=$data['image']->filepath ?>" >
	</div>
	<p id="likes"><?=$data['image']->likes ?>&hearts;</p>
	<div id="comments">
<?php 
		foreach ($data['image']->comments as $c) {
			echo "<p class=\"comment\">" . $c->comment . "</p>";
		}
?>
	</div>
</div>
