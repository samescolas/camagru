<div id="main-wrapper">
	<div id="title">
		<h1><?=$data['image']->title ?></h1>
	</div>
	<div id="image">
		<img src="<?=$data['image']->filepath ?>" width="25%">
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
