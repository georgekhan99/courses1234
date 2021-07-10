
(function ($) {
    "use strict";
    $(document).ready(function () {
        $(".nav-tabs a").on('click', function(e){
            e.preventDefault();

            var $current_status = $(this).attr("data-tab");
            if ($current_status == "upcoming") {
                $(".list-tab-event a").removeClass("active");
                $(".list-tab-event a[data-tab=upcoming]").addClass("active");

                $(".tab-content .tab-pane").removeClass("active");
                $(".tab-content #tab-upcoming").addClass("active");
            } else if ($current_status == 'happening') {
                $(".list-tab-event a").removeClass("active");
                $(".list-tab-event a[data-tab=happening]").addClass("active");

                $(".tab-content .tab-pane").removeClass("active");
                $(".tab-content #tab-happening").addClass("active");
            } else {
                $(".list-tab-event a").removeClass("active");
                $(".list-tab-event a[data-tab=expired]").addClass("active");

                $(".tab-content .tab-pane").removeClass("active");
                $(".tab-content #tab-expired").addClass("active");
            };

            $(this).tab('show');
        });
    });

})(jQuery);