<?php
do_action('sneeit_setup_menu_locations', array(	
	'top-menu' => esc_html__('Top Menu', 'flatnews'),
	'main-menu' => esc_html__('Main Menu', 'flatnews'),
	'footer-menu' => esc_html__('Footer Menu', 'flatnews'),
	'copyright-menu' => esc_html__('Copyright Menu', 'flatnews'),
));

do_action('sneeit_setup_compact_menu', array(
	'main-menu' => array( /* theme location*/
		/* general design */
		'container_class' => 'fn-main-menu-wrapper',
		'container_id' => 'fn-main-menu',		

		/* mega menu content */
		'mega_block_display_callback' => 'fn_block_menu_mega',		
		
		/* sticky menu */
		'sticky_enable' => get_theme_mod('sticky_menu', 'disable'),
		'sticky_logo' => get_theme_mod('sticky_menu_logo'),
		'sticky_logo_retina' => get_theme_mod('sticky_menu_logo_retina'),
		'sticky_holder' => '.fn-header-row-main-menu',
		'sticky_scroller' => '.fn-header-row-main-menu',
		
		/* mobile menu */
		'mobile_enable' => !get_theme_mod('disable_responsive', false),
		'mobile_container' => '.fn-mob-menu-box',
	)	
));

function fn_block_menu_mega($args = array()) {		
	$args = wp_parse_args($args, array(
		/* must be compatible to Sneeit Article Fields */
		'article_display_callback' => 'fn_menu_item_display',
		'pagination' => 'nextprev-ajax',
		'count' => 3,
		'thumb_height' => 200,
		'show_review_score' => 'on',
		'show_format_icon' => 'on',
		'number_cates' => 1,
		
		/*specific field from framework*/
		'menu_item_id' => time(),
	));
	$block_id = 'fn-block-menu-mega-'.$args['menu_item_id'];
	$args['block_id'] = $block_id;
	
	
	return	'<div id="'.$block_id.'" class="fn-block fn-block-mega-menu">'
				.'<div class="fn-block-content">'
					.'<div class="fn-block-content-inner">'.apply_filters('sneeit_articles_query', $args).'</div>'
				.'</div>'
				.'<div class="clear"></div><div class="fn-block-pagination"></div>'
				.'<div class="clear"></div>'				
			.'</div>'
			.'<div class="clear"></div>';
}

/**
 * @param Sneeit_Articles_Query_Item $item
 */
function fn_menu_item_display($item) {
	return (
	'<div'.$item->item_class().'>
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
