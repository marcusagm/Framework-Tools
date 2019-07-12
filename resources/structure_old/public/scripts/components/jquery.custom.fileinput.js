$(document).on('change', '.btn-file :file', function( event ) {
    event.stopPropagation();
    event.preventDefault();

    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);

    var input = $(this).parents('.input-group').find(':text'),
        log = numFiles > 1 ? numFiles + ' files selected' : label;

    if( input.length ) {
        input.val(log);
    }
});