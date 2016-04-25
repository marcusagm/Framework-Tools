function togglePrimaryButton() {
	var countChecked = $( '.table tbody input[type=checkbox]:checked' ).length;

	if( countChecked === 0 ) {
		$('.log-delete-button').html('<span class="ftools-remove"></span> Delete all');
	} else {
		$('.log-delete-button').html('<span class="ftools-remove"></span> Delete selecteds');
	}
}