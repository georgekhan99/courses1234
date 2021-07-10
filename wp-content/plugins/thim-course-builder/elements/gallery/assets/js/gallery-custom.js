(function ($) {
	"use strict";

    $(window).load(function() {
        if( $('.thim-sc-gallery .wrapper-gallery-filter').length > 0 ) {
            $('.thim-sc-gallery .wrapper-gallery-filter').isotope({filter: '*'});
        }
    });

    $(document).on('click', '.thim-sc-gallery .filter-controls .filter', function (e) {
        e.preventDefault();
        var filter = $(this).data('filter'),
            filter_wraper = $(this).parents('.thim-sc-gallery').find('.wrapper-gallery');
        $('.filter-controls .filter').removeClass('active');
        $(this).addClass('active');
        filter_wraper.isotope({filter: filter});
    });

    $(document).on('click', '.thim-gallery-popup', function (e) {
        e.preventDefault();
        var elem = $(this),
            post_id = elem.attr('data-id'),
            data = {action: 'thim_gallery_popup', post_id: post_id};
        elem.addClass('loading');
        $.post(ajaxurl, data, function (response) {
            elem.removeClass('loading');
            $('.thim-gallery-show').append(response);
            if ($('.thim-gallery-show img').length > 0) {
                $('.thim-gallery-show').magnificPopup({
                    mainClass: 'my-mfp-zoom-in',
                    type: 'image',
                    delegate: 'a',
                    showCloseBtn: false,
                    gallery: {
                        enabled: true
                    },
                    callbacks: {
                        open: function () {
                            $.magnificPopup.instance.close = function () {
                                $('.thim-gallery-show').empty();
                                $.magnificPopup.proto.close.call(this);
                            };
                        },
                    }
                }).magnificPopup('open');
            } else {
                $.magnificPopup.open({
                    mainClass: 'my-mfp-zoom-in',
                    items: {
                        src: $('.thim-gallery-show'),
                        type: 'inline'
                    },
                    showCloseBtn: false,
                    callbacks: {
                        open: function () {
                            $.magnificPopup.instance.close = function () {
                                $('.thim-gallery-show').empty();
                                $.magnificPopup.proto.close.call(this);
                            };
                        },
                    }
                });
            }
        });
    });

    // $('.wrapper-gallery').magnificPopup({
    //     delegate: 'a',
    //     type: 'image',
    //     gallery: {
    //         enabled: true
    //     },
    //     zoom: {
    //         enabled: true,
    //         duration: 300,
    //         opener: function(element) {
    //             return element.find('img');
    //         }
    //     }
    // });


})(jQuery);