<?php

function param_common($arr, $name, $required) {
	$param = isset($arr[$name]) ? $arr[$name] : null;

	if ($param) {
		$param = trim(htmlentities($param, ENT_QUOTES, "UTF-8"));

		if ($param) {
			return $param;
		}
	}

	if ($required) {
		exit('required param "' . $name . '" not specified');
	}

	return null;
}

function param_get($name) {
	return param_common($_GET, $name, false);
}

function param_get_required($name) {
	return param_common($_GET, $name, true);
}

function param_post($name) {
	return param_common($_POST, $name, false);
}

function param_post_required($name) {
	return param_common($_POST, $name, true);
}


function exit_with_400($msg) {
	header('HTTP/1.1 400 Bad Request');
	exit($msg);
}

function exit_with_500($msg) {
	header('HTTP/1.1 500 Internal Server Error');
	exit($msg);
}



function echo_html_header($css = array()) {

?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width,initial-scale=1"/>
	<title>Vokabeltrainer</title>

	<link rel="stylesheet" href="vendor/assets/css/bootstrap.css"/>
	<link rel="stylesheet" href="assets/css/index.css"/>

	<?php foreach ($css as $href): ?>
		<link rel="stylesheet" href="<?php echo $href ?>"/>
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
		<script src="<?php echo $src ?>"></script>
	<?php endforeach ?>
</body>
</html><?php

}
