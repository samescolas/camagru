<div class="main">
	<h2>Update Image</h2>
	<form action="updateimg/submit/<?=$data['id'] ?>" method="post">
	<input autofocus="autofocus" type="text" name="title" placeholder="<?=$data['oldTitle'] ?>" id="title" autocomplete="off" />
		<br />
		<input type="submit" value="Update" />
		<input type="hidden" name="redirect" value="192.168.99.100/updateimg/submit/" />
	</form>
	<form action="updateimg/del/<?=$data['id'] ?>" method="post">
		<input type="submit" value="Delete Img" />
	</form>
</div>
