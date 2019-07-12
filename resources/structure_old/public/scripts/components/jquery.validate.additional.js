(function ($) {
	$.validator.addMethod("maxwords", function(value, element, params) {
		return this.optional(element) || value.match(/\b\w+\b/g).length < params;
	}, $.validator.format("Please enter {0} words or less."));

	$.validator.addMethod("minwords", function(value, element, params) {
		return this.optional(element) || value.match(/\b\w+\b/g).length >= params;
	}, $.validator.format("Please enter at least {0} words."));

	$.validator.addMethod("rangewords", function(value, element, params) {
		return this.optional(element) || value.match(/\b\w+\b/g).length >= params[0] && value.match(/bw+b/g).length < params[1];
	}, $.validator.format("Please enter between {0} and {1} words."));


	$.validator.addMethod("letterswithbasicpunc", function(value, element) {
		return this.optional(element) || /^[a-z-.,()'\"\s]+$/i.test(value);
	}, "Letters or punctuation only please");

	$.validator.addMethod("alphanumeric", function(value, element) {
		return this.optional(element) || /^\w+$/i.test(value);
	}, "Letters, numbers, spaces or underscores only please");

	$.validator.addMethod("lettersonly", function(value, element) {
		return this.optional(element) || /^[a-z]+$/i.test(value);
	}, "Letters only please");
	$.validator.addMethod("lettersandhyphensonly", function(value, element) {
		return this.optional(element) || /^[a-z\-]+$/i.test(value);
	}, "Letters and hiphens only please");

	$.validator.addMethod("nowhitespace", function(value, element) {
		return this.optional(element) || /^\S+$/i.test(value);
	}, "No white space please");

	$.validator.addMethod("extension", function(value, element, param) {
		param = typeof param === "string" ? param.replace(/,/g, "|") : 'png|jpe?g|gif';
		return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
	}, "Please enter a value with a valid extension." );

	$.validator.addMethod("nick", function(value, element) {
		return this.optional(element) || /^[a-z0-9\.\-_]+$/.test(value);
	}, "Letters and hiphens only please");

	// Accept a value from a file input based on a required mimetype
	$.validator.addMethod("accept", function(value, element, param) {
		// Split mime on commas in case we have multiple types we can accept
		var typeParam;
		if( typeof param === "string" ) {
			typeParam = param.replace(/\s/g, "").replace(/,/g, "|");
		} else {
			typeParam = 'image/' + '*';
		}
		var optionalValue = this.optional(element),
		i, file;

		// Element is optional
		if (optionalValue) {
			return optionalValue;
		}

		if ( $(element).attr("type") === "file") {
			// If we are using a wildcard, make it regex friendly
			typeParam = typeParam.replace(/\*/g, '.*');

			// Check if the element has a FileList before checking each file
			if (element.files && element.files.length) {
				for (i = 0; i < element.files.length; i++) {
					file = element.files[i];
					// Grab the mimetype from the loaded file, verify it matches
					if (!file.type.match(new RegExp( ".?(" + typeParam + ")$", "i"))) {
						return false;
					}
				}
			}
		}

		// Either return true because we've validated each file, or because the
		// browser does not support element.files and the FileList feature
		return true;
	}, "Please enter a value with a valid mimetype." );

	$.validator.addMethod('filesize', function(value, element, param) {
		// param = size (en bytes)
		// element = element to validate (<input>)
		// value = value of the element (file name)
		return this.optional(element) || (element.files[0].size <= param);
	}, "File size not valid.");
}(jQuery));