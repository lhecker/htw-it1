<?php
require 'system/util.php';


$param_lesson = param_get_required('lesson');
$param_dir = param_post_dir_required();
$param_question = param_post_required('question');
$param_answer = param_post('answer');


$correct_entry = null;

read_lesson($param_lesson, function ($entry) use($param_dir, $param_question, &$correct_entry) {
	if ($entry[$param_dir] === $param_question) {
		$correct_entry = $entry;
		return false;
	}
});

if (!$correct_entry) {
	exit_with_500('Could not find question "' . $param_question . '" in file "' . $param_lesson . '".');
}

$correct_answer = $correct_entry[1 - $param_dir];
$correct_pronunciation = count($correct_entry) === 3 ? $correct_entry[2] : null;
$answer_is_correct = $param_answer === $correct_answer;


$stats = lesson_stats($param_lesson);

if (!$stats) {
	$stats = new stdClass;
	$stats->total = 0;
	$stats->correct = 0;
}

$stats->total++;

if ($answer_is_correct) {
	$stats->correct++;
}

set_lesson_stats($param_lesson, $stats);


echo_html_header(array('assets/css/answer.css'));
?>

<form action="question.php?lesson=<?php echo_url($param_lesson) ?>" method="post" class="container">
	<input type="hidden" name="dir" value="<?php echo $param_dir ?>"/>
	<div class="row">
		<div class="col-xs-12 col-md-6 col-md-offset-3">
			<div class="panel panel-default <?php echo $answer_is_correct ? 'correct' : 'wrong' ?>" id="answer-panel">
				<div class="panel-heading panel-content-lg">
					<?php echo_safe($param_question) ?>
				</div>
				<div class="panel-body panel-content-lg">
					<?php if ($answer_is_correct): ?>
						<strong><?php echo_safe($param_answer) ?></strong>
					<?php else: ?>
						<del><?php $param_answer ? echo_safe($param_answer) : '' ?></del>
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
