<?php
function flatnews_shortcode_slider_display( $atts = array(), $content = "" ) {		
	return fn_block('slider', $atts, $content);
}
function flatnews_shortcode_carousel_display( $atts = array(), $content = "" ) {
	return fn_block('carousel', $atts, $content);
}
function flatnews_shortcode_grid_display( $atts = array(), $content = "" ) {
	return fn_block('grid', $atts, $content);
}
function flatnews_shortcode_sticky_display( $atts = array(), $content = "" ) {
	return fn_block('sticky', $atts, $content);
}
function flatnews_shortcode_flex_display( $atts = array(), $content = "" ) {
	return fn_block('flex', $atts, $content);
}
function flatnews_shortcode_blog_display( $atts = array(), $content = "" ) {
	return fn_block('blog', $atts, $content);
}
