;(function ( $, window, undefined ) {
	var pluginName = 'nativeWindow',
		document = window.document,
		defaults = {
			width		: 750,
			height		: 550,
			autoResize	: true,
			position	: 'center',
			url			: false,
			textClose	: 'Close',
			classWindow	: 'modal_window',
			classLoad	: 'modal_window_load',
			classClose	: 'modal_window_close',
			classMask	: 'modal_window_mask'
		};

	// The actual plugin constructor
	function nativeWindow( element, options ) {
		var me = this;
		var modal;
		var mask;

		me.element		= element;
		me.options		= $.extend( {}, defaults, options) ;
		me._defaults	= defaults;
		me._name		= pluginName;

		var buttonClose = $( '<span class="' + me.options.classClose + '" title="Fechar">' + me.options.textClose + '</span>' );

		me.init();

		// Adiciona a funcção ao clique do elemento que irá disparar a janela modal.
		$(this.element).bind('click', function(ev){
			ev.preventDefault();
			open();
			return false;
		});

		function close() {
			mask.fadeOut('fast', function() {
				mask.remove();
			});
			modal.fadeOut('fast', function() {
				modal.remove();
			});
			$(window).unbind('resize').unbind('keypress');
		}

		function open() {
			if( me.options.url === false ) {
				me.options.url = me.element.href;
			}

			// Adiciona a mascara para travar a tela
			mask = $('<div></div>');
			mask.addClass(me.options.classMask);
			mask.appendTo('body');
			mask.fadeIn('fast');
			mask.bind( 'click', close );

			// Cria a janela modal;
			modal = $(
				'<div class="' +
					me.options.classWindow + ' ' +
					me.options.classLoad +
				'"><div></div></div>');

			modal.appendTo('body');
			modal.addClass();
			setPosition();

			$(window).bind('resize', function(ev) {
				setSize( setPosition );
			})
			.bind('keypress', function(ev) {
				if(ev.keyCode === 27) {
					close();
				}
			});

			modal.fadeIn('normal', function () {
				$('.' + me.options.classWindow + ' div *:input[type!=hidden]:first').focus();
			});
			modal.append(buttonClose);
			buttonClose.click(function(ev){
				ev.preventDefault();
				close();
				return false;
			});

			$.ajax({
				url: me.options.url,
				success: function(data) {
					modal.children('div').width(me.options.width).append(data).hide();
					setSize(function() {
						modal.removeClass(me.options.classLoad);
						modal.children('div').show();
						$('.' + me.options.classWindow + ' div *:input[type!=hidden]:first').focus();
					});
				}
			});

			return this;
		}

		function setSize(callback) {
			var height;
			if ( me.options.autoResize ) {
				if( me.options.height < modal.children('div').height() ) {
					height = me.options.height;
					modal.children('div').css({
						'height' : height,
						'overflow-y' : 'auto',
						'overflow-x' : 'hidden'
					});
				} else {
					height = modal.children('div').height();
				}
			} else {
				height = me.options.height;
			}
			buttonClose.hide();
			modal.children('div').css({
				'width' : me.options.width
			});
			modal.animate({
				'width' 	: me.options.width,
				'height'	: height,
				'top'		: getPositionY( height ) + 'px',
				'left'		: getPositionX( me.options.width ) + 'px'
			}, 100, function() {
				buttonClose.show();

				if( typeof callback === 'function') {
					callback();
				}
			});
		}

		function setPosition() {
			modal.css({
				'top'		: getPositionY() + 'px',
				'left'		: getPositionX() + 'px'
			});
		}

		function getPositionX(width) {
			if( width === undefined ) {
				width = modal.width();
			}
			return ( ( $(window).width() - width ) / 2 ) ;
		}

		function getPositionY(height) {
			if( height === undefined ) {
				height = modal.height();
			}
			if( $(window).height() > height ) {
				return ( ( $(window).height() / 2  ) - ( height / 2 ) );
			} else {
				return 0;
			}
		}
	}

	nativeWindow.prototype.init = function () {

	};

	// A really lightweight plugin wrapper around the constructor,
	// preventing against multiple instantiations
	$.fn[pluginName] = function ( options ) {
		return this.each(function () {
			if (!$.data(this, 'plugin_' + pluginName)) {
				$.data(this, 'plugin_' + pluginName, new nativeWindow( this, options ));
			}
		});
	};

}(jQuery, window));
$(function () {
	$('a.ajax').nativeWindow({textClose	: 'X'});
});