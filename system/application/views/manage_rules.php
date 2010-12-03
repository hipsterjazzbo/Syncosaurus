<html>
	<head>
		<title>syncosaur.us || rules</title>
		<link rel="stylesheet" href="/syncosaurus/css/autoSuggest.css" type="text/css" />
		<script src="/syncosaurus/js/jquery-1.4.2.min.js" type="text/javascript"></script>
		<script src="/syncosaurus/js/jquery.autoSuggest.minified.js" type="text/javascript"></script>
		<script src="/syncosaurus/js/rules.js" type="text/javascript"></script>
	</head>
	<body>
		<h2>New rule:</h2>
		
		<form>
			<fieldset>
				
				<label>When I </label>
					<input type="text" name="type" id="type" />
				<label> to </label>
					<input type="text" name="source" id="source" />
				<label>, also send it to </label>
					<input type="text" name="destinations" id="destinations" />
				
			</fieldset>
		</form>
		
		<h1>Rules:</h1>
			
			<ul>				
			<?php foreach($rules as $rule): ?>
			
				<li><?php echo $rule; ?></li>
				
			<?php endforeach; ?>
			</ul>
			
	</body>
</html>
