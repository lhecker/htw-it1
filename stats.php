<?php
require 'system/util.php';


try {
	$it = new LessonIterator();
} catch (Exception $e) {
	exit_with_500('lessons folder missing');
}


echo_html_header(array('assets/css/stats.css'));
?>

<div class="container" id="stats-container">
	<div class="row">
		<div class="col-xs-12 col-md-6 col-md-offset-3">
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th></th>
							<th colspan="2">Answered Questions</th>
						</tr>
						<tr>
							<th>Name</th>
							<th># Correct</th>
							<th># Total</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($it as $name): ?>
							<?php $stats = lesson_stats($name); ?>
							<tr>
								<td><?php echo_safe($name) ?></td>
								<td><?php echo $stats ? $stats->correct : '-' ?></td>
								<td><?php echo $stats ? $stats->total   : '-' ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php
echo_html_footer();
