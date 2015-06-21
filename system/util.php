<?php

require 'util_html.php';
require 'util_http.php';
require 'util_php.php';


function lesson_stats_path($name) {
	return __DIR__ . '/../lessons/' . $name . '.txt.stats';
}

function lesson_stats($name) {
	$stats_path = lesson_stats_path($name);
	$stats = @file_get_contents($stats_path);

	if ($stats) {
		$stats = json_decode($stats);
	}

	if (!$stats || !isset($stats->total) || !is_int($stats->total) || !isset($stats->correct) || !is_int($stats->correct)) {
		return false;
	}

	return $stats;
}

function set_lesson_stats($name, $stats) {
	$stats_path = lesson_stats_path($name);

	if (!@file_put_contents($stats_path, json_encode($stats))) {
		exit_with_500('Could not update stats file.');
	}
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
