(function ($) {
	"use strict";
	$(document).ready(function () {
		thim_load_more.load_more();
	});

	var thim_load_more = window.thim_load_more = {
		load_more: function () {
			$('.thim-loadmore').on('click', function (event) {
				event.preventDefault();
				var style = $(this).attr('data-style');
				var button = $(this),
					data = {
						'action': 'loadmore',
						'query' : thim_loadmore_params.posts, // that's how we get params from wp_localize_script() function
						'page'  : thim_loadmore_params.current_page,
						'style' : style,
					};
				$.ajax({
					url       : thim_loadmore_params.ajaxurl, // AJAX handler
					data      : data,
					type      : 'POST',
					beforeSend: function (xhr) {
						button.addClass('loading');
					},
					success   : function (data) {
						button.removeClass('loading');
						if (data) {
							button.parent().find('.list-articles').append(data); // insert new posts
							thim_loadmore_params.current_page++;

							if (thim_loadmore_params.current_page == thim_loadmore_params.max_page)
							// if last page, remove the button
								button.addClass('last-page');
						} else {
							// if no data, remove the button as well
							button.addClass('no-data');
						}
						thim_change_layout.change_layout();
					}
				});
			});
		}
	};
})(jQuery);
