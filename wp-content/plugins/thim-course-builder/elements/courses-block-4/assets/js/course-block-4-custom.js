(function ($) {
	"use strict";

	$(document).ready(function () {
		thim_courses_block_4.init();
	});

	var thim_courses_block_4 = window.thim_courses_block_4 = {

		init: function () {
			$('.thim-course-block-4 .course-item').each(function (index, element) {
				var color = $(this).attr('data-color');
				$(this).find('.wrapper').hover(function () {
					$(this).css('background-color', color);
				}, function () {
					$(this).css('background-color', '#ffffff');
				});
			});
		}
	}

})(jQuery);