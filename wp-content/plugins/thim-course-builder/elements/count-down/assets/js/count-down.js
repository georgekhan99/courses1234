(function ($) {
	"use strict";

	$(window).load(function () {
		thim_sc_count_down.load();
	});

	var thim_sc_count_down = window.thim_sc_count_down = {

		load: function () {
			$('.thim-sc-count-down').each(function() {
				var $this = $(this),
					finalDate = $(this).attr('data-countdown');
				$this.countdown(finalDate, function(event) {
					$this.find('.days .number').text(
						event.strftime('%D')
					);
					$this.find('.hours .number').text(
						event.strftime('%H')
					);
					$this.find('.minutes .number').text(
						event.strftime('%M')
					);
					$this.find('.seconds .number').text(
						event.strftime('%S')
					);
				});
			});
		},
	}
	
})(jQuery);