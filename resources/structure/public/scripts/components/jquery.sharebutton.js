var windowObjectReference = null,
	previousUrl;

$(document).ready(
function() {
	$('.btn-share-button').on( 'click', openPopup );
});

function openPopup() {
	var me = $(this),
		url = me.attr( 'href' ),
		width = 500,
		heigth = 255;

	if( windowObjectReference === null || windowObjectReference.closed || previousUrl !== url ) {
		windowObjectReference = window.open(
			url,
			'access',
			'width=' + width +
			',height=' + heigth +
			',top=0' +
			',left=0' +
			',location=no' +
			',centerscreen=yes' +
			',dependent=yes' +
			',directories=no' +
			',menubar=yes' +
			',status=no' +
			',toolbar=yes' +
			',titlebar=no' +
			',scrollbars=yes'
		);
	}
	windowObjectReference.focus();
	previousUrl = url;
	return false;
};