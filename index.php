<?php
require 'system/util.php';

try {
	$it = new FilesystemIterator('./lessons/', FilesystemIterator::SKIP_DOTS);
} catch (Exception $e) {
	exit_with_500('lessons folder missing');
}


echo_html_header(array('assets/css/index.css'));
?>

<div id="index-container">
	<?php
		foreach ($it as $info) {
			if ($info->isReadable() && $info->getExtension() === 'txt') {
				// TODO: utf8_encode() might be needed on Windows since ISO8859-1 is used as the filesystem encoding there
				$name = $info->getBasename('.txt');

				?>
					<a class="btn btn-lg btn-default" href="question.php?lesson=<?php echo rawurlencode($name) ?>"><?php echo $name ?></a>
				<?php
			}
		}
	?>
</div>

<?php
echo_html_footer();
