<div class="img-wrapper">
	<a href="images/<?=$data['image']->imageId ?>">
		<h1><?=$data['image']->title ?></h1>
	</a>
	<a href="images/<?=$data['image']->imageId ?>">
		<img src="<?=$data['image']->filepath ?>">
	</a>
	<div class="info-wrapper">
		<?php if ($data['all'] || $data['username']) { ?>
		<h3 class="username">@<?=$data['image']->userName ?></h3>
		<?php }
		if ($data['likes'])  { ?>
			<a id="likes" href="like/<?=$data['image']->imageId ?>">&hearts; <?=$data['image']->likes ?></a>
	</div>
	<?php
	}
	?>
</div>
