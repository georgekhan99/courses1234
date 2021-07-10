;(function ($) {
    function _ready() {
        $('#_lp_collection_courses').select2({
            placeholder: 'Select a course',
            minimumInputLength: 3,
            ajax: {
                url: ajaxurl,
                dataType: 'json',
                quietMillis: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        action: 'learnpress_search_course'
                    };
                },
                processResults: function( data ) {
                    var options = [];
                    if ( data ) {

                        // data is the array of arrays, and each of them contains ID and the Label of the option
                        $.each( data, function( index, text ) { // do not forget that "index" is just auto incremented value
                            options.push( { id: text[0], text: text[1]  } );
                        });

                    }
                    return {
                        results: options
                    };
                },
                cache: true
            },
            language: {
                noResults: function (params) {
                    return "There is no course to select.";
                }
            }
        });
    }
    $(document).ready(_ready);
})(jQuery);