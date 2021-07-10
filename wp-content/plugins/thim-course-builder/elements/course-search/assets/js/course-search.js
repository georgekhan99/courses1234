(function ($) {
	"use strict";

	$(document).ready(function () {
		thim_sc_course_search.init();
	});

	$(window).load(function () {
		var $sc_wrapper_popup = $('.thim-sc-course-search.popup');

		$sc_wrapper_popup.on('click', '.toggle-form' , function (e) {
			e.preventDefault();
			$('body').addClass('thim-active-search-popup');
			setTimeout(function () {
				$sc_wrapper_popup.find('.courses-search-input').focus();
			}, 400);
		});

		$('.thim-sc-course-search.popup .background-toggle').on('click', function (e) {
			e.preventDefault();
			$('body').removeClass('thim-active-search-popup');
		});

		$(window).scroll(function() {
			$('body').removeClass('thim-active-search-popup');
		});

	});

	var thim_sc_course_search = window.thim_sc_course_search = {

		init: function () {

			var $sc_wrapper = $('.thim-sc-course-search');

			$sc_wrapper.on('keyup', '.courses-search-input', function (event) {
				clearTimeout($.data(this, 'timer'));
				if (event.which == 13) {
					event.preventDefault();
					$(this).stop();
				} else if (event.which == 38) {
					if (navigator.userAgent.indexOf('Chrome') != -1 && parseFloat(navigator.userAgent.substring(navigator.userAgent.indexOf('Chrome') + 7).split(' ')[0]) >= 15) {
						var selected = $(".ob-selected");
						if ($sc_wrapper.find(".courses-list-search li").length > 1) {
							$sc_wrapper.find(".courses-list-search li").removeClass("ob-selected");
							// if there is no element before the selected one, we select the last one
							if (selected.prev().length == 0) {
								selected.siblings().last().addClass("ob-selected");
							} else { // otherwise we just select the next one
								selected.prev().addClass("ob-selected");
							}
						}
					}
				} else if (event.which == 40) {
					if (navigator.userAgent.indexOf('Chrome') != -1 && parseFloat(navigator.userAgent.substring(navigator.userAgent.indexOf('Chrome') + 7).split(' ')[0]) >= 15) {
						var selected = $sc_wrapper.find(".ob-selected");
						if ($sc_wrapper.find(".courses-list-search li").length > 1) {
							$sc_wrapper.find(".courses-list-search li").removeClass("ob-selected");

							// if there is no element before the selected one, we select the last one
							if (selected.next().length == 0) {
								selected.siblings().first().addClass("ob-selected");
							} else { // otherwise we just select the next one
								selected.next().addClass("ob-selected");
							}
						}
					}
				} else if (event.which == 27) {
					$sc_wrapper.find('.courses-list-search').html('');
					$(this).val('');
					$(this).stop();
				} else if (event.which == 8) {
					$sc_wrapper.find('.courses-list-search').html('');
				} else {
					console.log('123');
					$(this).data('timer', setTimeout(thim_sc_course_search.livesearch(this), 700));
				}
			});

			$sc_wrapper.on('keypress', '.courses-search-input', function (event) {
				if (event.keyCode == 13) {
					var selected = $(".ob-selected");
					if (selected.length > 0) {
						var ob_href = selected.find('a').first().attr('href');
						window.location.href = ob_href;
					}
					event.preventDefault();
				}
				if (event.keyCode == 38) {
					var selected = $(".ob-selected");
					// if there is no element before the selected one, we select the last one
					if ($sc_wrapper.find(".courses-list-search li").length > 1) {
						$sc_wrapper.find(".courses-list-search li").removeClass("ob-selected");
						if (selected.prev().length == 0) {
							selected.siblings().last().addClass("ob-selected");
						} else { // otherwise we just select the next one
							selected.prev().addClass("ob-selected");
						}
					}
				}
				if (event.keyCode == 40) {
					var selected = $(".ob-selected");
					if ($sc_wrapper.find(".courses-list-search li").length > 1) {
						$sc_wrapper.find(".courses-list-search li").removeClass("ob-selected");
						// if there is no element before the selected one, we select the last one
						if (selected.next().length == 0) {
							selected.siblings().first().addClass("ob-selected");
						} else { // otherwise we just select the next one
							selected.next().addClass("ob-selected");
						}
					}
				}
			});

			$sc_wrapper.find('.courses-list-search,.courses-search-input').on('click', function (event) {
				event.stopPropagation();
			});

			$(document).click(function () {
				$sc_wrapper.find(".courses-list-search li").remove();
			});

			this.searchFocus();

		},


		livesearch: function (element, waitKey) {
			var keyword = $(element).find('.courses-search-input').val();
			var $sc_wrapper = $(element);
			if (keyword) {
				if (!waitKey && keyword.length < 3) {
					return;
				}
				$sc_wrapper.addClass('loading');

				$.ajax({
					type   : 'POST',
					data   : 'action=thim_course_search&keyword=' + keyword + '&from=search',
					url    : ajaxurl,
					success: function (res) {
						var data_li = '';
						var items = res.data;
						if (res.success) {
							$.each(items, function (index) {
								if (index == 0) {
									data_li += '<li class="ui-menu-item' + this.id + ' ob-selected"><a class="ui-corner-all" href="' + this.guid + '">' + this.title + '</a></li>';
								} else {
									data_li += '<li class="ui-menu-item' + this.id + '"><a class="ui-corner-all" href="' + this.guid + '">' + this.title + '</a></li>';
								}
							});
							$sc_wrapper.find('.courses-list-search').html('').append(data_li);
						}
						thim_sc_course_search.searchHover();
						$sc_wrapper.removeClass('loading');
					},
				});
			}
		},

		searchHover: function () {
			var $sc_wrapper = $('.thim-sc-course-search');
			$sc_wrapper.on('hover', '.courses-list-search li', function () {
				$sc_wrapper.find('.courses-list-search li').removeClass('ob-selected');
				$(this).addClass('ob-selected');
			});
		},

		searchFocus: function () {
			var $sc_wrapper = $('.thim-sc-course-search');
			$sc_wrapper.each(function (index, form) {
				$(form).on('hover', 'form', function () {
					$(form).find('.courses-search-input').focus();
				});
			});

		},

	};

})(jQuery);