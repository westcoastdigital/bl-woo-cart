<?php
/**
 * Plugin Name: Woo Cart Shortcode
 * Plugin URI: https://www.beaverlodgehq.com
 * Description: Add a cart icon to your site for WooCommerce
 * Version: 1.0.0
 * Author: Jon Mather
 * Author URI: https://www.beaverlodgehq.com
 */

// Create cart shortcode
function bl_woo_cart_shortcode() {

	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	 
	    $count = WC()->cart->cart_contents_count;
	    ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php if ( $count > 0 ) echo '(' . $count . ')'; ?></a>
	 
	<?php }
}
add_shortcode( 'woocart', 'bl_woo_cart_shortcode' );

// Ensure cart contents update when products are added to the cart via AJAX
function bl_header_add_to_cart_fragment( $fragments ) {
 
    ob_start();
    $count = WC()->cart->cart_contents_count;
    ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php if ( $count > 0 ) echo '(' . $count . ')'; ?></a><?php
 
    $fragments['a.cart-contents'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'bl_header_add_to_cart_fragment' );

// Enqueue FontAwesome and CSS
function bl_woo_cart_scripts() {
    wp_enqueue_style( 'bl-woo-cart.css', plugins_url( 'bl-woo-cart.css' , __FILE__ ) );
    wp_enqueue_script( 'fontawesome.min.css', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css');
}
add_action( 'wp_enqueue_scripts', 'bl_woo_cart_scripts' );