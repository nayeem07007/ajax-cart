<?php
/**
 * Plugin Name: Ajax Cart
 * Plugin URI: https://loyalcoder.com/
 * Description: An eCommerce toolkit that helps you sell anything. Beautifully.
 * Version: 1.0
 * Author: xs
 * Author URI: https://loyalcoder.com
 * Text Domain: woocommerce
 * Domain Path: /i18n/languages/
 */


 //  cart data 
 ! defined( 'AJAX_CART_URL' ) && define( 'AJAX_CART_URL', plugin_dir_url( __FILE__ ) );

 add_action( 'lc_ajax_cart', 'card_item_dispaly');

 function card_item_dispaly() {
     
    woocommerce_mini_cart();
 }



 // register script 

 function lc_ajax_cart_script() {
    wp_enqueue_script( 'lac_ajax_cart', AJAX_CART_URL . 'assets/js/ajax-cart.js', array( 'jquery' ), date('s'), true );
    wp_localize_script( 'lac_ajax_cart', 'lac_ajax_cart', [
        'ajaxurl'          => admin_url( 'admin-ajax.php' ),
        'nonce'            => wp_create_nonce( 'woofc-security' ),
    ] );
 }
 add_action( 'wp_enqueue_scripts', 'lc_ajax_cart_script');



 add_action( 'wp_ajax_lac_ajax_carts', 'lac_ajax_carts' );
add_action( 'wp_ajax_nopriv_lac_ajax_carts', 'lac_ajax_carts' );

function lac_ajax_carts(  ) {
    if ( isset( $_POST['cart_item_key'] ) ) {
        WC()->cart->remove_cart_item( $_POST['cart_item_key'] );
        WC_AJAX::get_refreshed_fragments();

       

        die();
    }
    print_r($_REQUEST['fruit']);
   
    wp_die();
}
