;(function($, window, document) {
	$('document').ready(function () {
		$('select#sheet_name').change(function () {
			$(this).closest('form').submit();
		});

		$('input#new_sheet').keydown(function(e) {
//			e.preventDefault();
			if (e.which == 13) {
				$('input#create').click();
			}
		});
	});
})(jQuery, window, document);
