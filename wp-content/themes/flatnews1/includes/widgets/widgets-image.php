<?php
function flatnews_widget_image( $args, $instance, $widget_id, $widget_declaration) {	
	flatnews_widget_common_header('fn-widget-image', $instance, $args);		
	
	$html = '';
	
	if (wp_is_mobile() && !empty($instance['mobile_image'])) {
		$instance['image'] = $instance['mobile_image'];
	}
	if (wp_is_mobile() && !empty($instance['mobile_image_retina'])) {
		$instance['image_retina'] = $instance['mobile_image_retina'];
	}
	
	if (!empty($instance['image'])) {				
		$html .= '<img alt="widget-image" src="'.$instance['image'].'"';
		if (!empty($instance['image_retina'])) {
			$html .= ' data-retina="'.$instance['image_retina'].'"';
		}
		$html .= '/>';
		
		if (!empty($instance['image_link'])) {
			$temp = '<a href="'.$instance['image_link'].'"';
			if (!empty($instance['new_window'])) {
				$temp .= ' target="_blank"';
			}
			$temp .= '>'.$html.'</a>';
			$html = $temp;
		}		
	}
	echo $html;
	
	flatnews_widget_common_footer();	
}