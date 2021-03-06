<!DOCTYPE html>
<html>
<head>
	<title>Camagru</title>
	<base href="../">
	<?php 
		if (isset($data['scripts']))
			foreach($data['scripts'] as $s)
				echo "\t\t<script src=\"resources/js/$s.js\"></script>\n";
		if (isset($data['stylesheets']))
			foreach($data['stylesheets'] as $s)
				echo "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"/resources/css/$s.css\">\n";
	?>
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
	<link rel="icon" type="image/png" href="/resources/favicon/favicon.ico">
</head>
<body>
	<div id="header">
		<div id="logo-wrapper">
			<a href="home"><h1 id="logo">Camagru</h1></a>
		</div>
		<div id="nav-wrapper">
			<ul>
				<?php
					foreach($data['navs'] as $label => $link) {
						echo "<li><a href=\"$link\">$label</a></li>";
					}
				?>
			</ul>
		</div>
	</div>
