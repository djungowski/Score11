(function(jQuery, $) {
	jQuery.fn.menutoggle = function(options) {
		options = options || jQuery.fn.menutoggle.options;
		
		var navigationItem,
			toggleItem,
			modalBackground,
			callback;
		
		navigationItem = $(options.navigationItem);
		toggleItem = $(this);
		modalBackground = $(options.modalBackground)
		
		callback = function() {
			
			navigationItem.fadeToggle(50, function() {
				toggleItem.toggleClass(options.activeClass);
			});
			modalBackground.fadeToggle(50);
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