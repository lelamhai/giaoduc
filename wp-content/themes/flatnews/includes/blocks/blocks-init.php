<?php
require_once FLATNEWS_THEME_PATH_BLOCKS . 'blocks-style.php';
require_once FLATNEWS_THEME_PATH_BLOCKS . 'blocks-header.php';
require_once FLATNEWS_THEME_PATH_BLOCKS . 'blocks-slider.php';
require_once FLATNEWS_THEME_PATH_BLOCKS . 'blocks-carousel.php';
require_once FLATNEWS_THEME_PATH_BLOCKS . 'blocks-grid.php';
require_once FLATNEWS_THEME_PATH_BLOCKS . 'blocks-blog.php';
require_once FLATNEWS_THEME_PATH_BLOCKS . 'blocks-sticky.php';
require_once FLATNEWS_THEME_PATH_BLOCKS . 'blocks-flex.php';
require_once FLATNEWS_THEME_PATH_BLOCKS . 'blocks-content.php';

function fn_block($type, $args, $content = '') {	
	if (!empty($args['orderby']) && 
		strpos($args['orderby'], 'related') !== false && 
		(!is_single() && !is_admin()) ||
		$type && empty($args['item_layout']) && 'slider' != $type && 'carousel' != $type && 'grid' != $type) {	
		return;
	}
	
	static $block_index = 0;
	$block_id = 'fn-block-'.$block_index;	
	$args = wp_parse_args($args, array(
		'block_description' => $content,
		'type' => $type,
		'article_display_callback' => 'fn_block_article_item_'.$type,
		'%s ago' => esc_html__('%s ago', 'flatnews'),
		'Read More' => esc_html__('Read More', 'flatnews'),
		'format_icon_map' => array(
			'aside' => '',
			'chat' => '',
			'gallery' => '',
			'link' => '',
			'image' => '<i class="fa fa-camera-retro"></i>',
			'quote' => '',
			'status' => '',
			'video' => '<i class="fa fa-play-circle-o"></i> ',
			'audio' => '<i class="fa fa-music"></i>'
		),		
	));
	
		
	if (!empty($args['pagination'])) {
		$args['block_id'] = $block_id;
	}
	
	// block pre-process args
	/////////////////////////	
	// general		
	if (!empty($args['meta_order']) && strpos($args['meta_order'], 'date') > 0) {
		$args['before_date_time'] = '- ';
	} else {
		$args['before_date_time'] = '';
	}	
	if (!isset($args['thumb_height']) || !is_numeric($args['thumb_height'])) {
		$args['thumb_height'] = 150;
	}
	$args['thumb_height'] = (int) $args['thumb_height'];	
		
	// blog and sticky and flex
	if ('blog' == $type || 'sticky' == $type || 'flex' == $type) {
		// validate column
		if (empty($args['columns']) || !is_numeric($args['columns'])) {
			$args['columns'] = 1;
		}
		$args['columns'] = (int) $args['columns'];

		// calculate thumbnail option for sticky
		// we not allow disable thumbnail in this block
		if ('sticky' == $type) {
			if ($args['thumb_height'] == 0) {
				$args['thumb_height'] == 10;
			}
			if (!isset($args['big_thumb_height']) || !is_numeric($args['big_thumb_height'])) {
				$args['big_thumb_height'] = 150;
			}
			$args['big_thumb_height'] = (int) $args['big_thumb_height'];
			if ($args['big_thumb_height'] == 0) {
				$args['big_thumb_height'] == 10;
			}
		}
		
		// calculate post count for flex
		if ('flex' == $type) {			
			if ($args['flex_layout'] == 'flex-layout-one-big') {			
				$args['count'] = ((int) $args['first_col_count']) + ($args['columns'] - 1) * ((int) $args['other_col_count']);			
			} else {
				$args['col_count'] = (int) $args['col_count'];
				$args['count'] = $args['col_count'] * $args['columns'];
			}
		}
		
		// some item layout not allow disable thumbnail
		$args['has_thumb'] = true;
		if (empty($args['auto_thumb']) && 'sticky' != $type) {
			if (in_array(
				$args['item_layout'], 
				array(
					'item-in-in', 
					'item-underover-in', 
					'item-underover-above',
					'item-underover-under'
				)
			) &&
				($args['thumb_height'] == 0)
			) {
				$args['thumb_height'] = 150;
			} else if ($args['thumb_height'] == 0) { // other cases, we can disable thumb
				$args['has_thumb'] = false;
			} // end if check array
		}
		
		// if has no thumb, some elements must be disable either (format icon, review score and number cates
		if (!$args['has_thumb']) {
			$args['show_format_icon'] = false;
			$args['show_review_score'] = false;
			if (in_array(
					$args['item_layout'], 
					array(						
						'item-under-in', 
						'item-underover-in', 
						'item-above-in',
						'item-right-in',
						'item-left-in'
					)
				)
			) {
				$args['number_cates'] = 0;
			} // end if check array
		} // end if check has thumb		
		
		// layout args, to prevent multiple calculation in each item
		$lay_ele = explode('-', $args['item_layout']);
		$args['cate_pos'] = $lay_ele[2];
		$args['title_pos'] = $lay_ele[1];
		$args['item_extra_class'] = '';
		if ('blog' == $type || 'flex' == $type) {
			$args['item_extra_class'] .= 'item-w'.((int) (100 / $args['columns']));
			
			if ('flex' == $type) {
				$args['item_extra_class'] .= ' item-small';
			}
		}		
		$args['item_extra_class'] .= ' ' . $args['item_layout'] . ' item-cate-'.$args['cate_pos'] . ' item-title-'.$args['title_pos'];
		if ($args['title_pos'] == 'left' || $args['title_pos'] == 'right') {
			$args['item_extra_class'] .= ' item-ho';
		}
				
		// FOR BIG ITEM OF FLEX BLOCK
		//////////////////////////////
		if ('flex' == $type) {
			// some item layout not allow disable thumbnail
			$args['big_has_thumb'] = true;
			if (empty($args['big_auto_thumb']) && 'sticky' != $type) {
				if (in_array(
					$args['big_item_layout'], 
					array(
						'item-in-in', 
						'item-underover-in', 
						'item-underover-above',
						'item-underover-under'
					)
				) &&
					($args['big_thumb_height'] == 0)
				) {
					$args['big_thumb_height'] = 150;
				} else if ($args['big_thumb_height'] == 0) { // other cases, we can disable thumb
					$args['big_has_thumb'] = false;
				} // end if check array
			}

			// if has no thumb, some elements must be disable either (format icon, review score and number cates
			if (!$args['big_has_thumb']) {
				$args['big_show_format_icon'] = false;
				$args['big_show_review_score'] = false;
				if (in_array(
						$args['big_item_layout'], 
						array(						
							'item-under-in', 
							'item-underover-in', 
							'item-above-in',
							'item-right-in',
							'item-left-in'
						)
					)
				) {
					$args['big_number_cates'] = 0;
				} // end if check array
			} // end if check has thumb		

			// layout args, to prevent multiple calculation in each item
			$lay_ele = explode('-', $args['big_item_layout']);
			$args['big_cate_pos'] = $lay_ele[2];
			$args['big_title_pos'] = $lay_ele[1];
			$args['big_item_extra_class'] = '';
			$args['big_item_extra_class'] .= 'item-big item-w'.((int) (100 / $args['columns']));					
			$args['big_item_extra_class'] .= ' ' . $args['big_item_layout'] . ' item-cate-'.$args['big_cate_pos'] . ' item-title-'.$args['big_title_pos'];			
//			var_dump($args);
		} // end of big item of flex
	} // end if check type blog
	
	// slider and carousel
	if ('slider' == $type || 'carousel' == $type) {
		if (empty($args['thumb_height'])) {
			$args['thumb_height'] = 400;
		}
		
		if ('carousel' == $type) {
			$args['thumb_img_attr'] = array('class' => 'skip');
		}
	}	
	
	// BLOCK CLASS
	//////////////	
	$block_class = 'fn-block fn-'.$type;
	
	// slider / carousel
	if ('slider' == $type || 'carousel' == $type) {
		$block_class .= ' fn-owl';
		if (!empty($args['show_nav'])) {
			$block_class .= ' fn-owl-nav';
		}
		if (!empty($args['show_dots'])) {
			$block_class .= ' fn-owl-dots';
		}
		if (!empty($args['show_nav']) && !empty($args['show_dots'])) {
			$block_class .= ' fn-owl-nav-dots';
		}
		if (!empty($args['columns']) && is_numeric($args['columns'])) {	
			$args['columns'] = (int) $args['columns'];
			if ($args['columns'] > 1) {
				$args['item_extra_class'] = 'item-w'.((int) (100 / (int) $args['columns']));
				$block_class .= ' fn-owl-'.$args['columns'].'c';
			}	
		}
	}
	
	// blog
	if ('blog' == $type) {
		$block_class .= ' fn-blog-' . $args['item_layout'];		
		$block_class .= ' fn-blog-'.$args['columns'].'c';
		
		if ($args['columns'] > 1 && 			
			$args['item_align'] == 'flex') {
			$block_class .= ' fn-masonry fn-masonry-align-'.$args['item_align'];
		} else {
			$block_class .= ' fn-blog-static';
		}
		
		if (empty($args['has_thumb'])) {
			$block_class .= ' fn-item-no-thumb';
		}		
		
	}
	
	if ((!empty($args['item_highlight']) && 
		 !empty($args['item_layout']) && 
		 in_array($args['item_layout'], 
			array(
				'item-under-in',
				'item-under-above',
				'item-under-under',
				'item-underover-in',
				'item-underover-above',
				'item-underover-under',
				'item-above-in',
				'item-above-above',
				'item-above-under',
			)
		)) || 
		(!empty($args['big_item_highlight']) && 
		 !empty($args['big_item_layout']) && 
		 in_array($args['big_item_layout'], 
			array(
				'item-under-in',
				'item-under-above',
				'item-under-under',
				'item-underover-in',
				'item-underover-above',
				'item-underover-under',
				'item-above-in',
				'item-above-above',
				'item-above-under',
			)
		))
	) {
		$block_class .= ' fn-item-hl';
	}
	
	// flex
	if ('flex' == $type) {
		$block_class .= ' fn-flex-' . $args['flex_layout'];	
		$block_class .= ' fn-flex-'.$args['columns'].'c';
		
		if ($args['columns'] > 1) {
			$block_class .= ' fn-masonry';
		}
				
		if (!empty($args['item_hightlight']) && 
			in_array($args['flex_layout'], 
				array(
					'item-under-in',
					'item-under-above',
					'item-under-under',
					'item-underover-in',
					'item-underover-above',
					'item-underover-under',
					'item-above-in',
					'item-above-above',
					'item-above-under',
				)
			)
		) {
			$block_class .= 'fn-item-hl';
		}
	}
	
	// grid
	if ('grid' == $type) {
		$block_class .= ' ' . $args['grid_layout'];		
	}
	$block_class = ' class="'.$block_class.'"';
	
	// block data
	/////////////
	$data = '';	
	if ('slider' == $type || 'carousel' == $type) {	
		$data .= ' data-speed="'.$args['speed'].'"';		
		if ('carousel' == $type) {
			$data .= ' data-columns="'.$args['columns'].'"';	
		} else {
			$data .= ' data-columns="1"';
		}
	}
	if ('blog' == $type || 'flex' == $type) {
		$data .= ' data-columns="'.$args['columns'].'"';		
	}
	if ('flex' == $type) {
		// not allow to resize to 1 column
		if ($args['columns'] > 2) {
			$data .= ' data-ex_c="2"'; 
		}		
		
		// not provide max number item for col 0
		if ($args['flex_layout'] == 'flex-layout-one-big') { 
			$data .= ' data-col_struct="'.$args['first_col_count'];
			if ($args['columns'] > 1) {
				for ($i = 1; $i < $args['columns']; $i++) {
					$data .= (','.$args['other_col_count']);
				}
			}
			$data .= '"';
		}		
	}
	
	// output block html
	// this is ajax, return content only
	if ($content == '0') {		
		return fn_block_content($type, $args, $content);
	}
	
	// else, just return full html
	$html = fn_block_style($block_id, $type, $args);
	$html .= '<div id="'.$block_id.'"'.$block_class.$data.'>';
	$html .= fn_block_header($type, $args);
	$html .= fn_block_content($type, $args);
	$html .= '</div>';

	$block_index++;
	
	return $html;
}
do_action('sneeit_articles_pagination', 
	array(
		/* the php function that will 
		 * process the args of block including
		 * pagination data
		 * 
		 * This function will return the html 
		 * of posts to display after querying
		 * 
		 * the function must be like: func($args)
		 * when $args is the article query & display fields
		 * of your article block
		 */
		'ajax_handler' => 'fn_block_pagination',
		
		/* the html element that we will be 
		 * used to contain the updated pagination html
		 */
		'pagination_container' => '.fn-block-pagination',
		
		/* the html element that we will be 
		 * used to contain the data from ajax_handler
		 */
		'content_container' => '.fn-block-content-inner',
		
		/* the JavaScript function that will be called
		 * after ajax return result 
		 * but before processing content from ajax_handler
		 * 
		 * We will use this function to alter data & 
		 * args before the content will be process to display
		 * 
		 * func(block_id, args, data)
		 */
		'ajax_function_before' => '',
		
		/* the JavaScript function that will be called
		 * after the return content from ajax_handler 
		 * has already displayed (append)
		 * 
		 * We will use this function to add some actions
		 * or html extra processes (like optimizing images)
		 * 
		 * func(block_id, args, data)
		 */
		'ajax_function_after' => 'fn_block_pagination',
		
		/* translation texts for the pagination with NUMBER style */
		'number' => array(
			'status_text' => esc_html__('%1$s / %2$s Posts', 'flatnews'), // blank to hide
			'older_text' => wp_kses(__('<i class="fa fa-caret-right"></i>', 'flatnews'), array(
				'i' => array(
					'class' => array()
				)
			)), // blank to hide
			'newer_text' => wp_kses(__('<i class="fa fa-caret-left"></i>', 'flatnews'), array(
				'i' => array(
					'class' => array()
				)
			)), // blank to hide
			'loading_text' => wp_kses(__('<i class="fa fa-spinner fa-pulse"></i>', 'flatnews'), array(
				'i' => array(
					'class' => array()
				)
			)), // required to show
		),
		
		/* translation texts for the pagination with LOADMORE style */
		'loadmore' => array(
			'button_text' => wp_kses(__('Load More <i class="fa fa-caret-down"></i>', 'flatnews'), array(
				'i' => array(
					'class' => array()
				)
			)), // required to show
			'loading_text' => wp_kses(__('<i class="fa fa-spinner fa-pulse"></i>', 'flatnews'), array(
				'i' => array(
					'class' => array()
				)
			)), // required to show
			'end_text' => esc_html__('Loaded all posts', 'flatnews'), // blank to hide
		),
		
		/* translation texts for the pagination with NEXT/PREV style */
		'nextprev' => array(
			'status_text' => esc_html__('%1$s / %2$s Posts', 'flatnews'), // blank to hide
			'older_text' => wp_kses(__('<i class="fa fa-caret-right"></i>', 'flatnews'), array(
				'i' => array(
					'class' => array()
				)
			)), // blank to hide
			'newer_text' => wp_kses(__('<i class="fa fa-caret-left"></i>', 'flatnews'), array(
				'i' => array(
					'class' => array()
				)
			)), // blank to hide
			'loading_text' => wp_kses(__('<i class="fa fa-spinner fa-pulse"></i>', 'flatnews'), array(
				'i' => array(
					'class' => array()
				)
			)), // required to show
		),
		
		/* translation texts for the pagination with INFINITE style */
		'infinite' => array(
			'end_text' => esc_html__('Loaded all posts', 'flatnews'), // blank to hide
			'loading_text' => wp_kses(__('<i class="fa fa-spinner fa-pulse"></i>', 'flatnews'), array(
				'i' => array(
					'class' => array()
				)
			)), // required to show
		)
	)
);