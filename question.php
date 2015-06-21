<?php
require 'system/util.php';

$param_lesson = param_get_required('lesson');
$param_dir = intval(param_post('dir'));
$param_answer = param_post('answer');
$param_partial = param_post('partial');

if ($param_dir < 0 || $param_dir > 1) {
	exit_with_400('Invalid param "dir".');
}


$path = __DIR__ . '/lessons/' . $param_lesson . '.txt';
$handle = @fopen($path, 'r');
$entries = array();

if (!$handle) {
	exit_with_400('Invalid param "lesson".');
}

while ($entry = fgetcsv($handle)) {
	$entry = array_filter($entry, function ($str) {
		return $str && is_string($str);
	});

	$l = count($entry);

	if ($l === 2 || $l === 3) {
		$entries[] = $entry;
	}
}

fclose($handle);

if (!count($entries)) {
	exit_with_500('Contents of file named "' . $param_lesson . '" invalid.');
}


$answer_dir = 1 - $param_dir;

$entry_idx = array_rand($entries);
$entry = $entries[$entry_idx];
$question = $entry[$param_dir];
$answer = $entry[$answer_dir];
$pronunciation = count($entry) > 2 ? $entry[2] : null;

$answers = array_rand($entries, min(5, count($entries)));

if (!is_array($answers)) {
	$answers = array($answers);
}

if (!in_array($entry_idx, $answers)) {
	$answers[array_rand($answers)] = $entry_idx;
}

$answers = array_map(function ($idx) use($entries, $answer_dir) {
	return $entries[$idx][$answer_dir];
}, $answers);


if ($param_partial !== null) {
	require 'system/question_swap_partial.php';
	return;
}


echo_html_header(array('assets/css/question.css'));
?>

<form action="answer.php?lesson=<?php echo_url($param_lesson) ?>" method="post" class="container" id="question-container">
	<div class="row">
		<div class="col-xs-12">
			<div class="btn-group" id="question-dir-selection" data-toggle="buttons">
				<?php for ($i = 0; $i < 2; $i++): ?>
					<label class="btn btn-primary<?php if ($i === $param_dir) echo ' active' ?>">
						<input type="radio" name="dir" value="<?php echo $i ?>" autocomplete="off"<?php if ($i === $param_dir) echo ' checked="checked"' ?>/>
						<?php echo 'A ' . ($i === 0 ? '>' : '<') . ' B' ?>
					</label>
				<?php endfor ?>
			</div>
		</div>
	</div>
	<div class="row" id="question-partial-container">
		<?php require 'system/question_swap_partial.php' ?>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-sm-offset-6 col-lg-4 col-lg-offset-6">
			<button type="submit" class="btn btn-lg btn-success">Überprüfen</button>
		</div>
	</div>
</form>

<?php
echo_html_footer(array('assets/js/question.js'));
