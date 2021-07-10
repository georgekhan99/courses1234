/**
 * Created by XuanLe on 08/06/2017.
 */
(function ($) {
	"use strict";

	$(document).ready(function () {
		thim_sc_videobox.init();
	});

	var thim_sc_videobox = window.thim_sc_videobox = {
		init: function () {
			$('.thim-sc-video-box .video-thumbnail').magnificPopup({
				type: 'iframe',
			});
		},
	};

})(jQuery);