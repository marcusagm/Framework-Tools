/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: PT (Portuguese; português)
 * Region: BR (Brazil)
 */
(function ($) {
	$.extend($.validator.messages, {
		required: "Este campo &eacute; requerido.",
		remote: "Por favor, corrija este campo.",
		email: "Por favor, forne&ccedil;a um endere&ccedil;o de email v&aacute;lido.",
		url: "Por favor, forne&ccedil;a uma URL v&aacute;lida.",
		date: "Por favor, forne&ccedil;a uma data v&aacute;lida.",
		dateISO: "Por favor, forne&ccedil;a uma data v&aacute;lida (ISO).",
		number: "Por favor, forne&ccedil;a um n&uacute;mero v&aacute;lido.",
		digits: "Por favor, forne&ccedil;a somente d&iacute;gitos.",
		creditcard: "Por favor, forne&ccedil;a um cart&atilde;o de cr&eacute;dito v&aacute;lido.",
		equalTo: "Por favor, forne&ccedil;a o mesmo valor novamente.",
		maxlength: $.validator.format("Por favor, forne&ccedil;a n&atilde;o mais que {0} caracteres."),
		minlength: $.validator.format("Por favor, forne&ccedil;a ao menos {0} caracteres."),
		rangelength: $.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1} caracteres de comprimento."),
		range: $.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1}."),
		max: $.validator.format("Por favor, forne&ccedil;a um valor menor ou igual a {0}."),
		min: $.validator.format("Por favor, forne&ccedil;a um valor maior ou igual a {0}."),

		// Additional methods
		accept: "Por favor, forne&ccedil;a um arquivo com uma extens&atilde;o v&aacute;lida.",
		extension: "Por favor, forne&ccedil;a um arquivo com uma extens&atilde;o v&aacute;lida.",
		maxwords: $.validator.format("Por favor, digite {0} palavras ou menos."),
		minwords: $.validator.format("Por favor, digite pelo menos {0} palavras."),
		rangewords: $.validator.format("Por favor, digite entre {0} e {1} palavras."),
		letterswithbasicpunc: "Por favor, digite somente letras ou pontua&ccedil;&otilde;es.",
		alphanumeric: "Por favor, digite somente letras, espa&ccedil;os ou sublinhados.",
		lettersonly: "Por favor, digite somente letras.",
		lettersandhyphensonly: "Por favor, digite somente letras ou h&iacute;fens.",
		nowhitespace: "Não é permitido espa&ccedil;os.",
		filesize: "Tamanho de arquivo inv&aacute;lido.",
		nick: "Por favor, digite somente letras min&uacute;sculas, n&uacute;meros, h&iacute;fens, ponto e sublinhados."
	});
	// fix date validation for chrome
	$.extend($.validator.methods, {
		date: function (value, element) {
			var isChrome = window.chrome;
			// make correction for chrome
			if (isChrome) {
				var d = new Date();
				return this.optional(element) ||
				!/Invalid|NaN/.test(new Date(d.toLocaleDateString(value)));
			}
			// leave default behavior
			else {
				return this.optional(element) ||
				!/Invalid|NaN/.test(new Date(value));
			}
		}
	});
	// set default date for pt-br
	//$.datepicker.setDefaults($.datepicker.regional["pt-BR"]);
}(jQuery));
