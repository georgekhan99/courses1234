(function ($) {
	"use strict";

	$(document).ready(function () {
		thim_sc_pricing.init();
	});

	var thim_sc_pricing = window.thim_sc_pricing = {

		init    : function () {
			this.max_height_content();
		},

		max_height_content: function () {
			var $pricing = $('.thim-sc-pricing'),
				max_height_top = 0,
				max_height_c = 0;

			// Get max height content of all items.
			$pricing.each(function () {
				if (max_height_c < $(this).find('.pricing-item .content').height()) {
					max_height_c = $(this).find('.pricing-item .content').height();
				}
				if (max_height_top < $(this).find('.pricing-item .package').height()) {
					max_height_top = $(this).find('.pricing-item .package').height();
				}
			});

			// Set height content for all items.
			if (max_height_c > 0) {
				$pricing.each(function () {
					$(this).find('.pricing-item .content').css('height', max_height_c);
				});
			}

			if ((max_height_top) > 0 && ($(window).width() < 1024)) {
				$pricing.each(function () {
					$(this).find('.pricing-item .package').css('height', max_height_top);
				});
			}
		},
	}

})(jQuery);