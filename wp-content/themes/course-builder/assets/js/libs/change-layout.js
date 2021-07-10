(function ($) {
	"use strict";
	$(document).ready(function () {
		if ($('.top-box').length) {
			thim_change_layout.change_layout();
		}
	});
	var activeClass = 'switcher-active';
	var thim_change_layout = window.thim_change_layout = {
		change_layout: function () {
			var $parent = $('.archive, .blog');
			// Change layout to grid or list
			$('.top-box .list').on('click', function () {
				thim_change_layout.switchToList();
			});
			$('.top-box .grid').on('click', function () {
				thim_change_layout.switchToGrid();
			});


			var get_style = $parent.find('[data-getstyle]').attr('data-getstyle');

			if (get_style === 'false') {
				if (typeof(Storage) !== "undefined") {

					if (typeof localStorage.blog_layout != 'undefined') {
						if (localStorage.blog_layout === 'list') {
							$parent.find('.top-box .list').addClass(activeClass);
						} else {
							$parent.find('.top-box .grid').addClass(activeClass);
							$parent.find('article .entry-summary').css('display', 'none');
							$parent.find('article .readmore').css('display', 'none');
						}
					} else {
						$parent.find('.top-box .list').addClass(activeClass);
					}
				} else {
					$parent.find('.top-box .list').addClass(activeClass);
				}
			} else {
				if (get_style === 'list') {
					thim_change_layout.switchToList();
				} else {
					thim_change_layout.switchToGrid();
				}
			}

			thim_course_builder.post_gallery();

		},
		switchToList : function () {
			var $parent = $('.archive, .blog');

			$parent.find('.top-box .list').addClass(activeClass);
			$parent.find('.top-box .grid').removeClass(activeClass);
			$parent.find('article .entry-summary').show();
			$parent.find('article .readmore').show();
			$parent.find('.list-articles').removeClass('style-grid').addClass('style-list');
			localStorage.blog_layout = 'list';
		},
		switchToGrid : function () {
			var $parent = $('.archive, .blog');
			$parent.find('.top-box .grid').addClass(activeClass);
			$parent.find('.top-box .list').removeClass(activeClass);
			$parent.find('article .entry-summary').css('display', 'none');
			$parent.find('article .readmore').css('display', 'none');
			$parent.find('.list-articles').removeClass('style-list').addClass('style-grid');
			localStorage.blog_layout = 'grid';
		},
	};
})(jQuery);
