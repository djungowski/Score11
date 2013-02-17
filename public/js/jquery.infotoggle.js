(function(jQuery, $) {
	jQuery.fn.infotoggle = function(options) {
		options = jQuery.extend({}, jQuery.fn.infotoggle.options, options);
		
		var originalElement = this;
		this.on('click', function(event) {
			event.preventDefault();
			originalElement.hide();
			$(options.hideAdditionally).hide();
			$(options.elements).show(400);
		});
	};
	
	jQuery.fn.infotoggle.options = {
		elements: null,
		hideAdditionally: null
	}
})(jQuery, jQuery);