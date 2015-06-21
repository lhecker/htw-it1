<?php

function exit_with_400($msg) {
	header('HTTP/1.1 400 Bad Request');
	exit($msg);
}

function exit_with_500($msg) {
	header('HTTP/1.1 500 Internal Server Error');
	exit($msg);
}


/*
 * Will return a sanitized GET or POST string parameter.
 *
 * If $required is true it will either return a string with
 * a length greater than zero or exit with a status code of 400.
 * If $required is false it will return the param if it exists and otherwise null.
 */
function param_common($arr, $name, $required) {
	$param = isset($arr[$name]) ? $arr[$name] : null;

	if (is_string($param)) {
		$param = trim($param);
	} elseif ($param) {
		exit_with_400('param "' . $name . '" must not be a array but a string');
	} elseif ($required) {
		exit_with_400('required param "' . $name . '" not specified');
	}

	return $param;
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
