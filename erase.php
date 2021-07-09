<?php 
function coupon_number() {

// get customer orders
$customer_orders = get_posts( array(
    'numberposts' => -1,
    'meta_key'    => '_customer_user',
    'meta_value'  => get_current_user_id(),
    'post_type'   => wc_get_order_types(),
    'post_status' => array_keys( wc_get_order_statuses() ),
) );

if ($customer_orders) :

foreach ($customer_orders as $customer_order) :
$order = new WC_Order();

$order->populate( $customer_order );
// if customer has used coupons previously
 if( $order-> get_coupon_codes() ) {
	 $couponslist=true;
 }

endforeach;
endif;

return $couponslist;
}



// hide coupon field on the cart page
function disable_coupon_field_on_cart( $enabled ) {
	if ( is_cart() && coupon_number()) {
		$enabled = false;
	}
	return $enabled;
}
add_filter( 'woocommerce_coupons_enabled', 'disable_coupon_field_on_cart' );


// hide coupon field on the checkout page
function disable_coupon_field_on_checkout( $enabled ) {
	if ( is_checkout() && coupon_number()) {
		$enabled = false;
	}
	return $enabled;
}
add_filter( 'woocommerce_coupons_enabled', 'disable_coupon_field_on_checkout' );
