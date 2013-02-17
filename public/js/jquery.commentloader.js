(function(jQuery, $) {
	jQuery.fn.commentloader = function(options) {
		options = jQuery.extend({}, jQuery.fn.commentloader.options, options);

		var from,
			to,
			loader,
			prev,
			next,
			offset,
			urlOptions;
		
		from = $(this).find(".from").html();
		to = $(this).find(".to").html();
		loader = $(options.loader);
		prev = $(this).find(".prev");
		next = $(this).find(".next");
		
		if (to < options.total) {
			next.show();
		}
		
		if (from > options.stepSize) {
			prev.show;
		}
		
		urlOptions = {
			offset: options.offset,
			limit: options.stepSize
		};
		// Initial laden
		$(this).find('#comments').load(options.baseUrl, urlOptions, function(){
	        loader.hide();
	    });
	    
	};
	
	jQuery.fn.commentloader.options = {
		baseUrl: null,
		loader: null,
		total: 0,
		stepSize: 0,
		offset: 0
	};
})(jQuery, jQuery);