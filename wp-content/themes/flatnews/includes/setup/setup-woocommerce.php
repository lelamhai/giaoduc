<?php
add_filter( 'woocommerce_breadcrumb_home_url', 'flatnews_woocommerce_breadcrumb_home_url' );
function flatnews_woocommerce_breadcrumb_home_url() {
	return get_permalink( woocommerce_get_page_id( 'shop' ) );
}

add_filter( 'is_woocommerce', 'flatnews_is_woocommerce' );
function flatnews_is_woocommerce( $is_woocommerce ) {
	if (is_cart() || is_checkout()) {
		return true;
	}
	
	return $is_woocommerce;
}