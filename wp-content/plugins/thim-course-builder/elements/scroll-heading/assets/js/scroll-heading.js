(function ($) {
	"use strict";

	$(window).load(function () {
		thim_sc_scroll_heading.load();
	});

	var thim_sc_scroll_heading = window.thim_sc_scroll_heading = {

		load: function () {
			$(".thim-sc-scroll-heading [data-scroll-to]").on('click', function () {
				var $this = $(this),
					$toElement = $this.attr('data-scroll-to'),
					$offset = $this.attr('data-scroll-offset') * 1 || 0,
					$speed = $this.attr('data-scroll-speed') * 1 || 500;

				$('html, body').animate({
					scrollTop: $($toElement).offset().top + $offset
				}, $speed);
			});

		},
	}

})(jQuery);
