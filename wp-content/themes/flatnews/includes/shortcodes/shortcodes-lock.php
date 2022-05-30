<?php
function flatnews_shortcode_lock_display( $atts = array(), $content = "" ) {	
	if ($content) {
		$ret = 		
		'<div class="locked-content-data hide" data-id="'. get_the_ID() .'" data-title="'. esc_attr(get_the_title()).'">'.do_shortcode($content).'</div>';
		return $ret;
	}
}
