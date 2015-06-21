<div class="col-xs-12 col-sm-6">
	<div class="panel panel-default" id="question-panel">
		<div class="panel-body">
			<input type="hidden" name="question" value="<?php echo_safe($question) ?>"/>
			<?php echo_safe($question) ?>
		</div>

		<?php if ($pronunciation): ?>
			<div class="panel-footer">
				<?php echo_safe($pronunciation) ?>
			</div>
		<?php endif ?>
	</div>
</div>
<div class="col-xs-12 col-sm-6">
	<ul class="nav nav-pills nav-stacked" id="question-answer-selection">
		<?php foreach ($answers as $idx => $answer): ?>
			<li>
				<input type="radio" name="answer" value="<?php echo_safe($answer) ?>"<?php if ($idx === 0) echo ' checked="checked"' ?>/>
				<a href="#"><?php echo_safe($answer) ?></a>
			</li>
		<?php endforeach ?>
	</ul>
</div>
