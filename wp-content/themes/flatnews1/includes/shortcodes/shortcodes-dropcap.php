<?php

function flatnews_shortcode_dropcap_display( $atts = array(), $content = "" ) {
	if ($content) {
		return '<span class="dropcap color firstcharacter">'.do_shortcode($content).'</span>';
	}
}