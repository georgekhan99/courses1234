(function ($) {
	"use strict";

	$(document).ready(function () {
		thim_sc_instructors.init();
	});

	var thim_sc_instructors = window.thim_sc_instructors = {

		init    : function () {
			this.loadmore();
		},
		loadmore: function () {
			$('.thim-instructors').on('click', '.load-more', function (event) {
				event.preventDefault();

				var $sc = $(this).parents('.thim-instructors');

				var params = $sc.attr('data-params'),
					max_page = $sc.attr('data-max-page'),
					page = parseInt($sc.attr('data-page')),
					loading = false;

				if (!loading) {
					var $button = $('.button-load .load-more');
					var rank = $sc.find('.wrapper-instruction .item').length;
					loading = true;

					var current_page = 1;

					var data = {
						action  : 'thim_instructors_load',
						init    : false,
						params  : params,
						rank    : rank,
						max_page: max_page,
						page    : current_page,
					};
					$.ajax({
						type      : "POST",
						url       : ajaxurl,
						data      : data,
						beforeSend: function () {
							$sc.addClass('loadmore');
							$button.remove();
						},
						success   : function (res) {
							$sc.find('.wrapper-instruction').append(res.data.html);
							$sc.removeClass('loadmore');
							current_page++;
						}
					});
				}
			});
		},
	}

})(jQuery);