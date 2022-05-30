<?php
global $flatnews_shortcode_tab_id;
global $flatnews_shortcode_tab_list;
$flatnews_shortcode_tab_id = 0;
$flatnews_shortcode_tab_list = array();
function flatnews_shortcode_tabs_display( $atts = array(), $content = "" ) {
	if ($content) {
		global $flatnews_shortcode_tab_list;
		$flatnews_shortcode_tab_list = array();
		do_shortcode($content);
		if (!count($flatnews_shortcode_tab_list)) {
			// if content has no tab
			return do_shortcode($content);
		} else {
			if (empty($atts['id'])) {
				global $flatnews_shortcode_tab_id;
				$atts['id'] = 'shortcode-tab-'.$flatnews_shortcode_tab_id;
				$flatnews_shortcode_tab_id++;
			} else {
				$atts['id'] = flatnews_title_to_slug($atts['id']);
			}
			
			// output follow jquery ui tabs
			$ret = '<div class="clear"></div><div id="'.$atts['id'].'" class="shortcode-listing shortcode-'.$atts['style'].'tab">';	
			
			// code for title
			$ret .= '<ul class="tab-header">';
			for($i = 0; $i < count($flatnews_shortcode_tab_list); $i++) {				
				$ret .= '<li class="tab-title"><a href="javascript:void(0)" data-cont="'.esc_url('#'.$atts['id'].'-'.$i).'">'.$flatnews_shortcode_tab_list[$i]['atts']['title'].'</a></li>';
			}
			$ret .= '</ul>';

			// code for content
			for($i = 0; $i < count($flatnews_shortcode_tab_list); $i++) {			
				$ret .= '<div id="'.$atts['id'].'-'.$i.'" class="tab-content"><div class="inner">'.do_shortcode($flatnews_shortcode_tab_list[$i]['content']).'</div></div>';
			}
			
			// close tab
			$ret .= '<div class="clear"></div></div><div class="clear"></div>';
		}		
		return $ret;
	}
}

function flatnews_shortcode_tab_display( $atts = array(), $content = "" ) {
	global $flatnews_shortcode_tab_list;
	array_push($flatnews_shortcode_tab_list, array(
		'atts' => $atts,
		'content' => $content
	));
}
