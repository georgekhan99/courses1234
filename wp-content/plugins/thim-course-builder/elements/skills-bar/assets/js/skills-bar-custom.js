(function ($) {
	"use strict";

	$(document).ready(function () {
		thim_sc_skillsbar.ready();
	});

	var thim_sc_skillsbar = window.thim_sc_skillsbar = {

		ready: function () {
			$('.thim-sc-skills-bar').each(function (index, element) {
				var circle = $(element).find('.circle');
				$(circle).each(function (i, ele) {
					var value = $(ele).attr('data-value');
					var color = $(ele).attr('data-color');
					var emptyfill = $(ele).attr('data-emptyfill');
					var number = 0;
					var number2 = (parseInt(value / 100) + 1) * 100;
					if (value > 100) {
						number = value / number2;
					} else {
						number = value / 100;
					}
					$(ele).circleProgress({
						value     : number,
						thickness : 4,
						animation : {duration: 3500, easing: "circleProgressEasing"},
						fill      : {
							color: color
						},
						emptyFill : emptyfill,
						startAngle: -1.5
					}).on('circle-animation-progress', function (event, progress) {
						$(ele).find('.number').html(Math.round(value * progress));
					});
				});
			});
		},
	}

})(jQuery);