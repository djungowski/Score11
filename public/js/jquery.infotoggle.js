(function(jQuery, $) {
	jQuery.fn.infotoggle = function(options) {
		options = options || {};
		
		var originalElement = this;
		this.on('click', function(event) {
			event.preventDefault();
			originalElement.hide();
			$(options.elements).show(400);
		});
	};
})(jQuery, jQuery);