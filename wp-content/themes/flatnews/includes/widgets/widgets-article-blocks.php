<?php
function flatnews_widget_slider_display( $args, $instance, $widget_id, $widget_declaration ) {		
	echo fn_block('slider', $instance);	
}
function flatnews_widget_carousel_display( $args, $instance, $widget_id, $widget_declaration ) {	
	echo fn_block('carousel', $instance);
}
function flatnews_widget_grid_display( $args, $instance, $widget_id, $widget_declaration ) {	
	echo fn_block('grid', $instance);
}
function flatnews_widget_sticky_display( $args, $instance, $widget_id, $widget_declaration ) {	
	echo fn_block('sticky', $instance);
}
function flatnews_widget_flex_display( $args, $instance, $widget_id, $widget_declaration ) {	
	echo fn_block('flex', $instance);
}
function flatnews_widget_blog_display( $args, $instance, $widget_id, $widget_declaration ) {	
	echo fn_block('blog', $instance);
}
