<!DOCTYPE html>
<head>
	<title>Camagru</title>
	<base href="../">
	<?php 
		if (isset($data['scripts']))
			foreach($data['scripts'] as $s)
				echo "\t\t<script src=\"resources/js/$s.js\"></script>\n";
		if (isset($data['stylesheets']))
			foreach($data['stylesheets'] as $s)
				echo "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"resources/css/$s.css\">\n";
	?>
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
</head>
<body>
	<div id="header">
		<a href="home"><h1 id="logo">Camagru</h1></a>
		<div class="wrapper">
			<ul>
				<?php
					foreach($data['navs'] as $label => $link) {
						echo "<li><a href=\"$link\">$label</a></li>";
					}
				?>
			</ul>
		</div>
	</div>
