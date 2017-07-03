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
</head>
<body>
	<div id="header">
		<img src="resources/imgs/camagru.png" />
		<ul>
			<a class="active" href="#"><li>Home</li></a>
			<a href="login"><li>Login</li></a>
			<a href="register"><li>Register</li></a>
			<a href="#"><li>Update Profile</li></a>
			<a href="upload"><li>Upload Photo</li></a>
			<a href="#"><li>Browse</li></a>
			<a href="logout"><li>Logout</li></a>
		</ul>
	</div>
