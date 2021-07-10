(function ($) {
	"use strict";

	$(document).ready(function () {
		thim_typical_courses.init();
	});

	var thim_typical_courses = window.thim_courses_block_1 = {

		init: function () {

			var $control_video = $('.content-video span');

			$control_video.magnificPopup({
				type     : 'iframe',
				mainClass: 'mfp-with-zoom',

				patterns: {
					youtube: {
						index: 'youtube.com/', // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).

						id: 'v=', // String that splits URL in a two parts, second part should be %id%
						// Or null - full URL will be returned
						// Or a function that should return %id%, for example:
						// id: function(url) { return 'parsed id'; }

						src: '//www.youtube.com/embed/%id%?autoplay=1' // URL that will be set as a source for iframe.
					},
					vimeo  : {
						index: 'vimeo.com/',
						id   : '/',
						src  : '//player.vimeo.com/video/%id%?autoplay=1'
					}
				},
			});

		}
	}

})(jQuery);