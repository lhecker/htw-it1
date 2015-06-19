<div class="col-xs-12 col-sm-6 col-lg-4 col-lg-offset-2">
	<div class="panel panel-default" id="question-panel">
		<div class="panel-body">
			<?php echo $question ?>
		</div>

		<?php if ($pronunciation): ?>
			<div class="panel-footer">
				<?php echo $pronunciation ?>
			</div>
		<?php endif ?>
	</div>
</div>
<div class="col-xs-12 col-sm-6 col-lg-4">
	<ul class="nav nav-pills nav-stacked" id="question-answer-selection">
		<?php foreach ($answers as $idx => $answer): ?>
			<li<?php if ($idx === 0) echo ' class="active"' ?> data-value="<?php echo $answer ?>"><a href="#"><?php echo $answer ?></a></li>
		<?php endforeach ?>
	</ul>
</div>
