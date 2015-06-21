<div class="col-xs-12 col-sm-6">
	<div class="panel panel-default" id="question-panel">
		<input type="hidden" name="question" value="<?php echo_safe($question) ?>"/>
		<div class="panel-body panel-content-lg">
			<?php echo_safe($question) ?>
		</div>
		<?php if ($pronunciation): ?>
			<div class="panel-footer">
				<small>Pronunciation:</small> <?php echo_safe($pronunciation) ?>
			</div>
		<?php endif ?>
	</div>
</div>
<div class="col-xs-12 col-sm-6">
	<ul class="nav nav-pills nav-stacked" id="question-answer-selection">
		<?php foreach ($answers as $answer): ?>
			<li>
				<input type="radio" name="answer" value="<?php echo_safe($answer) ?>"/>
				<a href="#"><?php echo_safe($answer) ?></a>
			</li>
		<?php endforeach ?>
	</ul>
</div>
