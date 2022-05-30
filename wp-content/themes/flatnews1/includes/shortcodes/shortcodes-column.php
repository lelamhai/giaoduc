<?php

function flatnews_shortcode_column_display( $atts, $content = "" ) {
	extract(
		shortcode_atts(
			array(
				'class' => 100,
				'width' => 100,
				'padding' => '',								
				'sticky_inside' => false,
			),
			$atts
		)
	);
		
	if ($class) {
		$class = ' '.$class;
	}
	
	if ($sticky_inside) {
		$class .= ' fn-sticky-col';
	} else {
		$class .= ' no-sticky';
	}
	
	if ($padding) {
		$padding = ' st'.'yle="padding:'.$padding.'"';
	}
	
	
	
	$html = '<div class="column'.$class.'" sty'.'le="width:'.$width.'%"><div class="column-inner"'.$padding.'>'.do_shortcode($content).'</div></div>';
	return $html;
}