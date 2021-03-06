;(function ( $, window, undefined ) {
	var pluginName = 'modalWindow',
		document = window.document,
		defaults = {
			url			: false,
			blockOpenByWidth : true,
			modalDialogClass: 'modal-dialog'
		};

	// The actual plugin constructor
	function modalWindow( element, options ) {
		var me = this,
			modal,
			buttonClose;

		me.element		= element;
		me.options		= $.extend( {}, defaults, options) ;
		me._defaults	= defaults;
		me._name		= pluginName;

		me.init();

		// Adiciona a funcção ao clique do elemento que irá disparar a janela modal.
		$(me.element).on('click', function( event ){
			event.stopPropagation();
			event.preventDefault();
			if( me.options.blockOpenByWidth && me.options.width > $(document).outerWidth() ) {
				return true;
			}
			$(this).attr( 'disabled', true );
			open();
			return false;
		});

		function open() {
			if( me.options.url === false ) {
				me.options.url = me.element.href;
			}

			// Cria a janela modal;
			modal = $(
				'<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">' +
					'<div class="' + me.options.modalDialogClass + '">' +
						'<div class="modal-content">' +
						'</div>' +
					'</div>' +
				'</div>'
			);
			buttonClose = $( '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>' );

			modal.appendTo('body');
			modal.on('hidden.bs.modal', function(){
				modal.remove();
			});
			modal.on('shown.bs.modal', function(){
				modal.find('.modal-body *:input[type!=hidden]:first').focus();
			});

			$.ajax({
				url: me.options.url,
				beforeSend: function( jqXHR, settings ) {
					// implementar tela de carregamento
				},
				success: function(data) {
					modal.children('.modal-dialog')
						.children('.modal-content')
						.html(data);
					var panel = modal.find('.panel:first');
					if ( panel.hasClass('modal-window-lg') ) {
						modal.children('.modal-dialog').addClass('modal-lg');
					}

					var header = panel.find('.panel-heading:first');
					header.removeClass('panel-heading').addClass('modal-header');
					header.wrapInner('<h4 class="modal-title"></h4>');
					header.prepend(buttonClose);
					panel.children('.panel-body:first').removeClass('panel-body').addClass('modal-body');
					panel.find('.panel-footer:last').removeClass('panel-footer').addClass('modal-footer');

					panel.children('div').unwrap('.panel');

					modal.modal();
				}
			})
			.always( function () {
				$(me.element).attr( 'disabled', false );
			});

			return this;
		}
	}

	modalWindow.prototype.init = function () {

	};

	// A really lightweight plugin wrapper around the constructor,
	// preventing against multiple instantiations
	$.fn[pluginName] = function ( options ) {
		return this.each(function () {
			if (!$.data(this, 'plugin_' + pluginName)) {
				$.data(this, 'plugin_' + pluginName, new modalWindow( this, options ));
			}
		});
	};

}(jQuery, window));
$(function () {
	$('a.ajax').modalWindow();
});