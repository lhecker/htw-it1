<?php
require 'system/util.php';

$param_lesson = param_get_required('lesson');
$param_dir = intval(param_post_required('dir'));
$param_question = param_post_required('question');
$param_answer = param_post_required('answer');

if ($param_dir < 0 || $param_dir > 1) {
	exit_with_400('Invalid param "dir".');
}


$path = __DIR__ . '/lessons/' . $param_lesson . '.txt';
$handle = @fopen($path, 'r');
$entries = array();
$correct_answer = null;
$correct_pronunciation = null;

if (!$handle) {
	exit_with_400('Invalid param "lesson".');
}

while ($entry = fgetcsv($handle)) {
	$entry = array_filter($entry, function ($str) {
		return $str && is_string($str);
	});

	$l = count($entry);

	if (($l === 2 || $l === 3) && $entry[$param_dir] === $param_question) {
		$correct_answer = $entry[1 - $param_dir];

		if ($l === 3) {
			$correct_pronunciation = $entry[2];
		}

		break;
	}
}

fclose($handle);

if (!$correct_answer) {
	exit_with_500('Could not find question "' . $param_question . '" in file "' . $param_lesson . '".');
}


$answer_is_correct = $param_answer === $correct_answer;


$stats_path = $path . '.stats';
$stats = @file_get_contents($stats_path);

if ($stats) {
	$stats = json_decode($stats);
}

if (!$stats || !isset($stats->total) || !is_int($stats->total) || !isset($stats->correct) || !is_int($stats->correct)) {
	$stats = array('total' => 0, 'correct' => 0);
}

$stats->total++;

if ($answer_is_correct) {
	$stats->correct++;
}

if (!@file_put_contents($stats_path, json_encode($stats))) {
	exit_with_500('Could not update stats file.');
}


echo_html_header(array('assets/css/answer.css'));
?>

<form action="question.php?lesson=<?php echo_url($param_lesson) ?>" method="post" class="container">
	<input type="hidden" name="dir" value="<?php echo $param_dir ?>"/>
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-sm-offset-3">
			<div class="panel panel-default <?php echo $answer_is_correct ? 'correct' : 'wrong' ?>" id="answer-panel">
				<div class="panel-heading panel-content-lg">
					<?php echo_safe($param_question) ?>
				</div>
				<div class="panel-body panel-content-lg">
					<?php if ($answer_is_correct): ?>
						<strong><?php echo_safe($param_answer) ?></strong>
					<?php else: ?>
						<del><?php echo_safe($param_answer) ?></del>
						<ins><?php echo_safe($correct_answer) ?></ins>
					<?php endif ?>
				</div>
				<?php if ($correct_pronunciation): ?>
					<div class="panel-footer">
						<small>Pronunciation:</small> <?php echo_safe($correct_pronunciation) ?>
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<button type="submit" class="btn btn-lg btn-primary center-block">Weiter</button>
		</div>
	</div>
</form>

<?php
echo_html_footer();
