;(function($, window, document) {
	$('document').ready(function () {
		$('select#sheet_name').change(function () {
			$(this).closest('form').submit();
		});

		$('input#new_sheet').keydown(function(e) {
			if (e.which == 13) {
				$('input#create').focus();
			}
		});
	});
})(jQuery, window, document);
