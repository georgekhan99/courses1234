(function ($) {
	"use strict";

	$(document).ready(function () {
		thim_sc_photo_wall.init();
	});

	var thim_sc_photo_wall = window.thim_sc_photo_wall = {

		init: function () {
			var item = $(".grid-item.hide_mobile");
			if ($(window).width() <= 480) {
				item.hide();
			}
			$('.thim-sc-photo-wall .grid').imagesLoaded(function () {
				$('.thim-sc-photo-wall .grid').masonry({
					itemSelector: '.grid-item',
					columnWidth : '.grid-item',
				});
			});

			// this.scroll();
		},

		scroll: function () {
			if (jQuery().waypoint) {
				var relayout = true;

				var waypoints = $('.thim-sc-photo-wall').waypoint(function () {
					if (relayout) {
						$('.thim-sc-photo-wall').imagesLoaded(function () {
							$('.thim-sc-photo-wall .grid').masonry();
							relayout = false;
						});
					}
				}, {
					offset: '100%'
				})

			}
		},
	}
})(jQuery);