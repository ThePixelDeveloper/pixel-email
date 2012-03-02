<!doctype html>
<html>
	<head>
		<title><?php print $title; ?></title>
		<link rel="stylesheet" href="<?php print Route::url('email-css', array('file' => 'bootstrap')); ?>">
	</head>
	<body>
		<div class="container" style="margin-top:30px;">
			<?php print $content; ?>	
		</div>
	</body>
</html>