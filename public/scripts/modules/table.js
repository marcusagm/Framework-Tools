$(function() {
	$('.table tbody tr').on( 'click', function ( event ) {
		if (event.target.type !== 'checkbox') {
			var me = $(this),
				el = me.children('td').children('input[type=checkbox]');
			el.prop('checked', !el.is(':checked') );
			togglePrimaryButton();
			toggleSelectAllInput();
		}
	});

	$('#select_all').change(function (event) {
		if( $(this).is(':checked') ) {
			$('.table tbody input[type=checkbox]').prop('checked', true);
		} else {
			$('.table tbody input[type=checkbox]').prop('checked', false);
		}
		togglePrimaryButton();
	});

	$('.table tbody input[type=checkbox]').change( function( event ) {
		togglePrimaryButton();
		toggleSelectAllInput();
	});
});
function toggleSelectAllInput() {
	var count = $( '.table tbody input[type=checkbox]' ).length,
		countChecked = $( '.table tbody input[type=checkbox]:checked' ).length;

	if( count === countChecked ) {
		$('#select_all').prop('checked', true);
	} else {
		$('#select_all').prop('checked', false);
	}
}