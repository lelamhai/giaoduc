<?php

function flatnews_widget_html_display( $args, $instance, $widget_id, $widget_declaration ) {
	if (	!empty($instance['text_display']) 
			&& 
			(	('mobile' == $instance['text_display'] && !wp_is_mobile()) 
				|| 
				('desktop' == $instance['text_display'] && wp_is_mobile())
			) 
		) {
		return;
	}
	
	flatnews_widget_common_header('fn-widget-html', $instance, $args);		
	if (!empty($instance['text_content'])) {
		if (isset($atts['text_format']) && $atts['text_format']) {
			echo $instance['text_content'];
		} else {
			echo wpautop(make_clickable(do_shortcode($instance['text_content'])));
		}
	}
	flatnews_widget_common_footer();
}