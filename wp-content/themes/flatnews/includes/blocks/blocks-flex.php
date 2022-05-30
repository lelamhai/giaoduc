<?php
/**
 * @param Sneeit_Articles_Query_Item $item
 */
function fn_block_article_item_flex($item) {	
	// copy data of big args to default args	
	if ($item->index % $item->args['count'] == 0 || 
		($item->args['flex_layout'] == 'flex-layout-top-big' && $item->index % $item->args['count'] < $item->args['columns'])){
		foreach ($item->args as $key => $value) {			
			if (strpos($key, 'big_') === false) {
				continue;
			}
			$key = str_replace('big_', '', $key);			
			$item->args[$key] = $value;			
		}
	}
	
	$args = $item->args;
	$index = $item->index;
	
	
			
	$html  = '<div'.$item->item_class().'>';
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
			$html  .= $item->title().$item->meta().$item->snippet();
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
		$html .= $item->snippet();
		$html .= '</div></div>';
	}

	$html .=	'</div>';
	$html .= '</div>';	
	
	return $html;
}

