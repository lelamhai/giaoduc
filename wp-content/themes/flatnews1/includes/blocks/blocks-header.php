<?php

function fn_block_header($type = '', $args = array()) {
	$html = '';
	$html_desc = '';
	$args = wp_parse_args($args, array(
		'title_url' => '',
		'header_category_list' => '',
		'title_icon' => ''
	));
	if (!empty($args['block_description'])) {
		$html_desc = '<div class="fn-block-desc">'.apply_filters('the_content', wpautop($args['block_description'])).'</div>';		
	}
	
	if (empty($args['title'])) {
		return $html_desc;
	}
	static $block_header_layout = '';
	if (!$block_header_layout) {
		$block_header_layout = get_theme_mod('block_header_layout', 'text-bg');
	}
	
	// header wrapper start	
	$block_header_wrapper_class = 'fn-block-title';	
	$html .= '<h2 class="'.esc_attr($block_header_wrapper_class).'">';
	
	
	// header title
	$link = $args['title_url'];
	if (!$link) {
		$link = apply_filters('sneeit_articles_archive_link', $args);
	}
	
	$html .= '<a href="'.$link.'" class="fn-block-title-text">';
	if (!empty($args['title_icon'])) {		
		$html .= apply_filters('sneeit_font_awesome_tag', $args['title_icon']) . ' ';
	}
	$html.= $args['title'].'</a>';
	
	// header explore button
	if (!empty($args['explore_all'])) {
		$html .= '<a href="'.$link.'" class="fn-block-explore-link">'.$args['explore_all'].' '.apply_filters('sneeit_font_awesome_tag', 'fa-angle-right').'</a>';
	}
	
	
	// header wrapper end
	$html .= '</h2>';
	
	if (!empty($args['block_description'])) {
		$html .= $html_desc;		
	}
	
	return $html;
}