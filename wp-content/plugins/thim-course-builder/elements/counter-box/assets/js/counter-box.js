/* jQuery CounTo */
(function ($) {
	"use strict";

	$(window).load(function () {
		thim_sc_counterbox.load();
	});

	var thim_sc_counterbox = window.thim_sc_counterbox = {
		load: function () {

			thim_sc_counterbox.counter();

			if (jQuery().waypoint) {

				$('.thim-sc-counter-box').waypoint(function () {

					$('.thim-sc-counter-box .counter_box .number_counter, .thim-sc-counter-box .item-counter-box .number_counter').each(function () {
						var number = jQuery(this).data('number'),
							thousands_sep = jQuery(this).data('thousands-sep');
						if (number == '') {
							$(this).addClass('number-none');
						}

						var count_args = {
							from: number,
							to  : number
						};

						if (1 === thousands_sep) {
							count_args.formatter = function (value, options) {
								return value.toLocaleString();
							}
						}

						$(this).countTo({
							from           : 0,
							to             : number,
							refreshInterval: 40,
							speed          : 1000,
							onComplete     : function (value) {
								$(this).countTo(count_args);
							}
						});
					});
				}, {
					triggerOnce: true,
					offset     : 'bottom-in-view'
				});
			}
		},

		counter: function () {
			var a = $;
			a.fn.countTo = function (g) {
				g = g || {};
				return a(this).each(function () {
					function e(a) {
						a = b.formatter.call(h, a, b);
						f.html(a);
					}

					var b = a.extend({}, a.fn.countTo.defaults, {
							from           : a(this).data("from"),
							to             : a(this).data("to"),
							speed          : a(this).data("speed"),
							refreshInterval: a(this).data("refresh-interval"),
							decimals       : a(this).data("decimals")
						}, g), j = Math.ceil(b.speed / b.refreshInterval), l = (b.to - b.from) / j, h = this, f = a(this),
						k = 0, c = b.from, d = f.data("countTo") || {};
					f.data("countTo", d);
					d.interval && clearInterval(d.interval);
					d.interval =
						setInterval(function () {
							c += l;
							k++;
							e(c);
							"function" == typeof b.onUpdate && b.onUpdate.call(h, c);
							k >= j && (f.removeData("countTo"), clearInterval(d.interval), c = b.to, "function" == typeof b.onComplete && b.onComplete.call(h, c));
						}, b.refreshInterval);
					e(c);
				});
			};
			a.fn.countTo.defaults = {
				from       : 0, to: 0, speed: 1E3, refreshInterval: 100, decimals: 0, formatter: function (a, e) {
					return a.toFixed(e.decimals);
				}, onUpdate: null, onComplete: null
			};
		}
	}
})(jQuery);
