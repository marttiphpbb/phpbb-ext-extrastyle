;(function($, window, document) {
	$('document').ready(function () {
		$('input#editor_rows').bind('change keyup', function () {
			var editor_rows = Math.max(Math.min(this.value, 999), 5);
			$('#file_data').attr('rows', editor_rows);
		});

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
