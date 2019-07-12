$(document).ready(
	function() {
		$('.grid_view tbody tr').click(function (event) {
			if (event.target.type !== 'checkbox') {
				checkbox = $(this).children('th').children('.grid_checkbox_delete');
				$(':checkbox', this).trigger('click');
			}
		});
		$('#grid_select_all').change(function (event) {
			if( $(this).prop('checked') === true ) {
				$('.grid_checkbox_delete').prop( "checked", true );
				toggleDeleteAllButton( true );
			} else {
				$('.grid_checkbox_delete').prop( "checked", false );
				toggleDeleteAllButton( false );
			}
		});
		$('.grid_checkbox_delete').change(function (event) {
			if( $('.grid_checkbox_delete:checked').length > 0) {
				toggleDeleteAllButton( true );
			} else {
				toggleDeleteAllButton( false );
			}
			if ( $('.grid_checkbox_delete:checked').length === $('.grid_checkbox_delete').length ) {
				$('#grid_select_all').prop( "checked", true );
			} else {
				$('#grid_select_all').prop( "checked", false );
			}
		});
		$('#grid_button_delete_all').click(function (event) {
			if( $('.grid_checkbox_delete:checked').length > 0) {
                bootbox.dialog({
                    message: "Você tem certeza que deseja excluir os itens selecionados?",
//                    title: "Custom title",
                    buttons: {
                        cancel: {
                            label: "Não",
                            className: "btn-default",
                            callback: function () {
                            }
                        },
                        main: {
                            label: "Sim",
                            className: "btn-danger",
                            callback: function () {
                                $('#grid_button_delete_all').parent().submit();
                            }
                        }
                    }
                });
//				return confirm('Você tem certeza que deseja excluir os itens selecionados?');
				return false;
			} else {
				bootbox.alert('Por favor, selecione pelo menos um registro.');
				return false;
			}
		});
		$('.grid_button_delete').click(function (event) {
            var me = $(this);
            bootbox.dialog({
                message: "Você tem certeza que deseja excluir este item?",
//                    title: "Custom title",
                buttons: {
                    cancel: {
                        label: "Não",
                        className: "btn-default",
                        callback: function () {
                        }
                    },
                    main: {
                        label: "Sim",
                        className: "btn-danger",
                        callback: function () {
                            window.location.href = me.attr('href');
                        }
                    }
                }
            });
			return false;
		});
		$('body').on( 'click', '.btn-delete', function (event) {
            var me = $(this);
            bootbox.dialog({
                message: "Você tem certeza que deseja excluir este item?",
//                    title: "Custom title",
                buttons: {
                    cancel: {
                        label: "Não",
                        className: "btn-default",
                        callback: function () {
                        }
                    },
                    main: {
                        label: "Sim",
                        className: "btn-danger",
                        callback: function () {
                            window.location.href = me.attr('href');
                        }
                    }
                }
            });
			return false;
		});

		$('.grid-ajax-action').on('click', function () {
			var me = $(this);
			$.post( me.prop('href'), {
			}, function(data, status, response) {
				if( data.success === true ) {
					me.prop( 'href', data.url )
					  .html( data.text );
				}
			}, 'json');
			return false;
		});
});
function toggleDeleteAllButton( active ) {
	if( active === true ) {
		$('#grid_button_delete_all').prop( "disabled", false )
									.removeClass('button_inactive')
									.addClass('btn-danger')
									.addClass('button_delete');
	} else {
		$('#grid_button_delete_all').prop('disabled', true)
									.removeClass('button_delete')
									.removeClass('btn-danger')
									.addClass('button_inactive');
	}
}