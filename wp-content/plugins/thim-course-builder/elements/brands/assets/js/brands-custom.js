(function ($) {
	"use strict";

    $(window).load(function () {
		thim_sc_brands.init();
	});


	var thim_sc_brands = window.thim_sc_brands = {

		init: function () {

			var $thim_brands = $('.thim-brands');

			$thim_brands.each(function () {
				var items_visible = $(this).attr('data-items-visible'),
					items_tablet = $(this).attr('data-items-tablet'),
					items_mobile = $(this).attr('data-items-mobile');

				var navigation = ($(this).attr('data-nav') == 'yes') ? true : false;
				var rtlval = false;
				if($('body').hasClass('rtl')) {
					var rtlval = true;
				}
				$(this).find('.owl-carousel').owlCarousel({
						dots: navigation,
						rtl: rtlval,
						responsive: {
							0   : {
								items: items_mobile,
							},
							600   : {
								items: 2,
							},
							768 : {
								items: items_tablet,
							},
							1200: {
								items: items_visible,
							}
						},
					}
				)
			})
		}
	}

})(jQuery);