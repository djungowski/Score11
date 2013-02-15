(function(jQuery, $) {
	jQuery.fn.menutoggle = function(options) {
		options = options || jQuery.fn.menutoggle.options;
		
		var navigationItem,
			modalBackground,
			callback;
		
		navigationItem = $(options.navigationItem);
		modalBackground = $(options.modalBackground)
		
		callback = function() {
			navigationItem.fadeToggle();
			modalBackground.fadeToggle();
		};
		
		this.each(function(key, item) {
			$(item).on('click', callback);
		});
		
		$(options.modalBackground).on('click', callback);
		$(document).on('keydown', function(event) {
			if (event.keyCode == 27 && modalBackground.is(':visible')) {
				callback();
			}
		});
	}
	
	jQuery.fn.menutoggle.options = {};
}(jQuery, jQuery));