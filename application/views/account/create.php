<!doctype html>
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
		
		<form action="/account/create" method="POST">
			<input type="text" name="email" placeholder="email" />
			<input type="password" name="password" placeholder="Password" />
			<input type="password" name="password_confirm" placeholder="Confirm Password" />
			<input type="submit" name="create_user" value="Create Account" />
		</form>
	</body>
</html>