<?php
function flatnews_widget_categories( $args, $instance, $widget_id, $widget_declaration) {	
	flatnews_widget_common_header('fn-widget-categories', $instance, $args);		
	
	$html = '';
	
	if (empty($instance['taxonomy']) || $instance['taxonomy'] != 'post_tag') {
		$instance['taxonomy'] = 'category';
	}	
	if (empty($instance['orderby'])) {
		$instance['orderby'] = 'name';
	}
	if (empty($instance['number']) || !is_numeric($instance['number'])) {
		$instance['number'] = 5;
	}
	if (empty($instance['order'])) {
		$instance['order'] = 'ASC';
	}
		
	
	$terms = get_terms(array(
		'taxonomy' => $instance['taxonomy'], 
		'orderby' => $instance['orderby'],
		'number' => (int) $instance['number'],
		'order' => $instance['order'],
	));
			
	if (!is_wp_error($terms)){
		foreach ($terms as $term) {
			$html .= '<li><a href="'.home_url();
			if ($instance['taxonomy'] == 'post_tag') {
				$html .= '?tag=';
			} else {
				$html .= '?cat=';
			}
			$html .= $term->term_id;
			
			$html .= '">'. $term->name .'</a>';
			if (!empty($instance['show_count'])) {
				$html .= ' <span> ('.$term->count.')</span>';
			}
			$html .= '</li>';
		}
	}
	if (!empty($html)) {
		$html = '<ul>' . $html . '</ul>';
	}
	
	
	
	echo $html;
	
	flatnews_widget_common_footer();	
}