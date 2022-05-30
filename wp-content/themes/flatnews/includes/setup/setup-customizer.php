<?php
global $FNAB_Fields_Archive;
global $Fn_Content_Width;

$fn_archive_fiels = array();
foreach ($FNAB_Fields_Archive as $key => $value) {
	$fn_archive_fiels['archive_'.$key] = $value;
}
$fn_archive_fiels['archive_pagination']['default'] = 'number-reload';

function fn_customizer_sidebar_settings($prefix = '', $default_choice = false) {
	global $Fn_Sidebar_Register;
	
	$args = array();
		
	$sidebar_choices = array();
	if ($default_choice) {
		$sidebar_choices = array(
			'' => esc_html__('Default', 'flatnews')
		);
	}

	$sidebar_choices = array_merge($sidebar_choices, array(
		'disable' => esc_html__('None / Disable', 'flatnews')
	));
	foreach ($Fn_Sidebar_Register as $sidebar_id => $sidebar_declaration) {		
		$args[$prefix.'-'.$sidebar_id] = array(
			'label' => $sidebar_declaration['name'],
			'description' => $sidebar_declaration['description'],
			'type' => 'sidebar',
			'default' => ($default_choice ? 'default' : $sidebar_id),
			'choices' => $sidebar_choices
		);
		
		// 
		if (strpos($sidebar_id, '-post-') !== false) {
			$args[$prefix.'-'.$sidebar_id]['post_types'] = 'post';
		}
		
		if ('fn-main-sidebar' == $sidebar_id) {
			$choices = array();
			if ($default_choice) {
				$choices = array(
					''  =>  '<img st'.'yle="width:80px" src="'.esc_url(FLATNEWS_THEME_URL_IMAGES.'/sidebar-layout-default.png').'" title="'.  esc_attr__('Default', 'flatnews').'"/>'
				);								
			}

			$choices = array_merge($choices, array(
				'full' => '<img st'.'yle="width:80px" src="'.esc_url(FLATNEWS_THEME_URL_IMAGES.'/sidebar-layout-full.png').'" title="'.esc_html__('Full Width', 'flatnews').'"/>',
				'right' => '<img s'.'tyle="width:80px" src="'.esc_url(FLATNEWS_THEME_URL_IMAGES.'/sidebar-layout-right.png').'" title="'.esc_html__('Right Side', 'flatnews').'"/>',
				'left' => '<img styl'.'e="width:80px" src="'.esc_url(FLATNEWS_THEME_URL_IMAGES.'/sidebar-layout-left.png').'" title="'.esc_html__('Left Side', 'flatnews').'"/>',
			));

			$args[$prefix.'-'.$sidebar_id]['show'] = array(
				array($prefix.'-sidebar-layout', '!=', 'full'),				
			);
			
			$args[$prefix.'-sidebar-layout'] = array(
				'label' => esc_html__('MAIN SIDEBAR Layout', 'flatnews'), 
				'description' => esc_html__('Choose Main Sidebar Layout', 'flatnews'),
				'type' => 'visual', 
				'default' => ($default_choice ? 'default' : 'right'),
				'choices' => $choices
			);
			if (!$default_choice) {
				$args[$prefix.'-sidebar-sticky'] = array(
					'label' => esc_html__('MAIN SIDEBAR sticky', 'flatnews'), 
					'description' => esc_html__('Check This to Enable Sticky Sidebar', 'flatnews'),
					'type' => 'checkbox',
					'default' => 'on',
					'show' => array(
						array('sidebar_layout', '==', 'right'),
						'||',
						array('sidebar_layout', '==', 'left'),
					),
				);
			}
			
		}
	}
	
	
	return $args;
}

