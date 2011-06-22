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
		
		<form action="/account/login" method="POST">
			<input type="text" name="email" placeholder="Email" />
			<input type="password" name="password" placeholder="Password" />
			<input type="submit" name="login" value="Login" />
		</form>
	</body>
</html>
