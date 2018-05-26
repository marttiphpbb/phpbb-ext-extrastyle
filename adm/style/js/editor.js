;(function($, window, document) {
	$('document').ready(function () {
		$('select#sheet').change(function () {
			$('form#sheet_edit').submit();
		});

		$('input#new_sheet').keydown(function(e) {
			if (e.which == 13) {
				$('input#create').focus();
			}
		});
	});
})(jQuery, window, document);
