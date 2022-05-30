<?php
global $FlatNews_Article_Fields;
global $FNAB_Fields;

$FlatNews_Shortcodes = array(
	'title' => esc_html__('FlatNews Shortcodes', 'flatnews'), 
	'icon' => 'fa-flash',
	'script' => 'flatnews-main',
	'declarations' => array(		
		/**
		 * Article shortcodes
		 */
		'slides' => array(
			'title' => esc_html__('Slider', 'flatnews'), 
			'icon' => 'fa fa-archive', 
			'display_callback' => 'flatnews_shortcode_slider_display',
			'fields'  => $FNAB_Fields['slider'],
			'tooltip' => esc_attr(FLATNEWS_THEME_URL_IMAGES).'sc-tt-slider.png'
		),				
		'carousel' => array(
			'title' => esc_html__('Carousel', 'flatnews'), 
			'icon' => 'fa fa-forward', 		
			'display_callback' => 'flatnews_shortcode_carousel_display', 
			'fields' => $FNAB_Fields['carousel']
		),
		'grid' => array(
			'title' => esc_html__('Grid', 'flatnews'), 
			'icon' => 'fa fa-th-large',	
			'display_callback' => 'flatnews_shortcode_grid_display', 
			'fields' => $FNAB_Fields['grid']
		),
		'blog' => array(
			'title' => esc_html__('Blogging', 'flatnews'), 
			'icon' => 'fa fa-th-list', 		
			'display_callback' => 'flatnews_shortcode_blog_display', 
			'fields' => $FNAB_Fields['blog']
		),
		'sticky' => array(
			'title' => esc_html__('Sticky', 'flatnews'), 
			'icon' => 'fa fa-sticky-note',	
			'display_callback' => 'flatnews_shortcode_sticky_display', 
			'fields' => $FNAB_Fields['sticky']
		),
		'flex' => array(
			'title' => esc_html__('Flex', 'flatnews'), 
			'icon' => 'fa fa-qrcode',	
			'display_callback' => 'flatnews_shortcode_flex_display', 
			'fields' => $FNAB_Fields['flex']
		),

		/**
		 * Non-article shortcodes
		 */
		'sidebar' => array(
			'display_callback' => 'flatnews_shortcode_sidebar_display',
			'icon' => 'fa fa-indent',
			'fields' => array(
				'id' => array(
					'label' => esc_html__('Select Sidebar', 'flatnews'), 
					'type' => 'sidebar', 
					'default' => 'sidebar'
				)
			)
		),
		
		// content shortcodes
		'dropcap' => array(
			'title' => esc_html__('Dropcap', 'flatnews'), 
			'display_callback' => 'flatnews_shortcode_dropcap_display',		
			'icon' => 'fa-adn'
		),
		'btn' => array(
			'title' => esc_html__('Button', 'flatnews'), 
			'display_callback' => 'flatnews_shortcode_button_display',
			'icon' => 'fa-square',
			'fields' => array(
				'url' => array(
					'label' => esc_html__('Button Link', 'flatnews'), 
					'type' => 'url', 
					'default' => ''
				),
				'text' => array(
					'label' => esc_html__('Button text', 'flatnews'), 
					'type' => 'content',
				),
				'text_color' => array(
					'label' => esc_html__('Text Color', 'flatnews'), 
					'type' => 'color', 
					'default' => '#000000'
				),
				'bg_color' => array(
					'label' => esc_html__('Background Color', 'flatnews'), 
					'type' => 'color', 
					'default' => '#ffffff'
				),
				'icon' => array(
					'label' => esc_html__('Button Icon', 'flatnews'), 				
					'description' => wp_kses(
						sprintf(__('Example: fa-home. <a href="%s" target="_blank">Check Full List of Icon Codes Here</a>', 'flatnews'), esc_url('https://fortawesome.github.io/Font-Awesome/icons/')),
						array(
							'a' => array(
								'href' => array(),
								'target' => array()
							)
						)
					)
				),
				'icon_position' => array(
					'label' => esc_html__('Button Icon Postion', 'flatnews'), 				
					'type' => 'select', 
					'default' => 'start',
					'choices' => array(
						'start' => esc_html__('At start of button', 'flatnews'),
						'end' => esc_html__('At end of button', 'flatnews'),
					)
				),
				'size' => array(
					'label' => esc_html__('Button Size', 'flatnews'),
					'type' => 'select', 
					'default' => '14',
					'choices' => array(
						'8' => esc_html__('Smallest', 'flatnews'),
						'10' => esc_html__('Small', 'flatnews'),
						'14' => esc_html__('Normal', 'flatnews'),
						'18' => esc_html__('Large', 'flatnews'),
						'24' => esc_html__('Largest', 'flatnews'),
					)
				),
				'id' => array(
					'label' => esc_html__('Button ID', 'flatnews')
				),
				'target' => array(
					'label' => esc_html__('Open in New Window', 'flatnews'),
					'type' => 'checkbox', 
					'default' => false
				),
			)
		),
		'message' => array(
			'title' => esc_html__('Message Box', 'flatnews'), 
			'display_callback' => 'flatnews_shortcode_message_display',
			'icon' => 'fa-bullhorn',
			'fields' => array(
				'title' => array(
					'label' => esc_html__('Title', 'flatnews'), 
				),
				'title_color' => array(
					'label' => esc_html__('Title Color', 'flatnews'), 
					'type' => 'color', 
					'default' => '#000000'
				),
				'title_bg' => array(
					'label' => esc_html__('Title Background Color', 'flatnews'), 
					'type' => 'color', 
					'default' => '#dddddd'
				),
				'title_icon' => array(
					'label' => esc_html__('Title Icon', 'flatnews'), 				
					'description' => wp_kses(
						sprintf(__('Example: fa-home. <a href="%s" target="_blank">Check Full List of Icon Codes Here</a>', 'flatnews'), esc_url('https://fortawesome.github.io/Font-Awesome/icons/')),
						array(
							'a' => array(
								'href' => array(),
								'target' => array()
							)
						)
					)
				),
				'message_content' => array(
					'label' => esc_html__('Content', 'flatnews'), 
					'type' => 'content',
				),
				'content_color' => array(
					'label' => esc_html__('Content Color', 'flatnews'), 
					'type' => 'color', 
					'default' => '#000000'
				),
				'content_bg' => array(
					'label' => esc_html__('Content Background Color', 'flatnews'), 
					'type' => 'color', 
					'default' => '#ffffff'
				),			
				'id' => array(
					'label' => esc_html__('Message Box ID', 'flatnews')
				)
			)
		),
		'tabs' => array(
			'title' => esc_html__('Tabs', 'flatnews'), 
			'display_callback' => 'flatnews_shortcode_tabs_display',
			'icon' => 'fa fa-ellipsis-h',
			'fields' => array(				
				'id' => array(
					'label' => esc_html__('ID of the whole tab box', 'flatnews')
				),
				'style' => array(
					'label' => esc_html__('Tab Design Style', 'flatnews'),
					'type' => 'select', 
					'choices' => array(
						'' => esc_html__('Horizontal', 'flatnews'),
						'v' => esc_html__('Verizontal', 'flatnews'),
					),
				),
			),
			'nested' => array(
				'tab' => array(
					'title' => esc_html__('Tab', 'flatnews'),
					'display_callback'  => 'flatnews_shortcode_tab_display',
					'fields' => array(
						'title' => array(
							'title' => esc_html__('Tab Title', 'flatnews'),
						),
						'tab_content' => array(
							'title' => esc_html__('Tab Content', 'flatnews'),
							'type' => 'content'
						)
					)
				)
			)
		),
		'accordions' => array(
			'title' => esc_html__('Accordions', 'flatnews'), 
			'display_callback' => 'flatnews_shortcode_accordions_display',
			'icon' => 'fa fa-list',
			'fields' => array(
				'id' => array(
					'label' => esc_html__('ID of the whole accordion box', 'flatnews')
				),
				'multiple_open' => array(
					'label' => esc_html__('Allow open multiple panels', 'flatnews'),
					'type' => 'checkbox',
					'default'  => false
				),
				'close_all' => array(
					'label' => esc_html__('Close all accordions at beginning', 'flatnews'),
					'type' => 'checkbox',
					'default'  => false
				)
			),
			'nested' => array(
				'accordion' => array(
					'title' => esc_html__('Accordion', 'flatnews'),
					'display_callback' => 'flatnews_shortcode_accordion_display',
					'fields' => array(
						'title' => array(
							'title' => esc_html__('Accordion Title', 'flatnews'),
						),
						'accordion_content' => array(
							'title' => esc_html__('Accordion Content', 'flatnews'),
							'type' => 'content'
						)
					)
				),				
			)
		),
		'lock' => array(
			'title' => esc_html__('Lock Content', 'flatnews'), 
			'display_callback' => 'flatnews_shortcode_lock_display',
			'icon' => 'fa fa-lock',
			'fields' => array(				
				'content' => array(
					'title' => esc_html__('Your Lock Content', 'flatnews'),
					'type' => 'content'
				),
			),
		),
		'text' => array(
			'title' => esc_html__('Text Content', 'flatnews'), 
			'display_callback' => 'flatnews_shortcode_text_display',
			'icon' => 'fa fa-text-width',
			'fields' => array(
				'text_format' => array(
					'title' => esc_html__('Not auto add format tags (p, shortcodes)', 'flatnews'),
					'type' => 'checkbox'
				),
				'text_content' => array(
					'title' => esc_html__('Your Content', 'flatnews'),
					'type' => 'content'
				),
				'text_display' => array(
					'title' => esc_html__('Display Scenario', 'flatnews'),
					'type' => 'select', 
					'choices' => array(
						''  => esc_html__('Display for all devices', 'flatnews'),
						'desktop'  => esc_html__('Display for desktop only', 'flatnews'),
						'mobile'  => esc_html__('Display for mobile only', 'flatnews'),
					)
				),
			)
		),	
		'contact' => array(
			'title' => esc_html__('Contact', 'flatnews'), 
			'display_callback' => 'flatnews_shortcode_contact_display',
			'icon' => 'fa fa-envelope',
			'fields' => array(	
				'target_email' => array(
					'label' => esc_html__('Target Email. Blank mean using Admin email', 'flatnews'),
					'type' => 'email'
				),
				'enable_url' => array(
					'label' => esc_html__('Enable URL field', 'flatnews'),
					'type' => 'checkbox',
					'default'  => false
				)
			)
		),
		
		'column' => array(
			'display_callback' => 'flatnews_shortcode_column_display',
			'fields' => array(
				'class' => array(
					'label' => esc_html__('Class', 'flatnews')
				),
				'width' => array(
					'label' => esc_html__('Column width in percent (%)', 'flatnews'), 
					'type' => 'number',
					'default' => 100,					
				),
				'padding' => array(
					'label' => esc_html__('Inner Padding', 'flatnews'), 
					'description' => esc_html__('Add inner space of this column in pixels.', 'flatnews'),
					'type' => 'box-padding-px', 
				),				
				'sticky_inside' => array(
					'label' => esc_html__('Sticky Inside Content', 'flatnews'), 
					'description' => esc_html__('Sticky inside content when mouse scrolling', 'flatnews'),
					'type' => 'checkbox', 
					'default' => false
				),
			)
		),
	)
);


do_action('sneeit_setup_shortcodes', $FlatNews_Shortcodes);
