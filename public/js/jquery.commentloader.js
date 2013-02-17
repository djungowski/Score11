(function(jQuery, $) {
	jQuery.fn.commentloader = function(options) {
		options = jQuery.extend({}, jQuery.fn.commentloader.options, options);

		var from,
			to,
			loader,
			prev,
			next,
			offset,
			urlOptions,
			loaderFunction,
			commentContainer,
			originalElement;
		
		from = $(this).find(".from");
		to = $(this).find(".to");
		loader = $(options.loader);
		prev = $(this).find(".prev");
		next = $(this).find(".next");
		commentContainer = $(this).find('#comments');
		originalElement = this;
		
		jQuery.fn.commentloader.checkPrevAndNext(prev, next, from.html(), to.html(), options);
		
		loaderFunction = function(event) {
			var position;
			
			if (typeof event != 'undefined') {
				event.preventDefault();
				// Nichts laden, wenn der Textlink deaktiviert ist
				if ($(event.target).hasClass('disabled')) {
					return false;
				}
				// Nach oben scrollen
				$('html, body').stop().animate({ scrollTop: $(originalElement).offset().top }, 400);
				
				if (event.data.offset == 'decrease') {
					options.offset -= options.stepSize * 2;
				}
			}
			urlOptions = {
				offset: options.offset,
				limit: options.stepSize
			};

			loader.show();
			
			// Initial laden
			commentContainer.load(options.baseUrl, urlOptions, function(){
		        loader.hide();
		        from.html(options.offset + 1);
		        to.html(options.offset + options.stepSize);
		        if (to.html() > options.total) {
		        	to.html(options.total);
		        }
		       
	        	options.offset += options.stepSize;
		        if (options.offset < 0) {
		        	options.offset = 0;
		        }
		        jQuery.fn.commentloader.checkPrevAndNext(prev, next, from.html(), to.html(), options);
		    });
		}

		loaderFunction();
		next.on('click', {offset: 'increase'}, loaderFunction);
		prev.on('click', {offset: 'decrease'}, loaderFunction);
	};
	
	jQuery.fn.commentloader.checkPrevAndNext = function(prev, next, from, to, options) {
		if (to < options.total) {
			next.removeClass('disabled');
		} else {
			next.addClass('disabled');
		}

		if (to > options.stepSize) {
			prev.removeClass('disabled');
		} else {
			prev.addClass('disabled');
		}
	}
	
	jQuery.fn.commentloader.options = {
		baseUrl: null,
		loader: null,
		total: 0,
		stepSize: 0,
		offset: 0
	};
})(jQuery, jQuery);