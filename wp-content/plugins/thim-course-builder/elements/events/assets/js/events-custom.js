(function ($) {
	"use strict";

    $(window).load(function () {
		thim_sc_events.load();
	});

	var thim_sc_events = window.thim_sc_events = {

		load: function () {

			$(".thim-sc-events").each(function (index, element) {
				var cols = $(element).attr('data-cols');
				var cols_mobile = 2;
				var cols_ipad = cols;
				var $carousel = $(element);
				if($(element).hasClass('events-layer-3')) {
					cols_mobile = 1;
					cols_ipad = 2;
				}
				if($(element).hasClass('events-layer-2')) {
					cols_mobile = 1;
				}
				if($(element).hasClass('events-layer-1')) {
					cols_mobile = 1;
					var $carousel = $(element).find('.event-wrapper');
				}
				var rtlval = false;
				if($('body').hasClass('rtl')) {
					var rtlval = true;
				}
				var test = $carousel.owlCarousel({
					rtl		  : rtlval,
					items     : cols,
					nav       : true,
					dots      : false,
					margin    : 40,
					navText   : ['<i class="ion-ios-arrow-left" aria-hidden="true"></i>', '<i class="ion-ios-arrow-right"></i>'],
					responsive: {
						0  : {
							items: 1
						},
						480: {
							items: cols_mobile
						},
						481: {
							items: cols_ipad
						},
						769: {
							items: cols
						}
					}
				});
			});
		}
	}

})(jQuery);