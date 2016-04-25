 $(function() {
	$('.tools-remove').on( 'click', function() {
		return confirm('Are you sure that you want to permanently delete this?');
	});
 });