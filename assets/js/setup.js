(function () {
	$('#setup-container').on('click', '.btn-danger', function () {
		var $tr = $(this).closest('tr');
		var lessonName = $tr.children().first().text();

		$.post(
			location.href,
			{
				_method: 'DELETE',
				lesson: lessonName,
			},
			function () {
				$tr.remove();
			}
		);
	});
})();
