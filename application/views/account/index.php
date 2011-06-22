<html>
	<head>
		<title></title>
	</head>
	<body>
		<?php if($error): ?>
		<div class="error">
			<?php echo $error; ?>
		</div>
		<?php endif; ?>
		
		<ul>
			<li><a href="#">Connect to Facebook</a></li>
			<li><a href="#">Connect to Twitter</a></li>
		</ul>
		
		<p><a href="/account/logout">Logout</a></p>
	</body>
</html>