$customizer_declaration = array(
	'title_tagline' => array(
		'title'  => esc_html__('General Design', 'flatnews'),
		'icon' => 'admin-site',
		'settings' => array(			
			'main_color' => array(
				'label' => esc_html__('Main Color', 'flatnews'), 
				'type' => 'color', 
				'default' => '#D12F2F',
				'cssout' => 'a,a:hover,.color, .item-top .item-title a:hover, .item-bot .item-title a:hover{color:%s}.border,.sneeit-percent-fill,.sneeit-percent-mask,.fn-bh-text-bg-bot-border .fn-block-title,.fn-bh-bot-border .fn-block-title,.sneeit-articles-pagination-content > a:hover, .sneeit-percent-fill, .sneeit-percent-mask {border-color:%s}.bg,.fn-block .item-mid .item-categories,.fn-bh-text-bg-bot-border .fn-block-title-text,.fn-bh-full-bg .fn-block-title,.fn-block .item-meta .item-categories,.sneeit-articles-pagination-content > a:hover, .fn-block-mega-menu .sneeit-articles-pagination-content > a, .fn-item-hl .item-big .item-bot-content, .fn-item-hl .item-big .item-top, .fn-item-hl .fn-blog .item-bot-content, .fn-item-hl .fn-blog .item-top, .fn-break .item .item-categories, a.scroll-up, input[type="submit"] {background-color: %s}'
			),
			'site_background_color' => array(
				'label' => esc_html__('Site Background Color', 'flatnews'), 
				'type' => 'color', 
				'default' => '#f8f8f8',
				'cssout' => 'body{background-color:%s}'
			),
			'site_background_image' => array(
				'label' => esc_html__('Site Background Image', 'flatnews'), 
				'type' => 'image', 
				'default' => '',
				'cssout' => 'body{background-image:url(%s)}'
			),			
			'site_background_image_attachment' => array(
				'label' => esc_html__('Site Background Image Floating Type', 'flatnews'), 
				'type' => 'select', 
				'default' => 'scroll',
				'cssout' => 'body{background-attachment:%s}',
				'choices'	=>	array(
					'fixed'		=>	esc_html__('Fixed', 'flatnews'),
					'scroll'	=>	esc_html__('Scroll', 'flatnews'),
				)
			),
			'site_text_font' => array(
				'label' => esc_html__('Site Text Font', 'flatnews'), 
				'type' => 'font', 
				'default' => "normal normal 16px Arial",
				'cssout' => 'body{font:%s}'
			),
			'site_text_color' => array(
				'label' => esc_html__('Site Text Color', 'flatnews'),
				'type' => 'color',
				'default' => '#000000',
				'cssout' => 'body{color:%s}'
			),			
			'site_title_text_font' => array(
				'label' => esc_html__('Site Title Text Font', 'flatnews'), 
				'type' => 'font', 
				'default' => 'normal bold 50px Oswald',
				'cssout' => '.fn-site-title a{font:%s}'
			),
			'site_title_text_color' => array(
				'label' => esc_html__('Site Title Text Color', 'flatnews'), 
				'type' => 'color',
				'default' => '#ffffff',
				'cssout' => '.fn-site-title a{color:%s}'
			),
			'block_header_layout' => array(
				'label' => esc_html__('Block and Widget Header Layout', 'flatnews'), 		
				'type' => 'visual',
				'default' => 'text-bg-bot-border',
				'choices' => array(
					'text-bg-bot-border' => wp_kses('<img src="'.esc_attr(FLATNEWS_THEME_URL_IMAGES).'block-header-style-text-bg.png"/>', array(
						'img' => array(
							'src' => array()
						)
					)),
					'full-bg' => wp_kses('<img src="'.esc_attr(FLATNEWS_THEME_URL_IMAGES).'block-header-style-full-bg.png"/>', array(
						'img' => array(
							'src' => array()
						)
					)),
					'bot-border' => wp_kses('<img src="'.esc_attr(FLATNEWS_THEME_URL_IMAGES).'block-header-style-bot-border.png"/>', array(
						'img' => array(
							'src' => array()
						)
					)),
				),
			),
			'block_header_text_color' => array(
				'label' => esc_html__('Block Header Text Color', 'flatnews'), 
				'type' => 'color',
				'default' => '#ffffff',
				'cssout' => '.fn-bh-text-bg-bot-border .fn-block-title-text, .fn-bh-text-bg-bot-border .fn-block-title .fn-block-title-text, .fn-bh-full-bg .fn-block-title-text, .fn-bh-full-bg .fn-block-title a, .fn-bh-full-bg .fn-block-title .fn-block-title-text {color:%s}'
			),
			'block_header_text_font' => array(
				'label' => esc_html__('Block Header Text Font', 'flatnews'), 
				'type' => 'font', 
				'default' => 'normal bold 16px Oswald',
				'cssout' => '.fn-block-title-text, .fn-break h2{font:%s}'
			),
			'block_header_bot_margin' => array(
				'label' => esc_html__('Block Header Margin Bottom', 'flatnews'), 
				'type' => 'range', 
				'default' => 10,
				'max' => 50,
				'cssout' => '.fn-block-title{margin-bottom: %spx}'
			),
			'block_item_title_font_family' => array(
				'label' => esc_html__('Block Item Title Font Family', 'flatnews'), 
				'description' => esc_html__('Font family for title of item in article blocks', 'flatnews'), 
				'type' => 'font-family', 
				'default' => "Oswald",
				'cssout' => '.fn-block .item-title {font-family:%s}'
			),
			'social_counter_font_family' => array(
				'label' => esc_html__('Social Counter Font Family', 'flatnews'), 
				'type' => 'font-family', 
				'default' => "Oswald",
				'cssout' => '.fn-widget-social-counter .social-counter{font-family:%s}'
			),
			'disable_scroll_up' => array(
				'label' => esc_html__('Disable Jump / Scroll Top Button', 'flatnews'), 
				'type' => 'checkbox', 				
			)
		)
	),
	'header' => array(
		'title' => esc_html__('Header', 'flatnews'),
		'icon' => 'welcome-learn-more',
		'sections' => array(
			'header_layout' => array(
				'title' => esc_html__('Header Layout', 'flatnews'),
				'settings' => array(
					'header_main_background_color' => array(
						'title' => esc_html__('Header Main Background Color', 'flatnews'),
						'default' => '#d12e2e',						
						'type' => 'color',
						'cssout' => '.fn-header-row-logo{background-color: %s}'
					),
					'header_wrapper_full_width' => array(
						'title' => esc_html__('Header Wrapper Full Width', 'flatnews'),
						'default' => '',						
						'type' => 'checkbox',						
					),					
					'header_row_inner_full_width' => array(
						'title' => esc_html__('Header Row Inners Full Width', 'flatnews'),
						'default' => '',						
						'type' => 'checkbox',				
					),							
				),
			),
			
			'header_logo' => array(
				'title' => esc_html__('Header Site Logo', 'flatnews'),
				'settings' => array(
					'site_logo' => array(
						'label' => esc_html__('Site Logo Image', 'flatnews'),
						'type' => 'image'
					),
					'site_logo_retina' => array(
						'label' => esc_html__('Site Logo Image for Retina Screens', 'flatnews'),
						'type' => 'image'
					),
					'site_logo_width' => array(
						'label' => esc_html__('Site Logo Width in Pixel', 'flatnews'),				
						'type' => 'number',
						'default' => 210,
						'cssout' => '.fn-site-title img{width:%spx}'
					),
					'site_logo_height' => array(
						'label' => esc_html__('Site Logo Height in Pixel', 'flatnews'),				
						'type' => 'number',
						'default' => 47,
						'cssout' => '.fn-site-title img{height:%spx}.fn-site-title a{line-height:%spx!important}'
					),
					'site_logo_padding' => array(
						'label' => esc_html__('Site Logo Padding in Pixel', 'flatnews'),				
						'type' => 'box-padding-px',
						'default' => '40px 0px 20px 20px',
						'cssout' => '.fn-site-title a{margin:%s}'
					),					
				)
			),
			'header_ads' => array(
				'title' => esc_html__('Header Ads', 'flatnews'),
				'settings' => array(
					'header_ads_code' => array(
						'title' => esc_html__('Header Ads Code', 'flatnews'),
						'type' => 'textarea',						
					),					
					'mobile_header_ads_code' => array(
						'title' => esc_html__('MOBILE Header Ads Code', 'flatnews'),
						'type' => 'textarea',						
					),
					'header_ads_padding' => array(
						'title' => esc_html__('Header Ads Padding', 'flatnews'),
						'description' => esc_html__('Header Ads Padding in Pixel', 'flatnews'),
						'default' => '20px 20px 20px 0px',
						'type' => 'box-padding-px',
						'cssout' => '.fn-header-banner-desktop{margin:%s}'
					),
					
				)
			),
			'header_main_menu' => array(
				'title' => esc_html__('Header Main Menu', 'flatnews'),
				'settings' => array(
					/* Main menu item */
					'main_menu_main_item_font' => array(
						'label' => esc_html__('Main Item Text Font', 'flatnews'), 
						'description' => esc_html__('Main items are top level (level 0) items', 'flatnews'), 
						'type' => 'font', 
						'default' => "normal normal 16px Oswald",
						'cssout' => '.fn-main-menu-wrapper ul.menu > li > a {font:%s}'
					),
					'main_menu_main_item_color' => array(
						'label' => esc_html__('Main Item Text Color ', 'flatnews'), 
						'type' => 'color', 
						'default' => '#000000',
						'cssout' => '.fn-main-menu-wrapper ul.menu > li > a {color:%s}'
					),
					'main_menu_main_item_bg' => array(
						'label' => esc_html__('Main Item Background Color', 'flatnews'), 
						'type' => 'color', 
						'default' => '#f0f0f0',
						'cssout' => '.fn-header-row-main-menu, .fn-main-menu-wrapper {background-color:%s}'
					),
					
					/* for hover effect */
					'main_menu_main_item_hover_color' => array(
						'label' => esc_html__('Main Item Hover Text Color ', 'flatnews'), 
						'type' => 'color', 
						'default' => '#000000',
						'cssout' => '.fn-main-menu-wrapper ul.menu > li:hover > a {color:%s}'
					),
					'main_menu_main_item_hover_bg' => array(
						'label' => esc_html__('Main Item Hover Background Color', 'flatnews'), 
						'type' => 'color', 
						'default' => '#dddddd',
						'cssout' => '.fn-main-menu-wrapper ul.menu > li:hover > a {background-color:%s}'
					),
					
					/* for current selected item s */
					'main_menu_selected_main_item_color' => array(
						'label' => esc_html__('Selected Main Item Text Color ', 'flatnews'), 
						'type' => 'color', 
						'default' => '#D12E2E',
						'cssout' => '.fn-main-menu-wrapper ul.menu > li.current-menu-item > a {color:%s}'
					),
					'main_menu_selected_main_item_bg' => array(
						'label' => esc_html__('Selected Main Item Background Color', 'flatnews'), 
						'type' => 'color', 
						'default' => '#f0f0f0',
						'cssout' => '.fn-main-menu-wrapper ul.menu > li.current-menu-item > a {background-color:%s}'
					),
					
					/* badge items */
					'main_menu_badge_font' => array(
						'label' => esc_html__('Main Item Badge Text Font', 'flatnews'), 						
						'type' => 'font-family', 
						'default' => 'Arial',
						'cssout' => '.fn-main-menu-wrapper .badge {font-family:%s}'
					),
					'main_menu_badge_color' => array(
						'label' => esc_html__('Main Item Badge Text Color ', 'flatnews'), 
						'type' => 'color', 
						'default' => '#ffffff',
						'cssout' => '.fn-main-menu-wrapper .badge {color:%s}'
					),
					'main_menu_badge_bg' => array(
						'label' => esc_html__('Main Item Badge Background Color', 'flatnews'), 
						'type' => 'color', 
						'default' => '#D12E2E',
						'cssout' => '.fn-main-menu-wrapper .badge {background-color:%s}'
					),
					
					/* sub menu */
					'main_menu_sub_item_font' => array(
						'label' => esc_html__('Sub Item Text Font', 'flatnews'), 
						'description' => esc_html__('Sub items are sub level (level 1+) items', 'flatnews'), 
						'type' => 'font-family', 
						'default' => "Arial",
						'cssout' => '.fn-main-menu-wrapper ul.menu li li a {font-family:%s}'
					),
					'main_menu_sub_item_color' => array(
						'label' => esc_html__('Sub Item Text Color ', 'flatnews'), 
						'type' => 'color', 
						'default' => '#ffffff',
						'cssout' => '.fn-main-menu-wrapper ul.menu li li a {color:%s}'
					),
					'main_menu_sub_item_bg' => array(
						'label' => esc_html__('Sub Item Background Color', 'flatnews'), 
						'type' => 'color', 
						'default' => '#333333',
						'cssout' => '.fn-main-menu-wrapper .menu-item-inner, .fn-main-menu-wrapper ul.sub-menu, .fn-main-menu-wrapper li li {background-color:%s}'
					),
					
					/* sub menu hover */					
					'main_menu_sub_item_hover_color' => array(
						'label' => esc_html__('Sub Item Text Hover Color ', 'flatnews'), 
						'type' => 'color', 
						'default' => '#ffffff',
						'cssout' => '.fn-main-menu-wrapper ul.menu li li:hover > a {color:%s}'
					),
					'main_menu_sub_item_hover_bg' => array(
						'label' => esc_html__('Sub Item Background Hover Color', 'flatnews'), 
						'type' => 'color', 
						'default' => '#111111',
						'cssout' => '.fn-main-menu-wrapper ul.menu li li:hover > a, .fn-main-menu-wrapper ul.menu > .menu-item-mega.menu-item-mega-category.menu-item-has-children > .menu-item-inner > .menu-mega-content, .menu-item-mega-category.menu-item-has-children .menu-mega-block, .menu-mega-content, .menu-item-mega-category.menu-item-has-children .menu-item-object-category > a.active, .menu-item-mega-category.menu-item-has-children .menu-mega-block-bg {background-color:%s}'
					),					
				)
			),
			'header_main_menu_sticky' => array(
				'title' => esc_html__('Header Main Menu Sticky', 'flatnews'),
				'settings' => array(
					/* Sticky Menu*/
					'sticky_menu' => array(
						'label' => esc_html__('Sticky Menu', 'flatnews'),
						'description' => esc_html__('Choose Sticky Menu Mode', 'flatnews'),
						'type' => 'select', 
						'default' => 'up',
						'choices' => array( 
							'disable' => 'Disable',
							'up' => 'Up',
							'down' => 'Down',
							'always' => 'Always'
						)
					),
					'sticky_menu_logo' => array(
						'label' => esc_html__('Sticky Menu Logo', 'flatnews'),
						'description' => esc_html__('Choose Image Logo to Show in Sticky Menu Mode. Max height 32px', 'flatnews'),
						'type' => 'image',
						'show' => array(
							array('sticky_menu', '!=', 'disable')
						),
					),
					'sticky_menu_logo_retina' => array(
						'label' => esc_html__('Sticky Menu Logo for Retina Screens', 'flatnews'),
						'description' => esc_html__('Choose Image Logo to Show in Sticky Menu Mode for Retna Screens. Max height 32px', 'flatnews'),
						'type' => 'image',
						'show' => array(
							array('sticky_menu', '!=', 'disable')
						),
					),
					'sticky_menu_logo_width' => array(
						'label' => esc_html__('Sticky Menu Logo Width', 'flatnews'),						
						'type' => 'range',
						'default' => 150,
						'max' => get_theme_mod('header_wrapper_specific_width', 1130),
						'show' => array(
							array('sticky_menu', '!=', 'disable')
						),
						'cssout' => '#fn-main-menu .main-menu-sticky-menu-logo img {width: %spx}',
					),
					'sticky_menu_logo_height' => array(
						'label' => esc_html__('Sticky Menu Logo Height', 'flatnews'),						
						'type' => 'range',
						'default' => 30,
						'max' => get_theme_mod('header_wrapper_specific_width', 1130),
						'show' => array(
							array('sticky_menu', '!=', 'disable')
						),
						'cssout' => '#fn-main-menu .main-menu-sticky-menu-logo img {height: %spx}',
					),
					'sticky_menu_logo_padding' => array(
						'label' => esc_html__('Sticky Menu Logo Height', 'flatnews'),						
						'type' => 'box-padding-px',
						'default' => '10px 20px 10px 20px',
						'show' => array(
							array('sticky_menu', '!=', 'disable')
						),
						'cssout' => '#fn-main-menu .main-menu-sticky-menu-logo {padding: %s}',
					),
				)
			),
			
			'header_break_news' => array(
				'title' => esc_html__('Header Break News', 'flatnews'),
				'settings' => array(
					'break_disable' => array(
						'label' => esc_html__('Disable Break News', 'flatnews'),
						'type' => 'checkbox',
					),
					'break_cates' => array(
						'label' => esc_html__('Break News Categories', 'flatnews'),
						'description' => esc_html__('Leave this blank to display recent posts', 'flatnews'),
						'type' => 'categories', 												
						'show' => array(
							array('break_disable', '==', ''), 
						)
					),
					'break_count' => array(
						'label' => esc_html__('Break News Post Count', 'flatnews'),
						'description' => esc_html__('Number of posts to load', 'flatnews'),
						'type' => 'range', 												
						'min' => 1, 
						'max' => 20,
						'default' => 5,
						'show' => array(
							array('break_disable', '==', ''), 
						)
					),
					'break_text' => array(
						'label' => esc_html__('Break News Text', 'flatnews'),
						'default' => 'BREAK NEWS',
						'show' => array(
							array('break_disable', '==', ''), 
						)
					),
					'break_icon' => array(
						'label' => esc_html__('Break News Icon', 'flatnews'),
						'description' => wp_kses(
							sprintf(__('Example: fa-home. <a href="%s" target="_blank">Check Full List of Icon Codes Here</a>', 'flatnews'), esc_url('https://fortawesome.github.io/Font-Awesome/icons/')),
							array(
								'a' => array(
									'href' => array(),
									'target' => array()
								),					
							)
						),
						'default' => 'fa-flash',
						'show' => array(
							array('break_disable', '==', ''), 
						)
					),
					'break_show' => array(
						'label' => esc_html__('Break News Show Rules', 'flatnews'),
						'description' => esc_html__('Select places where break news need to show', 'flatnews'),
						'type' => 'selects', 
						'default' => 'home',
						'choices' => array(
							'all' => esc_html__('All', 'flatnews'),
							'home' => esc_html__('Home', 'flatnews'),
							'archive' => esc_html__('Archives', 'flatnews'),
							'article' => esc_html__('Articles', 'flatnews'),
							'page' => esc_html__('Pages', 'flatnews'),							
						)
					)
				)
			),
			'header_misc' => array(
				'title' => esc_html__('Header Misc Elements', 'flatnews'),
				'settings' => array(
					'social_links' => array(
						'title' => esc_html__('Social Links', 'flatnews'),
						'description' => esc_html__('One link per line. If a link can not display, that\'s mean the icon pack does not support that network. Leave this blank to hide.', 'flatnews'),
						'type' => 'textarea',
						
					),
					'disable_header_search' => array(
						'title' => esc_html__('Disable Header Search', 'flatnews'),
						'type' => 'checkbox', 						
					),					
				)
			),
		),
	),
	'primary' => array(
		'title' => esc_html__('Primary Area', 'flatnews'),
		'description' => esc_html__('Primary area contains main column and sidebar', 'flatnews'),
		'icon' => 'fa-square ',
		'settings' => array(
			'primary_area_background_color' => array(
				'label' => esc_html__('Primary Area Background Color', 'flatnews'), 
				'type' => 'color', 
				'default' => '#ffffff',
				'cssout' => '.fn-primary,.fn-block.fn-item-title-underover .item-bot-content{background-color:%s}'
			),
			'content_width' => array(
				'label' => esc_html__('Content Width', 'flatnews'),
				'description' => esc_html__('Width of content area in pixels', 'flatnews'),
				'default' => 730,
				'max' => 2400,	
				'min' => 300,
				'type' => 'range',
				/*'cssout' => '.fn-content{width:%spx}',*/
			),
			'sidebar_width' => array(
				'label' => esc_html__('Sidebar Width', 'flatnews'),
				'description' => esc_html__('Width of main sidebar area in pixels', 'flatnews'),
				'default' => 300,
				'max' => 1600,	
				'min' => 80,
				'type' => 'range',
				/*'cssout' => '.fn-main-sidebar{width:%spx}',*/
			),
			'content_sidebar_gap' => array(
				'label' => esc_html__('Content and Sidebar Gap', 'flatnews'),
				'description' => esc_html__('Space Between Content and Sidebar', 'flatnews'),
				'default' => 40,
				'max' => 100,	
				'min' => 10,
				'step' => 10,
				'type' => 'range',				
			),
			'primary_padding' => array(
				'label' => esc_html__('Primary Area Padding', 'flatnews'),
				'description' => esc_html__('Padding of primary area in pixels', 'flatnews'),
				'default' => '0px 30px 30px 30px',
				'type' => 'box-padding-px',
				'cssout' => '.fn-primary{padding:%s}',
			),	
		)
	),
	
	/* SIDEBAR MANAGER */
	'sidebar' => array(
		'title' => esc_html__('Sidebar Manager', 'flatnews'),
		'icon' => 'dashicons-align-right',
		'sections' => array(
			'general-sidebar-settings' => array(
				'title' => esc_html__( 'General Sidebar Settings', 'flatnews' ),
				'settings' => array(
					'sticky_sidebar_delay'  => array(
						'label' => esc_html__('Sticky Sidebar Delay', 'flatnews'), 
						'description' => esc_html__('If you set to ZERO, all sticky sidebars will sticky instantly without animation', 'flatnews'),
						'type' => 'range',
						'default' => 0, 
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					),
				),
			), /*HOME sidebar*/
			
			'home-sidebar-manager' => array(
				'title' => esc_html__( 'Home / Front Page Sidebar', 'flatnews' ),
				'settings' => fn_customizer_sidebar_settings('home'),
			), /*HOME sidebar*/
			
			'single-sidebar-manager' => array(
				'title' => esc_html__( 'Article / Post Sidebar', 'flatnews' ),
				'settings' => fn_customizer_sidebar_settings('single'),
			), /* ARTICLE sidebar */
						
			'page-sidebar-manager' => array(
				'title' => esc_html__( 'Static Page Sidebar', 'flatnews' ),
				'settings' => fn_customizer_sidebar_settings('page'),
			), /*STATIC PAGE sidebar*/
			
			'archive-sidebar-manager' => array(
				'title' => esc_html__( 'Archive Page Sidebar', 'flatnews' ),
				'settings' => fn_customizer_sidebar_settings('archive'),
			), /* ARCHIVE sidebar*/	
			
			'shop-sidebar-manager' => array(
				'title' => esc_html__( 'Shop Page Sidebar', 'flatnews' ),
				'settings' => fn_customizer_sidebar_settings('shop'),
			), /* ARCHIVE sidebar*/			
			'product-sidebar-manager' => array(
				'title' => esc_html__( 'Product Page Sidebar', 'flatnews' ),
				'settings' => fn_customizer_sidebar_settings('product'),
			), /* ARCHIVE sidebar*/			
			'archive-product-sidebar-manager' => array(
				'title' => esc_html__( 'Archive Products Page Sidebar', 'flatnews' ),
				'settings' => fn_customizer_sidebar_settings('archive-product'),
			), /* ARCHIVE sidebar*/			
		),
		
	),
	'post_content' => array(
		'title' => esc_html__('Article - Post', 'flatnews'), 
		'icon' => 'dashicons-welcome-write-blog',
		'settings' => array(			
			'article_title_font' => array(
				'label' => esc_html__('Article Title Font', 'flatnews'), 
				'default' => 'normal normal 36px Oswald',
				'type' => 'font', 
				'cssout' => 'h1.entry-title.post-title{font:%s}',				
			),
			'article-breadcrumb' => array(
				'label' => esc_html__('Article Breadcrumb', 'flatnews'), 
				'description' => esc_html__('Show / Hide article breadcrumb', 'flatnews'), 
				'type' => 'select', 
				'default' => 'on',
				'choices' => array(
					'on'  => esc_html__('Show', 'flatnews'), 
					''  => esc_html__('Hide', 'flatnews'), 					
				)
			),
			'article-feature' => array(
				'label' => esc_html__('Feature Box Position', 'flatnews'), 
				'description' => esc_html__('Choose position for feature box or disable it', 'flatnews'), 
				'type' => 'select', 
				'default' => 'above-title',
				'choices' => array( 
					'' => esc_html__('Disable', 'flatnews'),
					'above-title' => esc_html__('Above Post Title', 'flatnews'),
					'under-title' => esc_html__('Under Post Title', 'flatnews'),					
				)
			),

			'article-excerpt' => array(
				'label' => esc_html__('Article Excerpt', 'flatnews'), 
				'description' => esc_html__('Show / hide article excerpt', 'flatnews'), 
				'type' => 'select', 
				'default' => 'on', 
				'choices' => array(
					'on'  => esc_html__('Show', 'flatnews'), 
					''  => esc_html__('Hide', 'flatnews'), 					
				)
			),

			'article-author' => array(
				'label' => esc_html__('Article Author Meta', 'flatnews'), 
				'description' => esc_html__('Show / hide author name under post title', 'flatnews'),
				'type' => 'select', 
				'default' => 'icon',
				'choices' => array(
					'' => esc_html__('Not show', 'flatnews'), 
					'name' => esc_html__('Show name only', 'flatnews'), 
					'icon' => esc_html__('Show name with icon', 'flatnews'), 
					'avatar' => esc_html__('Show name with avatar', 'flatnews')
				),
			),
			'article-date-time' => array(
				'label' => esc_html__('Article Date Time Meta', 'flatnews'), 
				'description' => esc_html__('Show / hide date / time of articles', 'flatnews'),
				'type' => 'select', 
				'default' => 'full',
				'choices' => array(
					'' => esc_html__('Not Show', 'flatnews'), 
					'full' => esc_html__('Publised - Date Time', 'flatnews'), 
					'date' => esc_html__('Publised - Only Date', 'flatnews'), 
					'time' => esc_html__('Publised - Only Time', 'flatnews'), 
					'short' => esc_html__('Publised - Short Date Time', 'flatnews'), 
					'pretty' => esc_html__('Publised - Pretty Date Time', 'flatnews'),					
					'updated-full' => esc_html__('Updated - Date and Time', 'flatnews'), 
					'updated-date' => esc_html__('Updated - Only Date', 'flatnews'), 
					'updated-time' => esc_html__('Updated - Only Time', 'flatnews'), 
					'updated-short' => esc_html__('Updated - Short Date Time', 'flatnews'), 
					'updated-pretty' => esc_html__('Updated - Pretty Date Time', 'flatnews')
				)
			),
			'article-comments-number' => array(
				'label' => esc_html__('Article Comment Number', 'flatnews'), 
				'description' => esc_html__('Show / hide comment Number', 'flatnews'),
				'type' => 'select', 
				'default' => 'on',
				'choices' => array(
					'' => esc_html__('Hide', 'flatnews'), 
					'on' => esc_html__('Show', 'flatnews'), 					
				),
			),

			'article-sharing-position' => array(
				'label' => esc_html__('Article Sharing Button Position', 'flatnews'), 
				'description' => esc_html__('Position for sharing buttons', 'flatnews'), 
				'type' => 'select', 
				'default' => '-top-bottom', 
				'choices' => array(
					''  => esc_html__('Hide', 'flatnews'),
					'top'  => esc_html__('Top', 'flatnews'), 
					'bottom'  => esc_html__('Bottom', 'flatnews'), 
					'-top-bottom'  => esc_html__('Both', 'flatnews'), 
				)
			),
			'article-sharing-buttons' => array(
				'label' => esc_html__('Article Sharing Buttons', 'flatnews'), 
				'description' => esc_html__('Pick sharing button you want', 'flatnews'), 
				'type' => 'selects', 
				'default' => 'facebook,twitter,g+', 
				'choices' => array(
					'facebook'  => esc_html__('Facebook', 'flatnews'),
					'twitter'  => esc_html__('Twitter', 'flatnews'), 
					'mail'  => esc_html__('E-mail', 'flatnews'), 
					'pin'  => esc_html__('Pinterest', 'flatnews'), 
					'whatsapp'  => esc_html__('Whatsapp', 'flatnews'), 
					'linkedin'  => esc_html__('Linkedin', 'flatnews'), 
					'skype'  => esc_html__('Skype', 'flatnews'), 
					'g+'  => esc_html__('Google Plus', 'flatnews'),
				),
				'show' => array(			
					array('article-sharing-position', '!=', '')
				)
			),
			'article-sharing-custom-code' => array(
				'label' => esc_html__('Custom Sharing Button Code', 'flatnews'), 
				'description' => esc_html__('Use this custom sharing button code instead of default. Leave blank to use default sharing buttons.', 'flatnews'), 
				'type' => 'textarea',
				'show' => array(					
					array('article-sharing-position', '!=', '')
				)
			),
			'article-categories' => array(
				'label' => esc_html__('Categories', 'flatnews'), 
				'description' => esc_html__('Show / hide article categories', 'flatnews'),
				'type' => 'select', 
				'default' => 'on',
				'choices' => array(
					'' => esc_html__('Hide', 'flatnews'), 
					'on' => esc_html__('Show', 'flatnews'), 					
				),
			),
			'article-tags' => array(
				'label' => esc_html__('Tags', 'flatnews'), 
				'description' => esc_html__('Show / hide article tags', 'flatnews'),
				'type' => 'select', 
				'default' => 'on',
				'choices' => array(
					'' => esc_html__('Hide', 'flatnews'), 
					'on' => esc_html__('Show', 'flatnews'), 					
				),
			),
			'article-author-box' => array(
				'label' => esc_html__('Author Box', 'flatnews'), 
				'description' => esc_html__('Show / hide author box', 'flatnews'),
				'type' => 'select', 
				'default' => 'on',
				'choices' => array(
					'' => esc_html__('Hide', 'flatnews'), 
					'on' => esc_html__('Show', 'flatnews'), 					
				),
			),
			'article-nextprev' => array(
				'label' => esc_html__('Next / Prev Navigation Buttons', 'flatnews'), 
				'description' => esc_html__('Show / hide newer / older post pager', 'flatnews'),
				'type' => 'select', 
				'default' => 'on',
				'choices' => array(
					'' => esc_html__('Hide', 'flatnews'), 
					'on' => esc_html__('Show', 'flatnews'),	
				),
			)
		)		
	), /* POST CONTENT */
	'comment' => array(
		'title' => esc_html__('Comment Systems', 'flatnews'),
		'icon' => 'dashicons-admin-comments',
		'settings' => array(
			'primary_comment_system' => array(
				'label' => esc_html__('Primary Comment System', 'flatnews'), 
				'description' => esc_html__('Set primary for a comment system to priority showing that system first', 'flatnews'), 
				'type' => 'select', 
				'default' => 'wordpress',
				'choices' => array( 
					'wordpress' => 'WordPress',
					'facebook' => 'Facebook',
					'disqus' => 'Disqus'
				)
			),
			'disable_wordpress_comment' => array(
				'label' => esc_html__('Disable WordPress Comment', 'flatnews'), 
				'description' => esc_html__('Now show WordPress comment system on all pages', 'flatnews'), 
				'type' => 'checkbox', 
				'default' => false
			),
			'disable_facebook_comment' => array(
				'label' => esc_html__('Disable Facebook Comment', 'flatnews'), 
				'description' => esc_html__('Now show Facebook comment system on all pages', 'flatnews'), 
				'type' => 'checkbox', 
				'default' => false
			),
			'disable_disqus_comment' => array(
				'label' => esc_html__('Disable Disqus Comment', 'flatnews'), 
				'description' => esc_html__('Now show Disqus comment system on all pages', 'flatnews'), 
				'type' => 'checkbox', 
				'default' => false
			),
			
			'facebook_comment_app_id' => array(
				'label' => esc_html__('Facebook APP ID for Comment System', 'flatnews'), 
				'description' => esc_html__('You must use your own APP ID to moderate comments.', 'flatnews'), 
				'type' => 'number', 
				'default' => '403849583055028'
			),
			'disqus_short_name' => array(
				'label' => esc_html__('Disqus Short Name', 'flatnews'), 
				'description' => esc_html__('Use must use your own Disqus Short Name to moderate comments.', 'flatnews'), 
				'default' => 'flatnewstemplate'
			),
			'disable_wordpress_comment_url' => array(
				'label' => esc_html__('Disable WordPress Comment URL', 'flatnews'), 
				'description' => esc_html__('Not show the comment URL in comment field', 'flatnews'), 
				'type' => 'checkbox', 
				'default' => false
			),			
			'disable_wordpress_comment_media' => array(
				'label' => esc_html__('Disable WordPress Comment Media', 'flatnews'), 
				'description' => esc_html__('Not auto convert image URL to real image HTML tag', 'flatnews'), 
				'type' => 'checkbox', 
				'default' => false
			),			
		)
	),
	'archive' => array(
		'title' => esc_html__('Archive Page Designs', 'flatnews'),
		'icon' => 'dashicons-admin-page',
		'description' => esc_html__('Configure Archive Page Designs (Index, Category, Search, Author, ...)', 'flatnews'), 
		'settings' => $fn_archive_fiels
	),
	'footer' => array(
		'title' => esc_html__('Footer', 'flatnews'),
		'icon' => 'fa-paw',
		'description' => esc_html__('Configure settings for site footer', 'flatnews'), 
		'settings' => array(
			'footer_wrapper_full_width' => array(
				'title' => esc_html__('Footer Wrapper Full Width', 'flatnews'),
				'default' => '',						
				'type' => 'checkbox',						
			),			
			'footer_row_inner_full_width' => array(
				'title' => esc_html__('Footer Row Inners Full Width', 'flatnews'),
				'default' => '',						
				'type' => 'checkbox',				
			),
			'footer_logo_image' => array(
				'title' => esc_html__('Footer Logo Image', 'flatnews'),											
				'type' => 'image',
			),
			'footer_social_links' => array(
				'title' => esc_html__('Footer Social Links', 'flatnews'),
				'description' => esc_html__('One link per line. If a link can not display, that\'s mean the icon pack does not support that network. Leave this blank to hide.', 'flatnews'),
				'type' => 'textarea',

			),
			'footer_message' => array(
				'title' => esc_html__('Footer Message', 'flatnews'), 
				'type' => 'content', 
			),			
			'footer_search_replacer' => array(
				'title' => esc_html__('Replace Search Form by Custom Code', 'flatnews'), 
				'description' => esc_html__('Leave this blank to show the footer search form', 'flatnews'), 
				'type' => 'textarea',				
			),
			'footer_search_title' => array(
				'title' => esc_html__('Footer Search Title', 'flatnews'), 
				'default' => 'SEARCH SOMETHING',
				'show' => array(
					array('footer_search_replacer', '==', ''), 
				)
			),
			
			'footer_copyright_text' => array(
				'label' => esc_html__('Footer Copyright Text', 'flatnews'),
				'default' => ('&copy; '.date('Y').' ' . get_bloginfo('blogname') . '. All rights reserved. Designed by <a href="htt'.'ps://themeforest.n'.'et/item/flat-news-responsive-magazine-wordpress-theme/6000513">FlatNews</a>')
			),
		),		
	),
	'custom_code' => array(
		'title' => esc_html__('Custom Code', 'flatnews'),
		'icon' => 'dashicons-editor-code',
		'description' => esc_html__('Add your custom HTML / JAVASCRIPT / CSS code', 'flatnews'), 
		'settings' => array(
			'head_html' => array(
				'label' => esc_html__('HTML in Head', 'flatnews'),
				'description' => esc_html__('Insert your HTML code before "head" tag', 'flatnews'),
				'type' => 'textarea'
			),
			'head_js' => array(
				'label' => esc_html__('JavaScript in Head', 'flatnews'),
				'description' => esc_html__("Insert your JavaScript code before 'head' tag. Don't add 'javascript' tag in code, the tag will be generate automatically", 'flatnews'),
				'type' => 'textarea'
			),
			'head_css' => array(
				'label' => esc_html__('Style CSS in Head', 'flatnews'),
				'description' => esc_html__("Insert your CSS code before 'head' tag. Don't add 'style' tag in code, the tag will be generate automatically", 'flatnews'),
				'type' => 'textarea'
			),
			'footer_html' => array(
				'label' => esc_html__('HTML in Footer', 'flatnews'),
				'description' => esc_html__('Insert your HTML code before close of "body" tag', 'flatnews'),
				'type' => 'textarea'
			),
			'footer_js' => array(
				'label' => esc_html__('JavaScript code in Footer', 'flatnews'),
				'description' => esc_html__("Insert your JavaScript code before close of 'body' tag. Don't add 'javascript' tag in code, the tag will be generate automatically", 'flatnews'),
				'type' => 'textarea'
			),
			'footer_css' => array(
				'label' => esc_html__('Style CSS code in Footer', 'flatnews'),
				'description' => esc_html__("Insert your CSS code before close of 'body' tag. Don't add 'style' tag in code, the tag will be generate automatically", 'flatnews'),
				'type' => 'textarea'
			),
		)
	),		
	'responsive' => array(
		'title' => esc_html__('Responsive', 'flatnews'),
		'icon' => 'fa-mobile',		
		'settings' => array(
			'disable_responsive'  => array(
				'label' => esc_html__('Disable Responsive', 'flatnews'), 
				'description' => esc_html__('Disable responsive style', 'flatnews'), 
				'type' => 'checkbox', 
				'default' => false,							
			),									 
			'mobile_site_logo' => array(
				'label' => esc_html__('MOBILE Site Logo Image', 'flatnews'),
				'type' => 'image',
				'show' => array(
					array('disable_responsive', '==', false),
				),
			),
			'mobile_site_logo_retina' => array(
				'label' => esc_html__('MOBILE Site Logo Image for Retina Screens', 'flatnews'),
				'type' => 'image',
				'show' => array(
					array('disable_responsive', '==', false),
				),
			),
			'mobile_site_logo_width' => array(
				'label' => esc_html__('MOBILE Site Logo Width in Pixel', 'flatnews'),
				'type' => 'number',
				'default' => 150,
				'cssout' => '.fn-mob-logo img {width: %spx}',
				'show' => array(
					array('disable_responsive', '==', false),
				),
			),
			'mobile_site_logo_height' => array(
				'label' => esc_html__('MOBILE Site Logo Height in Pixel for MOBILE', 'flatnews'),
				'type' => 'number',
				'default' => 30,
				'cssout' => '.fn-mob-logo img {height: %spx}',
				'show' => array(
					array('disable_responsive', '==', false),
				),
			),
			'mobile_header_bg'  =>  array(
				'label' => esc_html__('MOBILE Header Background Color', 'flatnews'),
				'type' => 'color',
				'default' => '#333333',
				'cssout' => '.fn-mob-header {background: %s}',
				'show' => array(
					array('disable_responsive', '==', false),
				),
			),
			'mobile_header_color'  =>  array(
				'label' => esc_html__('MOBILE Header Text Color', 'flatnews'),
				'type' => 'color',
				'default' => '#ffffff',
				'cssout' => '.fn-mob-header a {color: %s}',
				'show' => array(
					array('disable_responsive', '==', false),
				),
			),
			/* Sticky Menu*/
			'mobile_header_sticky' => array(
				'label' => esc_html__('MOBILE Header Sticky', 'flatnews'),
				'description' => esc_html__('Enable / Disable sticky / floating mode for the mobile header', 'flatnews'),
				'type' => 'select', 
				'default' => 'up',
				'choices' => array( 
					'disable' => 'Disable',
					'up' => 'Up',
					'down' => 'Down',
					'always' => 'Always'
				),
				'show' => array(
					array('disable_responsive', '==', false),
				),
			),
		)
	),
	/*
	'site_performance' => array(
		'title' => esc_html__('Site Performance', 'flatnews'),
		'icon' => 'dashicons-clock',
		'description' => esc_html__('Increase your site performance', 'flatnews'), 
		'settings' => array(
			'serve-scaled-images' => array(
				'label' => esc_html__('Serve Scaled Images', 'flatnews'), 
				'description' => wp_kses(__('Use smaller image size for faster speed, but a bit blur. You will need to use <a href="https://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails Plugin</a> to generate more image versions, may be, your hosting will be out of resource.', 'flatnews'), array(
					'a' => array(
						'href'=>array(),
						'target'=>array(),
					)
				)), 
				'type' => 'checkbox', 
				'default' => false
			),
			'remove-query-strings' => array(
				'label' => esc_html__('Remove Query Strings From Static Resources', 'flatnews'), 
				'description' => esc_html__('Remove version queries in JavaScript and CSS resource, but when updating theme, the update will come to readers late a bit because their browser caches.', 'flatnews'),
				'type' => 'checkbox', 
				'default' => false
			),
			'minify-css-js' => array(
				'label' => esc_html__('Minify CSS and JavaScript', 'flatnews'), 
				'description' => esc_html__('Use compressed version of CSS and JavaScript for loading faster.', 'flatnews'),
				'type' => 'checkbox', 
				'default' => false
			),
		)
	),
	*/
	
); /* end $customizer_declaration */

if ( !function_exists( 'is_woocommerce' ) ) {
	unset($customizer_declaration['sidebar']['sections']['shop-sidebar-manager']);
	unset($customizer_declaration['sidebar']['sections']['product-sidebar-manager']);
	unset($customizer_declaration['sidebar']['sections']['archive-product-sidebar-manager']);
}

do_action('sneeit_setup_customizer', $customizer_declaration);
$sneeit_theme_options = array(
	'menu-title' => esc_html__('Theme Options', 'flatnews'), 
	'page-title' => esc_html__('Theme Options', 'flatnews'),
	'html-before' => '',
	'html-after' => '',
	'declarations' => $customizer_declaration,
);
do_action('sneeit_theme_options', $sneeit_theme_options);

