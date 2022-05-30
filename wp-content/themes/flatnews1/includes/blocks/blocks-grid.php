<?php
/**
 * @param Sneeit_Articles_Query_Item $item
 */
function fn_block_article_item_grid($item) {
	$item_class = '';
	$index = $item->index;	
	$args = $item->args;
	// item extra class
	$mod = 0;
	switch ($args['grid_layout']) {
		case 'fn-grid-w50h100-2w50h50':	
			$mod = $index % 3;
			if ($mod == 0) {
				$item_class = 'item-w50 item-h100';
			} else {
				$item_class = 'item-w50 item-h50';
				$item->args['snippet_length'] = 0;
				$item->args['meta_order'] = '';
			}
			break;

		case 'fn-grid-w50h100-w50h50-2w25h50':
			$mod = $index % 4;
			if ($mod == 0) {
				$item_class = 'item-w50 item-h100';
			} else if ($mod == 1) {
				$item_class = 'item-w50 item-h50';
				$item->args['snippet_length'] = 0;
				$item->args['meta_order'] = '';
			} else {
				$item_class = 'item-w25 item-h50';
				$item->args['snippet_length'] = 0;
				$item->args['meta_order'] = '';
			}			
			break;

		case 'fn-grid-w50h100-4w25h50':
			$mod = $index % 5;
			if ($mod == 0) {
				$item_class = 'item-w50 item-h100';
			} else {
				$item_class = 'item-w25 item-h50';
				$item->args['snippet_length'] = 0;
				$item->args['meta_order'] = '';
			}			
			break;

		case 'fn-grid-w60h100-3w40h33':
			$mod = $index % 4;
			if ($mod == 0) {
				$item_class = 'item-w60 item-h100';
			} else {
				$item_class = 'item-w40 item-h33';
				$item->args['snippet_length'] = 0;
				$item->args['meta_order'] = '';
			}			
			break;

		case 'fn-grid-2w50h60-3w33h40':
			$mod = $index % 5;
			if ($mod < 2) {
				$item_class = 'item-w50 item-h60';
			} else {
				$item_class = 'item-w33 item-h40';
				$item->args['snippet_length'] = 0;
				$item->args['meta_order'] = '';
			}			
			break;

		case 'fn-grid-2w50h70-5w20h30':
			$mod = $index % 7;
			if ($mod < 2) {
				$item_class = 'item-w50 item-h70';
			} else {
				$item_class = 'item-w20 item-h30';
				$item->args['snippet_length'] = 0;
				$item->args['meta_order'] = '';
			}			
			break;

		case 'fn-grid-2w33h66-5w33h33':
			$mod = $index % 7;
			if ($mod == 0 || $mod == 6) {
				$item_class = 'item-w33 item-h66';
			} else {
				$item_class = 'item-w33 item-h33';
				$item->args['snippet_length'] = 0;
				$item->args['meta_order'] = '';
			}			
			break;

		case 'fn-grid-w50h100-2w25h100':
			$mod = $index % 3;
			if ($mod == 0) {
				$item_class = 'item-w50 item-h100';
			} else {
				$item_class = 'item-w25 item-h100';
			}			
			break;
	}
	$item_class .= ' item-grid-'.$mod;	
	
	// stage wrapper element
	$grid_stage_wrapper = '';
	if (!empty($args['thumb_height']) && (int) $args['thumb_height'] > 0) {
		if ($index == 0) {
			$grid_stage_wrapper = '<div class="fn-grid-stage">';
		} else {
			switch ($args['grid_layout']) {
				case 'fn-grid-w50h100-2w50h50':	
					if ($index % 3 == 0) {
						$grid_stage_wrapper = '<div class="clear"></div></div><div class="fn-grid-stage">';
					}
					break;

				case 'fn-grid-w50h100-w50h50-2w25h50':			
					if ($index % 4 == 0) {
						$grid_stage_wrapper = '<div class="clear"></div></div><div class="fn-grid-stage">';
					}
					break;

				case 'fn-grid-w50h100-4w25h50':				
					if ($index % 5 == 0) {
						$grid_stage_wrapper = '<div class="clear"></div></div><div class="fn-grid-stage">';
					}
					break;

				case 'fn-grid-w60h100-3w40h33':				
					if ($index % 4 == 0) {
						$grid_stage_wrapper = '<div class="clear"></div></div><div class="fn-grid-stage">';
					}
					break;

				case 'fn-grid-2w50h60-3w33h40':
					if ($index % 5 == 0) {
						$grid_stage_wrapper = '<div class="clear"></div></div><div class="fn-grid-stage">';
					}
					break;

				case 'fn-grid-2w50h70-5w20h30':
					if ($index % 7 == 0) {
						$grid_stage_wrapper = '<div class="clear"></div></div><div class="fn-grid-stage">';
					}
					break;

				case 'fn-grid-2w33h66-5w33h33':
					if ($index % 7 == 0) {
						$grid_stage_wrapper = '<div class="clear"></div></div><div class="fn-grid-stage">';
					}
					break;

				case 'fn-grid-w50h100-2w25h100':			
					if ($index % 3 == 0) {
						$grid_stage_wrapper = '<div class="clear"></div></div><div class="fn-grid-stage">';
					}
					break;
			} // end switch
		} // end if check index
	} // end if check thumbnail height
	
		
	return (
	$grid_stage_wrapper .
	'<div'.$item->item_class($item_class).'>
		<div class="item-inner">
			<div class="item-mid">				
				<div class="item-mid-content"><div class="item-mid-content-inner">					
					<a href="'.$item->permalink.'" class="item-mid-content-gradient"></a>
					'.$item->categories().'
					'.$item->title().'
					'.$item->meta().'
					'.$item->snippet().'									
				</div></div>
				'.$item->format_icon().'
				'.$item->review().'
				'.$item->thumbnail().'
			</div>
		</div>
	</div>'
	);
}

