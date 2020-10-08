$(document).ready(function () {
    $('textarea[maxlength], input[maxlength]').each(function (index, element) { 
        var me = $(element),
            maxlength = parseInt(me.attr('maxlength')),
            length = me.val().length;
            id = me.attr('id');

        me.wrap('<div class="input-counter-wraper" />');
        me.after('<div class="input-counter-view"><label for="' + id + '" class="error"></label>caracteres restantes: <div class="input-counter-view-count">' + ( maxlength - length ) + '</div></div>');
    });
    $('textarea[maxlength], input[maxlength]').bind('input propertychange', function(event) {
        var me = $(this),
            view = me.parent().children('.input-counter-view').children('.input-counter-view-count');
            maxlength = parseInt(me.attr('maxlength')),
            length = me.val().length;

        if (length >= maxlength) {
            me.val(me.val().substring(0, maxlength));
        }
        view.text(maxlength - length);
    });
});