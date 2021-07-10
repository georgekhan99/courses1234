(function ($) {
	"use strict";

	$(document).ready(function () {
		thim_courses_block_3.init();
	});

	var thim_courses_block_3 = window.thim_courses_block_3 = {

		init: function () {
			// init Isotope
			var $grid = $('.thim-course-block-3 .masonry-items');
			$('.thim-sc-photo-wall .grid').imagesLoaded(function () {
				$grid.isotope({
					itemSelector: '.course-item',
					layoutMode  : 'fitRows',
					masonry     : {
						columnWidth: '.course-item',
					}
				});
			});

			// bind filter button click
			$('.thim-course-block-3.has-filter .masonry-filter').on('click', 'a', function () {
				var filterValue = $(this).attr('data-filter');
				// use filterFn if matches value
				//filterValue = filterFns[filterValue] || filterValue;

				$(this).addClass('is-checked').siblings().removeClass('is-checked');

                $('.thim-course-block-3.has-filter .masonry-items').isotope({filter: filterValue});

			});
		}
	}

})(jQuery);