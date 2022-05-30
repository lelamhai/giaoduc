<?php

global $flatnews_shortcode_accordion_id;
global $flatnews_shortcode_accordion_list;
$flatnews_shortcode_accordion_id = 0;
$flatnews_shortcode_accordion_list = array();
function flatnews_shortcode_accordions_display( $atts = array(), $content = "" ) {
	if ($content) {
		global $flatnews_shortcode_accordion_list;
		$flatnews_shortcode_accordion_list = array();
		do_shortcode($content);
		if (!count($flatnews_shortcode_accordion_list)) {
			// if content has no accordion
			return do_shortcode($content);
		} else {
			if (empty($atts['id'])) {
				global $flatnews_shortcode_accordion_id;
				$atts['id'] = 'fn-sc-acc-'.$flatnews_shortcode_accordion_id;
				$flatnews_shortcode_accordion_id++;
			} else {
				$atts['id'] = flatnews_title_to_slug($atts['id']);
			}
			
			// output follow jquery ui accordions
			$ret = '<div class="clear"></div><div id="'.esc_attr($atts['id']).'" class="shortcode-listing fn-sc-acc" data-multiple_open="'.esc_attr($atts['multiple_open']).'" data-close_all="'.esc_attr($atts['close_all']).'">';	
			
			// accordion item			
			for($i = 0; $i < count($flatnews_shortcode_accordion_list); $i++) {				
				$ret .= '<div class="fn-acc-i">' 
				. '<a href="javascript:void(0)" class="fn-acc-title fn-acc-title-'.esc_attr($i).'"><span class="fn-acc-title-text">'.$flatnews_shortcode_accordion_list[$i]['atts']['title'].'</span><i class="fa fa-angle-down fn-acc-title-icon-inactive fn-acc-title-icon"></i><i class="fa fa-angle-up fn-acc-title-icon-active fn-acc-title-icon"></i></a>'				
				. '<div class="fn-acc-cont"><div class="inner">'
				. do_shortcode($flatnews_shortcode_accordion_list[$i]['content']) . '</div></div><div class="clear"></div></div>';
			}
			
			// close accordion
			$ret .= '<div class="clear"></div></div><div class="clear"></div>';
		}
		return $ret;
	}
}

function flatnews_shortcode_accordion_display( $atts = array(), $content = "" ) {
	global $flatnews_shortcode_accordion_list;
	array_push($flatnews_shortcode_accordion_list, array(
		'atts' => $atts,
		'content' => $content
	));
}
