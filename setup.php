<?php
require 'system/util.php';


if (isset($_FILES['lesson'])) {
	$tmp_name = $_FILES['lesson']['tmp_name'];
	$name = basename($_FILES['lesson']['name']);

	if (!str_endswith($name, '.txt')) {
		exit_with_400('Invalid file extension. Must be ".txt" instead.');
	}

	if (strcspn($name, '<>') !== strlen($name)) {
		exit_with_400('Invalid filename "' . $name . '".');
	}

	$uploadpath = __DIR__ . '/lessons/' . $name;

	if (file_exists($uploadpath)) {
		exit_with_400('File named "' . $name . '" already exists.');
	}

	if (move_uploaded_file($tmp_name, $uploadpath)) {
	} else {
		exit_with_500("Failed to move the file to it's target directory.");
	}
} else {
	$lesson = param_post('lesson');
	$method = param_post('_method');

	if ($lesson && $method && strtoupper($method) === 'DELETE') {
		$path = __DIR__ . '/lessons/' . $lesson . '.txt';
		$stats_path = $path . '.stat';

		if ((!file_exists($stats_path) || !@unlink($stats_path)) && (!file_exists($path) || !@unlink($path))) {
			exit_with_500('Failed to delete files for lesson "' . $lesson . '".');
		}

		return;
	}
}


try {
	$it = new LessonIterator();
} catch (Exception $e) {
	exit_with_500('Lessons folder missing.');
}


echo_html_header(array('vendor/assets/css/fileinput.css', 'assets/css/setup.css'));
?>

<form enctype="multipart/form-data" action="setup.php" method="post" class="container" id="setup-container">
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-sm-offset-3">
			<div class="panel panel-primary">
				<div class="panel-heading">Upload new Lesson</div>
				<div class="panel-body">
					<input type="file" name="lesson" class="file"/>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-sm-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">Existing Lessons</div>
				<table class="table table-hover">
					<thead>
						<tr>
							<th colspan="2">Lesson Title</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($it as $name): ?>
							<tr>
								<td><?php echo_safe($name) ?></td>
								<td>
									<button type="button" class="btn btn-xs btn-danger">Delete</button>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</form>

<?php
echo_html_footer(array('vendor/assets/js/fileinput.js', 'assets/js/setup.js'));
