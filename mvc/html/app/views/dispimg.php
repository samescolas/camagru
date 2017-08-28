<div class="img-wrapper">
	<img src="<?=$data['image']->filepath ?>">
	<?php if ($data['all'])  { ?>
		<div id="title-wrapper">
			<h1><?=$data['image']->title ?></h1>
			<a id="likes" href="like/<?=$data['image']->imageId ?>">&hearts; <?=$data['image']->likes ?></a>
		</div>
	<?php

		if (count($data['image']->comments) > 0) {
			foreach($data['image']->comments as $comment) { ?>
				<p class=\"comment\"><?php echo $comment ?></p>;
	<?php
			}
		}
	}
	?>
</div>
