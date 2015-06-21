(function() {
	var $questionContainer = $('#question-container');
	var $questionPartialContainer = $('#question-partial-container');

	$questionPartialContainer.on('click', 'a', function () {
		var $this = $(this);

		$this.prev().prop('checked', true);
	});

	$('#question-dir-selection').on('click', function () {
		setTimeout(function () {
			var formElements = $questionContainer.prop('elements');
			var dir = formElements['dir'].value;

			$.post(
				$questionContainer.attr('action'),
				{
					dir : dir,
					partial: true,
				},
				function (html) {
					$('#question-partial-container').html(html);
				}
			);
		}, 0);
	});
})();
