(function(jQuery, $) {
	jQuery.fn.menutoggle = function(options) {
		options =  jQuery.extend({}, jQuery.fn.menutoggle.options, options);
		
		var navigationItem,
			toggleItem,
			modalBackground,
			callback;
		
		navigationItem = $(options.navigationItem);
		toggleItem = $(this);
		modalBackground = $(options.modalBackground)
		
		callback = function() {
			
			navigationItem.fadeToggle(options.fadeTime, function() {
				toggleItem.toggleClass(options.activeClass);
			});
			modalBackground.fadeToggle(options.fadeTime);
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
	
	jQuery.fn.menutoggle.options = {
		fadeTime: 20
	};
}(jQuery, jQuery));