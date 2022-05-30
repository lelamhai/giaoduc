<?php
function fn_grid_padding($block_id, $paddings = array()) {		
	if (is_rtl()) {			
		$p_left = 'padding-right:'; 
		$p_right = 'padding-left:';		
	} else {		
		$p_left = 'padding-left:';
		$p_right = 'padding-right:';
	}
	
	$style = '';
	
	foreach ($paddings as $index => $pad) {
		$style .= $block_id .' .item-grid-' . $index . ' .item-inner{';
		if (!empty($pad[0])) {
			$style .= 'padding-top:'.$pad[0].'px;';
		}
		if (!empty($pad[1])) {
			$style .= $p_left.$pad[1].'px;';
		}
		if (!empty($pad[2])) {
			$style .= $p_right.$pad[2].'px;';
		}
		if (!empty($pad[3])) {
			$style .= 'padding-bottom:'.$pad[3].'px;';
		}
		
		$style .= '}';
	}
	
	return $style;
}

function fn_block_style($block_id, $type, $args) {
	$style = '';
	$block_id = '#'.$block_id;
	
	// thumbnail style	
	switch ($type) {
		case 'carousel':		
		case 'slider':						
			$style .= $block_id.' .fn-block-content{height:'.$args['thumb_height'].'px}';				
			break;

		case 'grid':			
			$style .= $block_id.' .fn-grid-stage{height:'.$args['thumb_height'].'px}';						
			break;

		case 'blog':
			if ($args['has_thumb'] && empty($args['auto_thumb'])) {
				$style .= $block_id.' .item-mid {height:'.$args['thumb_height'].'px}';
			}				
			break;

		case 'sticky':
			if (empty($args['auto_thumb'])) {
				$style .= ($block_id.' .item-big .item-mid {height:'.($args['thumb_height']).'px}');
			}
			if (empty($args['small_auto_thumb'])) {
				$style .= ($block_id.' .item-small .item-mid {height:'.$args['small_thumb_height'].'px}');
			}

			break;

		case 'flex':				
			if ($args['has_thumb'] && empty($args['auto_thumb'])) {
				$style .= ($block_id.' .item-small .item-mid {height:'.($args['thumb_height']).'px}');
			}
			if ($args['big_has_thumb'] && empty($args['big_auto_thumb'])) {
				$style .= ($block_id.' .item-big .item-mid {height:'.$args['big_thumb_height'].'px}');
			}
			break;

		default:
			break;
	} // end switch check type
	
	
	// item spacing
	if (!empty($args['item_spacing']) && is_numeric($args['item_spacing'])) {
		// dir left / right for rtl direction
		
		$sp = (int) $args['item_spacing'];
		
		switch ($type) {
			case 'sticky':				
				$sp_2 = $sp / 2;
				if (is_rtl()) {			
					$left = 'padding-right:'; 
					$right = 'padding-left:';		
				} else {		
					$left = 'padding-left:';
					$right = 'padding-right:';
				}
				$style .= $block_id.' .item {margin-top:'.$sp.'px}';
				$style .= $block_id.' .fn-block-content {margin-top:-'.$sp.'px}';
				$style .= $block_id.' .item-w60 .item-inner {'.$right.$sp_2.'px}';
				$style .= $block_id.' .item-w40 .item-inner {'.$left.$sp_2.'px}';
								
				break;
			
			/* data-fnc is the current masonry base on javascript
			 * this number is changed by JS
			 */
			case 'blog':				
			case 'flex':
				$sp_2 = $sp / 2;
				$sp_3 = $sp / 3;
				$sp_4 = $sp / 4;
				$sp_5 = $sp / 5;
				
				$sp_3x2 = $sp_3 * 2;
				$sp_4x2 = $sp_4 * 2;
				$sp_4x3 = $sp_4 * 3;
				$sp_5x2 = $sp_5 * 2;
				$sp_5x3 = $sp_5 * 3;
				$sp_5x4 = $sp_5 * 4;
				
				$style .= $block_id.' .fn-block-content {margin-top:-'.$sp.'px}';
				
				if (is_rtl()) {			
					$left = 'padding-right:'; 
					$right = 'padding-left:';		
				} else {		
					$left = 'padding-left:';
					$right = 'padding-right:';
				}
				if ('blog' == $type && (empty($args['item_align']) || $args['item_align'] != 'flex')) {
					$style .= $block_id.' .item{margin-top:'.$sp.'px}';
					$fnc = '.fn-blog-';
					$mas = 'c .item-blog-';
					$ele = ' .item-inner{';
				} else {
					$style .= $block_id.' .fn-masonry-col .item, ' . $block_id . '[data-columns="1"] .item {margin-top:'.$sp.'px}';
					$fnc = '[data-fnc="';
					$mas = '"] .fn-masonry-col-';
					$ele = ' .item .item-inner{';
				}
				
				
				/* you must include all just in case 
				 * the mansonry resize their column number*/
				// 2 cols
				$style .= $block_id.$fnc.'2'.$mas.'0'.$ele.$right.$sp_2.'px}';
				$style .= $block_id.$fnc.'2'.$mas.'1'.$ele.$left.$sp_2.'px}';
				
				// 3 cols								
				$style .= $block_id.$fnc.'3'.$mas.'0'.$ele.$right.$sp_3x2.'px}';
				$style .= $block_id.$fnc.'3'.$mas.'1'.$ele.$left.$sp_3.'px;'.$right.$sp_3.'px}';
				$style .= $block_id.$fnc.'3'.$mas.'2'.$ele.$left.$sp_3x2.'px}';
				
				// 4 cols
				$style .= $block_id.$fnc.'4'.$mas.'0'.$ele.$right.$sp_4x3.'px}';
				$style .= $block_id.$fnc.'4'.$mas.'1'.$ele.$left.$sp_4.'px;'.$right.$sp_4x2.'px}';
				$style .= $block_id.$fnc.'4'.$mas.'2'.$ele.$left.$sp_4x2.'px;'.$right.$sp_4.'px}';				
				$style .= $block_id.$fnc.'4'.$mas.'3'.$ele.$left.$sp_4x3.'px}';
				
				// 5 cols
				$style .= $block_id.$fnc.'5'.$mas.'0'.$ele.$right.$sp_5x4.'px}';
				$style .= $block_id.$fnc.'5'.$mas.'1'.$ele.$left.$sp_5.'px;'.$right.$sp_5x3.'px}';
				$style .= $block_id.$fnc.'5'.$mas.'2'.$ele.$left.$sp_5x2.'px;'.$right.$sp_5x2.'px}';
				$style .= $block_id.$fnc.'5'.$mas.'3'.$ele.$left.$sp_5x3.'px;'.$right.$sp_5.'px}';
				$style .= $block_id.$fnc.'5'.$mas.'4'.$ele.$left.$sp_5x4.'px}';
				break;
			
			////////////////////////////////////////////////////////////////
			// GRID
			////////////////////////////////////////////////////////////////
			case 'grid':			
				$style .= $block_id.' .fn-grid-stage{margin-top:'.$sp.'px}';
				
				switch ($args['grid_layout']) {
					case 'fn-grid-w50h100-2w25h100':
						$sp_3 = $sp / 3;
						$sp_3x2 = $sp_3 * 2;
						$style .= fn_grid_padding($block_id, array(
							/* COL 1 */
							array(			0, 
									0,				$sp_3x2, 
											0		
							),
							array(			0, 
									$sp_3,			$sp_3,
											0			
							),							
							array(			0, 
									$sp_3x2,		0, 
											0	
							),							
						));
						
						break;
					
					case 'fn-grid-2w33h66-5w33h33':
						$sp_2 = $sp / 2;
						$sp_3 = $sp / 3;
						$sp_3x2 = $sp_3 * 2;
						$style .= fn_grid_padding($block_id, array(
							/* COL 1 */
							array(			0, 
									0,				$sp_3x2, 
											$sp_2		
							),
							array(			0, 
									$sp_3,			$sp_3,
											$sp_3x2			
							),							
							array(			0, 
									$sp_3x2,		0, 
											$sp_2	
							),
							/*--------*/
							array(			$sp_3, 
									$sp_3,			$sp_3, 
											$sp_3
							),
							/*--------*/
							array(			$sp_2, 
									0,				$sp_3x2, 
											0	
							),							
							array(			$sp_3x2, 
									$sp_3,			$sp_3, 
											0
							),
							array(			$sp_2, 
									$sp_3x2,		0, 
											0			
							),
						));
						
						break;
					
					case 'fn-grid-2w50h70-5w20h30':
						$sp_2 = $sp / 2;
						$sp_5 = $sp / 5;
						$sp_5x2 = $sp_5 * 2;
						$sp_5x3 = $sp_5 * 3;
						$sp_5x4 = $sp_5 * 4;
						
						$style .= fn_grid_padding($block_id, array(
							/*BIG ITEMS*/
							array(			0, 
									0,				$sp_2, 
											$sp_2		
							),
							array(			0, 
									$sp_2,			0, 
											$sp_2			
							),
							/*SMALL ITEMS*/
							array(			$sp_2, 
									0,				$sp_5x4, 
											0			
							),
							array(			$sp_2, 
									$sp_5,			$sp_5x3, 
											0
							),
							array(			$sp_2, 
									$sp_5x2,		$sp_5x2, 
											0	
							),
							array(			$sp_2, 
									$sp_5x3,		$sp_5, 
											0
							),
							array(			$sp_2, 
									$sp_5x4,		0, 
											0			
							),
						));
						break;
					
					case 'fn-grid-2w50h60-3w33h40':
						$sp_2 = $sp / 2;
						$sp_3 = $sp / 3;
						$sp_3x2 = $sp_3 * 2;
						$style .= fn_grid_padding($block_id, array(
							/*BIG ITEMS*/
							array(			0, 
									0,				$sp_2, 
											$sp_2		
							),
							array(			0, 
									$sp_2,			0,
											$sp_2		
							),
							/*SMALL ITEMS*/
							array(			$sp_2, 
									0,				$sp_3x2, 
											0			
							),
							array(			$sp_2, 
									$sp_3,			$sp_3, 
											0			
							),
							array(			$sp_2, 
									$sp_3x2,		0, 
											0			
							),
						));
						break;
					
					case 'fn-grid-w60h100-3w40h33':
						$sp_2 = $sp / 2;
						$sp_3 = $sp / 3;
						$sp_3x2 = $sp_3 * 2;
						$style .= fn_grid_padding($block_id, array(
							/*BIG ITEMS*/
							array(			0, 
									0,				$sp_2, 
											0		
							),							
							/*SMALL ITEMS*/
							array(			0, 
									$sp_2,			0, 
											$sp_3x2	
							),
							array(			$sp_3, 
									$sp_2,			0, 
											$sp_3
							),
							array(			$sp_3x2, 
									$sp_2,			0, 
											0
							),							
						));							
						break;
					
					case 'fn-grid-w50h100-4w25h50':
						$sp_2 = $sp / 2;
						$sp_4 = $sp / 4;
						$sp_4x3 = $sp_4 * 3;
						$style .= fn_grid_padding($block_id, array(
							/*BIG ITEMS*/
							array(			0, 
									0,				$sp_2, 
											0		
							),							
							/*SMALL ITEMS*/
							array(			0, 
									$sp_2,			$sp_4, 
											$sp_2	
							),
							array(			0, 
									$sp_4x3,		0, 
											$sp_2
							),
							array(			$sp_2, 
									$sp_2,		$sp_4, 
											0
							),
							array(			$sp_2, 
									$sp_4x3,		0, 
											0
							),
						));							
						break;

					case 'fn-grid-w50h100-w50h50-2w25h50':
						$sp_2 = $sp / 2;
						$sp_4 = $sp / 4;
						$sp_4x3 = $sp_4 * 3;
						
						$style .= fn_grid_padding($block_id, array(
							/*BIG ITEMS*/
							array(			0, 
									0,				$sp_2, 
											0		
							),							
							/*SMALL ITEMS*/
							array(			0, 
									$sp_2,			0, 
											$sp_2	
							),
							array(			$sp_2, 
									$sp_2,			$sp_4, 
											0
							),
							array(			$sp_2, 
									$sp_4x3,		0, 
											0
							),
						));							
						break;

					default:
						$sp_2 = $sp / 2;
						
						$style .= fn_grid_padding($block_id, array(
							/*BIG ITEMS*/
							array(			0, 
									0,				$sp_2, 
											0		
							),							
							/*SMALL ITEMS*/
							array(			0, 
									$sp_2,			0, 
											$sp_2	
							),
							array(			$sp_2, 
									$sp_2,			0, 
											0
							),													
						));						
						break;
				} // end switch grid_layout
				
				break;
		

			default:
				break;
		} // end switch check type
	}// end if check item_space
	
	// block content text align
	if (!empty($args['text_align'])) {
		if ($args['text_align'] == 'center') {
			$style .= $block_id.' .item {text-align:center}';
		} else if ($args['text_align'] == 'center') {
			if (is_rtl()) {
				$style .= $block_id.' .item {text-align:left}';
			} else {
				$style .= $block_id.' .item {text-align:right}';
			}
		}
	}	
	
	if (!empty($args['block_color'])) {
		$style .= $block_id . ' .color,' . $block_id . ' .item-top .item-title a:hover,' . $block_id . ' .item-bot .item-title a:hover, .fn-bh-bot-border ' . $block_id . ' .fn-block-title a, .fn-bh-text-bg-bot-border ' . $block_id . ' .fn-block-title a.fn-block-explore-link {color:'.$args['block_color'].'}' . $block_id . ' .border,' . $block_id . ' .sneeit-percent-fill,' . $block_id . ' .sneeit-percent-mask,.fn-bh-text-bg-bot-border ' . $block_id . ' .fn-block-title,.fn-bh-bot-border ' . $block_id . ' .fn-block-title,' . $block_id . ' .sneeit-articles-pagination-content > a:hover{border-color:'.$args['block_color'].'}' . $block_id . ' .bg,' . $block_id . ' .item-mid .item-categories,.fn-bh-text-bg-bot-border ' . $block_id . ' .fn-block-title-text,' . $block_id . ' .fn-bh-full-bg .fn-block-title,' . $block_id . ' .item-meta .item-categories,' . $block_id . ' .sneeit-articles-pagination-content > a:hover,' . $block_id . '.fn-item-hl .item-big .item-bot-content, ' . $block_id . '.fn-item-hl .item-big .item-top, ' . $block_id . '.fn-item-hl .fn-blog .item-bot-content, ' . $block_id . '.fn-item-hl .fn-blog .item-top{background-color: '.$args['block_color'].'}';
	}
	
	
	if ($style) {
		return apply_filters('sneeit_inline_style', $style);
	}
}
