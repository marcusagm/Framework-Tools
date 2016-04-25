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

	$('.model-generate').on( 'click', function() {
		if( !$('#genarate_only_repositories').is(':checked') ) {
			if( confirm( 'This action will generate the model and repository files.\n\You will lose all changes made ​​to the files already existing model.\n\n\Are you sure you want to do this?', 'Caution!' ) ) {
				return true;
			}
			return false;
		}
		return true;
	});
});
function togglePrimaryButton() {
	var countChecked = $( '.table tbody input[type=checkbox]:checked' ).length;

	if( countChecked === 0 ) {
		$('.model-generate').html('<span class="ftools-ok"></span> Generate all');
	} else {
		$('.model-generate').html('<span class="ftools-ok"></span> Generate selecteds');
	}
}