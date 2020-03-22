$(document).ready( function() {
    $('#<?php echo $name ?>').validate({
        rules: {<?php
                $count = count($validators);
                if( $count > 0 ) {
                    foreach ( $validators as $field => $attributes ) {
                        $countAttributes = count( $attributes );
                        echo "\n\t\t\t";
                        echo '\'' . $field . '\' : { ';
                        if( $attributes['required'] ) {
                            echo '\'required\': true';
                            $countAttributes--;
                            echo $countAttributes > 0 ? ', ' : '';
                        }
                        if( $attributes['email'] ) {
                            echo '\'email\': true';
                            $countAttributes--;
                            echo $countAttributes > 0  ? ', ' : '';
                        }
                        if( $attributes['number'] ) {
                            echo '\'number\': true';
                            $countAttributes--;
                            echo $countAttributes > 0  ? ', ' : '';
                        }
                        if( $attributes['url'] ) {
                            echo '\'url\': true';
                            $countAttributes--;
                            echo $countAttributes > 0  ? ', ' : '';
                        }
                        if( isset( $attributes['maxlength'] ) && $attributes['maxlength'] !== false ) {
                            echo '\'maxlength\': ' . $attributes['maxlength'];
                            $countAttributes--;
                            echo $countAttributes > 0  ? ', ' : '';
                        }
                        $count--;
                        echo ' }' . ( $count > 0 ? ',' : '' );
                    }
                }
            ?>

        }
    });

    <?php
    $hasFile = false;
    foreach ($fields as $field) {
    if ($field['type'] == 'date') {
    echo "
    $('#" . $field['id'] . "').mask('99/99/9999').parent().datepicker({
        format: 'dd/mm/yyyy',
        todayBtn: 'linked',
        language: 'pt-BR',
        multidate: false,
        autoclose: true,
        forceParse: false
    });
    ";
    }
    if ($field['type'] == 'time') {
    echo "
    $('#" . $field['id'] . "').mask('99:99');
    ";
    }
    if ($field['type'] == 'datetime') {
    echo "
    $('#" . $field['id'] . "').mask('99/99/9999 99:99');
    ";
    }
    if ($field['type'] == 'money') {
    echo "
    $('#" . $field['id'] . "').maskMoney({
		symbol:'R$', // Simbolo
		decimal:',', // Separador do decimal
		precision:2, // Precisão
		thousands:'', // Separador para os milhares
		allowZero:true, // Permite que o digito 0 seja o primeiro caractere
		showSymbol:false // Exibe/Oculta o símbolo
	});
    ";
    }
    if ($field['type'] == 'tel') {
    echo "
    $('#" . $field['id'] . "').mask('(99) 9999-9999?9').focusout(function() {
        var phone, element;
        element = $(this);
        element.unmask();
        phone = element.val().replace(/\D/g, '');
        if( phone.substring(0, 1) === '0' ) {
            element.mask('9999-999-9999');
        } else if (phone.length > 10) {
            element.mask('(99) 99999-999?9');
        } else {
            element.mask('(99) 9999-9999?9');
        }
    }).trigger('focusout');
    ";
    }
    if ($field['type'] == 'file' && $hasFile === false) {
        $hasFile = true;
    echo "
    $(document).on('change', '.btn-file :file', function( event ) {
        event.stopPropagation();
        event.preventDefault();

        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);

        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;

        if( input.length ) {
            input.val(log);
        }
    });

    $(document).on('change', '.upload-checkbox-new-file', function () {
        var me = $(this);
        if($(this).is(':checked')) {
            me.parent().parent().parent().children('.upload-input-file').removeClass('invisible');
            me.parent().parent().parent().find('.upload-input-file input[type=file]').prop('disabled', false);
        } else {
            me.parent().parent().parent().children('.upload-input-file').addClass('invisible');
            me.parent().parent().parent().find('.upload-input-file input[type=file]').prop('disabled', true);
        }
    });
    ";
    }
    if ($field['type'] == 'editor') {
    echo "
    $('#" . $field['id'] . "').summernote({
        lang: 'pt-BR',
        height: 350,
        toolbar: [
            ['common', ['undo','redo']],
            ['style', ['style']],
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['para', ['ul', 'ol']],
            ['height', ['height']],
            ['insert', ['picture', 'video', 'link']],
            ['table', ['table']],
            ['code', ['codeview']],
            ['help', ['help']]
        ]
    });
    $('#" . $field['id'] . "').on('summernote.paste', function (customEvent, nativeEvent) {
        var bufferText = ((nativeEvent.originalEvent || nativeEvent).clipboardData || window.clipboardData).getData('Text');
        nativeEvent.preventDefault();
        setTimeout( function(){
            document.execCommand( 'insertText', false, bufferText );
        }, 10 );
    });
    ";
    }
    if ($field['type'] == 'cropbox') {
    echo "
    if ($('#" . $field['id'] . "_update').length) {
        $('#" . $field['id'] . "_update').on('click', function() {
            $('#" . $field['id'] . "_view').before('<input type=\"file\" class=\"crop-input-file\" id=\"" . $field['id'] . "\" name=\"" . $field['id'] . "\">');
            $('#" . $field['id'] . "_view').hide();
            initCropboxFor" . $field['camelcase'] . "();
            return false;
        });
    } else {
        initCropboxFor" . $field['camelcase'] . "();
    }
    function initCropboxFor" . $field['camelcase'] . "() {
        var cropper = $('#" . $field['id'] . "').cropbox({
            viewportId: '" . $field['id'] . "_crop',
            width: 600,
            height: 600
        });
        $('#" . $name . "').on('submit', function(){
            var img = cropper.getDataURL();
            $('#" . $field['id'] . "_data').val(img);
        });
    }
    ";
    }
}
?>

});
