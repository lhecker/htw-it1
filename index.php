<?php
require 'system/util.php';


try {
	$it = new LessonIterator();
} catch (Exception $e) {
	exit_with_500('lessons folder missing');
}


echo_html_header(array('assets/css/index.css'));
?>

<div id="index-container">
	<?php foreach ($it as $name): ?>
		<a class="btn btn-lg btn-default" href="question.php?lesson=<?php echo_url($name) ?>"><?php echo_safe($name) ?></a>
	<?php endforeach ?>
</div>

<?php
echo_html_footer();
