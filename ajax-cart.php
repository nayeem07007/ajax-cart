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
        'nonce'            => wp_create_nonce( 'ajax-security' ),
    ] );
    wp_localize_script( 'lac_ajax_cart', 'lac_ajax_cart_update', [
        'ajaxurl'          => admin_url( 'admin-ajax.php' ),
        'nonce'            => wp_create_nonce( 'ajax-security' ),
    ] );
 }
 add_action( 'wp_enqueue_scripts', 'lc_ajax_cart_script');



 add_action( 'wp_ajax_lac_ajax_cart_update', 'lac_ajax_cart_update' );
add_action( 'wp_ajax_nopriv_lac_ajax_cart_update', 'lac_ajax_cart_update' );

 add_action( 'wp_ajax_lac_ajax_carts', 'lac_ajax_carts' );
add_action( 'wp_ajax_nopriv_lac_ajax_carts', 'lac_ajax_carts' );


function lac_ajax_carts(  ) {

    WC()->cart->remove_cart_item($_REQUEST['cart_item_key']);
    WC_AJAX::get_refreshed_fragments();
    wp_die();

}


function lac_ajax_cart_update () {
   
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
        $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

        ?>
      <div class="cart-item">
      
      <a href="<?php echo esc_url($product_permalink); ?>"><?php echo get_the_title($cart_item['product_id']); ?>
        <?php  echo $thumbnail; ?>
      </a>
      <a href="javascript:void(0)" class="remove-cart-item" data-id="<?php echo esc_attr( $cart_item_key ) ?>">Removed</a>
      </div>
     
      <?php 
     

    } 
    wp_die();
}

function  ajax_cart_c() {
    ob_start(); 
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
        $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

        ?>
      <div class="cart-item">
      
      <a href="<?php echo esc_url($product_permalink); ?>"><?php echo get_the_title($cart_item['product_id']); ?>
        <?php  echo $thumbnail; ?>
      </a>
      <a href="javascript:void(0)" class="remove-cart-item" data-id="<?php echo esc_attr( $cart_item_key ) ?>">Removed</a>
      </div>
     
      <?php 
     

    } 
    return ob_get_clean();
}

add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

function woocommerce_header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;

    ob_start();

    ?>
    <a class="cart-customlocation" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo  WC()->cart->get_cart_contents_count(); ?></a>

    <?php

    $fragments['a.cart-customlocation'] = ob_get_clean();

    return $fragments;

}

// add to body 

add_action('wp_body_open', 'dispaly_cart');

function dispaly_cart() {
  ?>
  	<div class="cart-ajax_c">
	    <?php echo ajax_cart_c(); ?>
	</div>
  <?php 
} 
