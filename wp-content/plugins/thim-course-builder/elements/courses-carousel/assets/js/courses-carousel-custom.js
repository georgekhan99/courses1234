(function ($) {
	"use strict";

    $(document).ready(function () {
		thim_sc_coursescarousel.load();
	});

	var thim_sc_coursescarousel = window.thim_sc_coursescarousel = {

        load: function () {
			$(".thim-sc-courses-carousel").each(function (index, element) {
				var carousel = $(this).find('.inner-carousel');
				var cols = $(carousel).attr('data-cols');
				var data_nav = $(carousel).attr('data-nav');
				var data_dots = $(carousel).attr('data-dots');

				data_nav = data_nav ? data_nav : false;
				data_dots = data_dots ? data_dots : false;
				var rtlval = false;

				if($('body').hasClass('rtl')) {
					var rtlval = true;
				}
				
				var test = $(carousel).owlCarousel({
					rtl: rtlval,
					margin         : 30,
					responsiveClass: true,
					responsive     : {
						0   : {
							items: 1,
							dots : true,
						},
						481 : {
							items : 2,
						},
						769 : {
							items : 3,
						},
						1025: {
							items : cols,
						}
					},

					nav          : data_nav,
					dots         : data_dots,
					navText      : ['<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 220 220" width="100%" height="100%" preserveAspectRatio="none">\n' +
					'\t\t\t\t\t\t\t<defs>\n' +
					'\t\t\t\t\t\t    <linearGradient id="gradient">\n' +
					'\t\t\t\t\t\t      <stop offset="0" class="stop1"  />\n' +
					'\t\t\t\t\t\t      <stop offset="0.6"class="stop2"  />\n' +
					'\t\t\t\t\t\t    </linearGradient>\n' +
					'\t\t\t\t\t\t  </defs>\n' +
					'\t\t\t\t\t\t  <ellipse ry="100" rx="100" cy="110" cx="110" style="fill:none;stroke:url(#gradient);stroke-width:8;" />\n' +
					'\t\t\t\t\t\t</svg><i class="ion-ios-arrow-left" aria-hidden="true"></i>', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 220 220" width="100%" height="100%" preserveAspectRatio="none">\n' +
					'\t\t\t\t\t\t\t<defs>\n' +
					'\t\t\t\t\t\t    <linearGradient id="gradient">\n' +
					'\t\t\t\t\t\t      <stop offset="0" class="stop1"  />\n' +
					'\t\t\t\t\t\t      <stop offset="0.6"class="stop2"  />\n' +
					'\t\t\t\t\t\t    </linearGradient>\n' +
					'\t\t\t\t\t\t  </defs>\n' +
					'\t\t\t\t\t\t  <ellipse ry="100" rx="100" cy="110" cx="110" style="fill:none;stroke:url(#gradient);stroke-width:8;" />\n' +
					'\t\t\t\t\t\t</svg><i class="ion-ios-arrow-right" aria-hidden="true"></i>'],
					onInitialized: function (event) {
					}
				});
				$(element).append('<div class="carousel-bg"></div>');

				var autoHeight = 0;
				var dotsH = 0;
				var dot = $('.owl-dots');
				var nav = $('.owl-nav');
				if(data_nav == 'true' || data_nav == 'yes'){
					nav.removeClass("disabled");
					console.log('aaaaa');
				}
				if(data_dots == 'true' || data_dots == 'yes'){
					dot.removeClass("disabled");
				}
				if (dot.hasClass('disabled')) {
					dotsH = 0;
				} else {
					dotsH = dot.outerHeight();
				}
				$(carousel).find('.sub-content').each(function (i, sub) {
					var current = $(sub).innerHeight();
					if (parseInt(autoHeight) < parseInt(current)) {
						autoHeight = current;
					}
				});
				$(element).find(".carousel-bg").css("height", parseInt(autoHeight + dotsH + 30) + "px");
			});

		},
	}
})(jQuery);