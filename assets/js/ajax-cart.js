jQuery(function ($) {
    'use strict';
    $(document.body).on('added_to_cart', function (event, fragments, cart_hash, $button) {
        //jQuery(document.body).trigger('wc_fragment_refresh');

        $.ajax({
            url: lac_ajax_cart_update.ajaxurl,
            data: {
                'action': 'lac_ajax_cart_update',
                'porduct_id_add': $($button[0]).data('product_id'),
                'nonce': lac_ajax_cart_update.nonce
            },
            success: function (data) {
                // This outputs the result of the ajax request
                $('.cart-ajax_c').html(data);
                console.log(data);
                jQuery(document.body).trigger('wc_fragment_refresh');

            },
            error: function (errorThrown) {
                console.log('error');
            }
        });

        console.log('dd');
    });
    $(document).on('click', '.remove-cart-item', function (e) {
        e.preventDefault();
        var cart_item_key = $(this).data('id');
        var current = $(this);

        $.ajax({
            url: lac_ajax_cart.ajaxurl,
            data: {
                'action': 'lac_ajax_carts',
                'cart_item_key': cart_item_key,
                'nonce': lac_ajax_cart.nonce
            },
            success: function (data) {
                // This outputs the result of the ajax request
                console.log($(this).parent('.cart-item'));
                current.parent('.cart-item').fadeOut();
                jQuery(document.body).trigger('wc_fragment_refresh');

            },
            error: function (errorThrown) {
                console.log(errorThrown);
            }
        });

    });
});



