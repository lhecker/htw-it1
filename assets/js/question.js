(function() {
	var $questionAnswer = $('#question-answer');
	var $questionAnswerSelection = $('#question-answer-selection');

	$questionAnswerSelection.on('click', 'a', function () {
		var $this = $(this);

		$questionAnswer.val($this.text());
		$questionAnswerSelection.find('.active').add($this.closest('li')).toggleClass('active');
	})
})();
