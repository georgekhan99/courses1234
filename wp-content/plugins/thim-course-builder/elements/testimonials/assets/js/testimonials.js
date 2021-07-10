(function ($) {
	"use strict";

	$(window).load(function () {
		thim_sc_testimonials.init();
	});

	var rtlval = false;
	if ($('body').hasClass('rtl')) {
		var rtlval = true;
	}

	var thim_sc_testimonials = window.thim_sc_testimonials = {

		init: function () {
			this.layout_1();
			this.layout_2();
			this.layout_3();
			this.layout_4();
			this.layout_5();
			this.layout_6();
			this.layout_7();
			this.layout_8();
		},


		layout_1: function () {
			// reference for main items
			var $sc = $('.thim-sc-testimonials.layout-1');
			var slider = $sc.find('.slider');
			// reference for thumbnail items
			var thumbnailSlider = $sc.find('.thumbnail-slider');
			//transition time in ms
			var duration = 250;

			// carousel function for main slider
			slider.owlCarousel({
				rtl  : rtlval,
				loop : false,
				nav  : false,
				items: 1
			}).on('changed.owl.carousel', function (e) {
				//On change of main item to trigger thumbnail item
				thumbnailSlider.trigger('to.owl.carousel', [e.item.index, duration, true]);
			});

			// carousel function for thumbnail slider
			thumbnailSlider.owlCarousel({
				rtl       : rtlval,
				loop      : false,
				center    : true, //to display the thumbnail item in center
				nav       : false,
				responsive: {
					0   : {
						items: 3
					},
					600 : {
						items: 4
					},
					1000: {
						items: 6
					}
				}
			}).on('click', '.owl-item', function () {
				// On click of thumbnail items to trigger same main item
				slider.trigger('to.owl.carousel', [$(this).index(), duration, true]);

			}).on('changed.owl.carousel', function (e) {
				// On change of thumbnail item to trigger main item
				slider.trigger('to.owl.carousel', [e.item.index, duration, true]);
			});


			//These two are navigation for main items
			$sc.on('click', '.slider-right', function () {
				slider.trigger('next.owl.carousel');
			});
			$sc.on('click', '.slider-left', function () {
				slider.trigger('prev.owl.carousel');
			});
		},

		layout_2: function () {

			var $sc = $('.thim-sc-testimonials.layout-2');

			$sc.each(function () {
				var elem = $(this).find('.slider'),
					autoplay = elem.data('autoplay') ? true : false,
					mousewheel = elem.data('mousewheel') ? true : false,
					itemsvisible = elem.data('itemsvisible');
				var testimonial_slider = elem.thimContentSlider({
					items            : elem,
					itemsVisible     : itemsvisible,
					mouseWheel       : mousewheel,
					autoPlay         : autoplay,
					itemMaxWidth     : 130,
					itemMinWidth     : 108,
					activeItemRatio  : 1.35,
					activeItemPadding: 0,
					itemPadding      : -24
				});
			});


		},

		layout_3: function () {
			// reference for main items
			var $sc = $('.thim-sc-testimonials.layout-3');
			var slider = $sc.find('.slider');

			// carousel function for main slider
			slider.owlCarousel({
				rtl  : rtlval,
				loop : false,
				nav  : false,
				dots : true,
				items: 1
			});

		},

		layout_4: function () {

			var $sc = $('.thim-sc-testimonials.layout-4');

			$sc.each(function () {
				var elem = $(this).find('.slider'),
					autoplay = elem.data('autoplay') ? true : false,
					mousewheel = elem.data('mousewheel') ? true : false;
				var testimonial_slider = elem.thimContentSlider({
					items            : elem,
					itemsVisible     : 3,
					mouseWheel       : mousewheel,
					autoPlay         : autoplay,
					itemMaxWidth     : 331,
					itemMinWidth     : 331,
					activeItemRatio  : 1.2,
					activeItemPadding: -120,
				});
			});
		},

		layout_5: function () {
			// reference for main items
			var $sc = $('.thim-sc-testimonials.layout-5');
			var slider = $sc.find('.slider');

			// carousel function for main slider
			slider.owlCarousel({
				rtl     : rtlval,
				loop    : false,
				nav     : false,
				dots    : true,
				items   : 1,
				autoplay: true,
				single  : true
			});
		},

		layout_6: function () {
			var $sc = $('.thim-sc-testimonials.layout-6');
			var sync1 = $sc.find('#slider');
			var sync2 = $sc.find('#thumbnails');
			var flag = false;
			var slides = sync1.owlCarousel({
				items    : 1,
				nav      : false,
				mouseDrag: false,
				loop     : true
			}).on('change.owl.carousel', function (e) {
				if (e.namespace && e.property.name === 'position' && !flag) {
					flag = true;
					thumbs.to(e.relatedTarget.relative(e.property.value), 300, true);
					flag = false;
				}
			}).data('owl.carousel');
			var thumbs = sync2.owlCarousel({
				responsive: {
					0   : {
						items: 1
					},
					768 : {
						items: 2
					},
					1000: {
						items: 3
					}
				},
				rtl       : rtlval,
				center    : true,
				loop      : true,
				nav       : true,
				navText   : ["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"],
				mouseDrag : false
			}).on('click', '.item', function (e) {
				e.preventDefault();
				var sliderIndex = parseInt($(this).attr('data-id'));
				sync1.trigger('to.owl.carousel', [sliderIndex - 1, 300, true]);
			}).on('change.owl.carousel', function (e) {
				if (e.namespace && e.property.name === 'position' && !flag) {
					flag = true;
					slides.to(e.relatedTarget.relative(e.property.value), 300, true);
					flag = false;
				}
			}).data('owl.carousel');
		},

		layout_7: function () {
			// reference for main items
			var $sc = $('.thim-sc-testimonials.layout-7');
			var slider = $sc.find('#slider');

			// carousel function for main slider
			slider.owlCarousel({
				rtl     : rtlval,
				loop    : false,
				nav     : true,
				dots    : false,
				items   : 1,
				autoplay: false,
				single  : true
			});
		},

		layout_8: function () {

			// reference for main items
			var $sc = $('.thim-sc-testimonials.layout-8');
			var slider = $sc.find('.slider');
			// reference for thumbnail items
			var thumbnailSlider = $sc.find('.thumbnail-slider');
			//transition time in ms
			var duration = 250;

			// carousel function for main slider
			slider.owlCarousel({
				rtl  : rtlval,
				loop : false,
				nav  : true,
				items: 1
			}).on('changed.owl.carousel', function (e) {
				//On change of main item to trigger thumbnail item
				thumbnailSlider.trigger('to.owl.carousel', [e.item.index, duration, true]);
			});

			// carousel function for thumbnail slider
			thumbnailSlider.owlCarousel({
				rtl       : rtlval,
				loop      : false,
				center    : true, //to display the thumbnail item in center
				nav       : false,
				responsive: {
					0   : {
						items: 3
					},
					600 : {
						items: 4
					},
					1000: {
						items: 6
					}
				}
			}).on('click', '.owl-item', function () {
				// On click of thumbnail items to trigger same main item
				slider.trigger('to.owl.carousel', [$(this).index(), duration, true]);

			}).on('changed.owl.carousel', function (e) {
				// On change of thumbnail item to trigger main item
				slider.trigger('to.owl.carousel', [e.item.index, duration, true]);
			});
		},
	};

})(jQuery);