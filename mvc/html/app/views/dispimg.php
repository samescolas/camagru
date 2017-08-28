<div class="img-wrapper">
	<?php if ($data['all'])  { ?>
			<h1><?=$data['image']->title ?></h1>
	<?php } ?>
	<img src="<?=$data['image']->filepath ?>">
	<div class="info-wrapper">
		<?php if ($data['all'] || $data['username']) { ?>
		<h3 class="username"><?=$data['image']->userName ?></h3>
		<?php }
		if ($data['likes'])  { ?>
			<a id="likes" href="like/<?=$data['image']->imageId ?>">&hearts; <?=$data['image']->likes ?></a>
	</div>
	<?php
	}
	if ($data['comments'] && count($data['image']->comments) > 0) {
			foreach($data['image']->comments as $comment) { ?>
				<p class=\"comment\"><?php echo $comment ?></p>;
	<?php
			}
		}
	?>
</div>
