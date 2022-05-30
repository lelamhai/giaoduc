<?php
/**
 * @param Sneeit_Articles_Query_Item $item
 */
function fn_block_article_item_sticky($item) {
	$index = $item->index;
	
	if ($index > 0) {
		$item_class = 'item-w40 item-small';
		$item->args['auto_thumb'] = $item->args['small_auto_thumb'];
		$item->args['thumb_height'] = $item->args['small_thumb_height'];
	} else {
		$item_class = 'item-w60 item-big';
	}
	
	$args = $item->args;
	
	
	$html  = '<div'.$item->item_class($item_class).'>';
	$html .=	'<div class="item-inner">';
	
	// some layout need content on top
	if ($args['title_pos'] == 'above') {
		$html .= '<div class="item-top">';
		if ($args['cate_pos'] == 'above') {
			$html .= $item->categories();			
		}
		$html .= $item->title();
		$html .= '</div>';
	}
	
	// has thumb, we will start item mid
	if ($args['has_thumb']) {
		$html .= '<div class="item-mid">';
		$html .=	'<div class="item-mid-content"><div class="item-mid-content-inner">';		
		if ($args['item_layout'] == 'item-in-in') {
			$html .=	'<a href="'.$item->permalink.'" class="item-mid-content-gradient"></a>';
		}
		if ($args['cate_pos'] == 'in') {
			$html .= $item->categories();			
		}
		
		if ($args['item_layout'] == 'item-in-in') {
			$html  .= $item->title().$item->meta();
			if ($index == 0) {
				$html .= $item->snippet();
			}
		}
		
		$html .=	'</div></div>';
		$html .=	$item->format_icon().$item->review().$item->thumbnail();
		$html .= '</div>'; // end of item top
	}
	
	// some layout need content on bottom
	if ($args['title_pos'] != 'in') {
		$html .= '<div class="item-bot"><div class="item-bot-content">';
		if ($args['title_pos'] != 'above') {
			if ($args['cate_pos'] == 'above') {
				$html .= $item->categories();
			}
			$html .= $item->title();
		}		
		if ($args['cate_pos'] == 'under') {
			if (empty($item->args['meta_order'])) {
				$item->args['meta_order'] = '';
			}
			$item->args['meta_order'] = 'cat,'.$item->args['meta_order'];			
		}
		$html .= $item->meta();
		if ($index == 0) {
			$html .= $item->snippet();
		}
		$html .= '</div></div>';
	}
	
	$html .=	'</div>';
	$html .= '</div>';	
	
	return $html;
}

