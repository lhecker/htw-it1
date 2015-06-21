<?php

require 'util_html.php';
require 'util_http.php';


function str_endswith($haystack, $needle) {
	$haystacklen = strlen($haystack);
	$needlelen = strlen($needle);
	return $needlelen <= $haystacklen && substr_compare($haystack, $needle, $haystacklen - $needlelen, $needlelen) === 0;
}


class LessonIterator implements Iterator {
	private $fiter;

	public function __construct() {
		$this->fiter = new FilesystemIterator(__DIR__ . '/../lessons/', FilesystemIterator::SKIP_DOTS);;
	}

	public function rewind() {
		$this->fiter->rewind();
	}

	public function valid() {
		return $this->fiter->valid();
	}

	public function key() {
		return $this->fiter->key();
	}

	public function current() {
		return $this->fiter->current()->getBasename('.txt');
	}

	public function next() {
		$info = null;

		do {
			$this->fiter->next();
			$info = $this->fiter->valid() ? $this->fiter->current() : null;
		} while ($info && (!$info->isReadable() || $info->getExtension() !== 'txt'));
	}
}
