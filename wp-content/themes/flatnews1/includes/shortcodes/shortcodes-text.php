<?php
function flatnews_shortcode_text_display( $atts = array(), $content = "" ) {	
	
	
	if (	!empty($atts['text_display']) 
			&& 
			(	('mobile' == $atts['text_display'] && !wp_is_mobile()) 
				|| 
				('desktop' == $atts['text_display'] && wp_is_mobile())
			) 
		) {
		return '';
	}
	
	if ($content) {
		if (isset($atts['text_format']) && $atts['text_format']) {
			return $content;
		} else {
			return wpautop(make_clickable(do_shortcode($content)));
		}
	}
}
