<?php

function str_endswith($haystack, $needle) {
	$haystacklen = strlen($haystack);
	$needlelen = strlen($needle);
	return $needlelen <= $haystacklen && substr_compare($haystack, $needle, $haystacklen - $needlelen, $needlelen) === 0;
}
