<?php

function fn_block_content($type = '', $args = array(), $content = '') {
	
	if ($content == '0') {				
		return apply_filters('sneeit_articles_query', $args);
	}
	
	$html = '';
	
	// class for inner block content	
	$html .= '<div class="fn-block-content"><div class="fn-block-content-inner">';
	$content_html = apply_filters('sneeit_articles_query', $args);
	if (is_string($content_html) && strpos($content_html, 'fn-grid-stage') !== false) {
		$content_html .= '<div class="clear"></div></div>'; // close grid stage		
	}
	if (is_string($content_html)) {
		$html .= $content_html;
	}	
	
	$html .= '</div>'; // end of content inner
	
	if (!empty($args['pagination'])) {
		$html .= '<div class="clear"></div><div class="fn-block-pagination"></div>';
	}
	$html .= '<div class="clear"></div></div>';
	
	return $html;
}