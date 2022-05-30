<?php

function flatnews_widget_social_icons( $args, $instance, $widget_id, $widget_declaration) {	
	flatnews_widget_common_header('fn-widget-social-icons', $instance);	
	
	$social_links = $instance['social_links'];
	if ($social_links) :
		echo apply_filters('sneeit_social_links_to_fontawesome', array(
			'urls' => $social_links, 
			'format' => 'a-tag')
		);
	endif;
	
	flatnews_widget_common_footer();
}