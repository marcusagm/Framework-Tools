$(document).ready(
function() {
	$('#fw_painel') .css( 'position', 'fixed' )
					.css( 'bottom', '0px' )
					.css( 'left', '0px' )
					.css( 'margin', '5px' );
	$('#fw_painel table').hide();
	$('#fw_painel #fw_tabs a').click(
		function() {
			var target = $(this).attr('href');
			target = target.replace( '#', '' );

			$('#fw_painel #fw_tabs a.active').removeClass('active');
			$(this).addClass('active');

			if( $('#' + target + ' table:visible').length > 0 ) {
				$('#fw_painel table:visible').hide('normal');
				$('#fw_painel #fw_tabs a.active').removeClass('active');
			} else if( $('#fw_painel table:visible').length > 0 ) {
				$('#fw_painel table:visible').hide('normal',
					function () { $('#' + target + ' table').show('normal'); }
				);
			} else {
				$('#' + target + ' table').show('normal');
			}
			return false;
		}
	);
});