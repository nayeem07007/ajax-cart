jQuery(function ($) {
    'use strict';
    $(document).on('click', '.clickchek', function () {
        var fruit = 'Banana';


        $.ajax({
            url: lac_ajax_cart.ajaxurl,
            data: {
                'action': 'lac_ajax_carts',
                'fruit': fruit,
                'nonce': lac_ajax_cart.nonce
            },
            success: function (data) {
                // This outputs the result of the ajax request
                console.log(data);
            },
            error: function (errorThrown) {
                console.log(errorThrown);
            }
        });

    });
});


