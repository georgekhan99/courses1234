(function ($) {
	"use strict";

	$(document).ready(function () {
		thim_sc_new_video.init();
	});

	var thim_sc_new_video = window.thim_sc_videobox = {
		init: function () {
			$('.thim-sc-new-video .video-thumbnail').magnificPopup({
				type: 'iframe',
			});
		},
	};

})(jQuery);