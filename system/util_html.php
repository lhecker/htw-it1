<?php

function echo_safe($str) {
	echo htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function echo_url($str) {
	echo rawurlencode($str);
}


function echo_html_header($css = array()) {

?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width,initial-scale=1"/>
	<title>Vokabeltrainer</title>

	<link rel="stylesheet" href="vendor/assets/css/bootstrap.css"/>
	<link rel="stylesheet" href="assets/css/common.css"/>

	<?php foreach ($css as $href): ?>
		<link rel="stylesheet" href="<?php echo_safe($href) ?>"/>
	<?php endforeach ?>
</head>
<body><?php

}

function echo_html_footer($js = array()) {

	?><nav class="navbar navbar-default navbar-fixed-bottom">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="navbar-brand">Navigation</div>
			</div>
			<div class="collapse navbar-collapse" id="navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="index.php">Lektionsauswahl</a></li>
					<li><a href="setup.php">Setup</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<script src="vendor/assets/js/jquery.js"></script>
	<script src="vendor/assets/js/bootstrap.js"></script>

	<?php foreach ($js as $src): ?>
		<script src="<?php echo_safe($src) ?>"></script>
	<?php endforeach ?>
</body>
</html><?php

}
