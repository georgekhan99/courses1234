(function ($) {
	"use strict";

    $(window).load(function () {
		thim_sc_gallery_carousel.init();
	});


	var thim_sc_gallery_carousel = window.thim_sc_gallery_carousel = {

		init: function () {

			var $thim_gallery_carousel = $('.thim-gallery-carousel');

			$thim_gallery_carousel.each(function () {

				var navigation = ($(this).attr('data-nav') == 'yes') ? true : false;
				var rtlval = false;
				if($('body').hasClass('rtl')) {
					var rtlval = true;
				}
				$(this).find('.owl-carousel').owlCarousel({
						rtl: rtlval,
						dots: navigation,
						items: 1,
					}
				)
			})
		}
	}

})(jQuery);