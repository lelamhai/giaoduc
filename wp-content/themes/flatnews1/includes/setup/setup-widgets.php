<?php
global $FlatNews_Article_Fields;
$FlatNews_Article_Fields_Widgets = $FlatNews_Article_Fields;
foreach ($FlatNews_Article_Fields_Widgets as $key => $value) {
	unset($FlatNews_Article_Fields_Widgets[$key]['title']);
	unset($FlatNews_Article_Fields_Widgets[$key]['title_bg_color']);
	unset($FlatNews_Article_Fields_Widgets[$key]['title_text_color']);
	unset($FlatNews_Article_Fields_Widgets[$key]['title_border_bottom_color']);
}

if (!function_exists('sneeit_framework')) {
	function flatnews_widgets_init() {
		register_sidebar(array(
			'name' => esc_html__( 'Main Sidebar', 'flatnews' ),
			'id' => 'sidebar',
			'description' => esc_html__( 'The sidebar on right side. Usually use to add common widgets', 'flatnews' ),
			'before_widget' => '<div id="%1$s" class="fn-block fn-%2$s"><div class="fn-block-content">',
			'after_widget'  => '<div class="clear"></div></div></div>',
			'before_title'  => '</div><h2 class="fn-block-title"><span class="fn-block-title-text">',
			'after_title'   => '</span></h2><div class="clear"></div><div class="fn-block-content">'
		));
	}
	add_action( 'widgets_init', 'flatnews_widgets_init');	
}

function fn_sidebar_register($name = '', $description = '', $tooltip = '') {
	return array(
		'name' => $name,
		'description' => $description,
		'tooltip' => $tooltip,
		'before_widget' => '<div id="%1$s" class="fn-block fn-widget fn-%2$s"><div class="fn-block-content">',
		'after_widget'  => '<div class="clear"></div></div></div>',
		'before_title'  => '</div><h2 class="fn-block-title"><span class="fn-block-title-text">',
		'after_title'   => '</span></h2><div class="clear"></div><div class="fn-block-content">'
	);
}

global $Fn_Sidebar_Register;
$Fn_Sidebar_Register =  array(
	'fn-main-sidebar' => fn_sidebar_register(
		esc_html__('MAIN SIDEBAR', 'flatnews'),	
		esc_html__( 'The sidebar on right side. Usually use to add common widgets', 'flatnews' )
	),
	
	'fn-before-header-sidebar' => fn_sidebar_register(
		esc_html__('Before Header', 'flatnews'),		
		esc_html__( 'The sidebar on top of page', 'flatnews' )
	),
	'fn-after-header-sidebar' => fn_sidebar_register(
		esc_html__('After Header', 'flatnews'),	
		esc_html__( 'The sidebar after header section', 'flatnews' )
	),	
	'fn-before-content-sidebar' => fn_sidebar_register(
		esc_html__('Before Content', 'flatnews'),	
		esc_html__( 'The sidebar on top of content area, before post title and feature image', 'flatnews' )
	),			

	'fn-before-post-body-sidebar' => fn_sidebar_register(
		esc_html__('Before Post Body', 'flatnews'),	
		esc_html__( 'The sidebar at above post body content', 'flatnews' )
	),
	'fn-left-post-body-sidebar' => fn_sidebar_register(
		esc_html__('Left of Post Body', 'flatnews'),	
		esc_html__( 'The sidebar at left of post body content', 'flatnews' )
	),
	'fn-after-post-body-sidebar' => fn_sidebar_register(
		esc_html__('After Post Body', 'flatnews'),	
		esc_html__( 'The sidebar at under post body content', 'flatnews' )
	),
	'fn-related-post-sidebar' => fn_sidebar_register(
		esc_html__('Related Post Sidebar', 'flatnews'),	
		esc_html__( 'The sidebar at the related post area of articles', 'flatnews' )
	),
	
	'fn-after-content-sidebar' => fn_sidebar_register(
		esc_html__('After Content', 'flatnews'),	
		esc_html__( 'The sidebar at bottom of content area, after post content and comments', 'flatnews' )
	),
	
	'fn-before-footer-sidebar' => fn_sidebar_register(
		esc_html__('Before Footer', 'flatnews'),	
		esc_html__( 'The sidebar before footer section', 'flatnews' )
	),	
	'fn-footer-sidebar-0' => fn_sidebar_register(
		esc_html__('Footer Column 1', 'flatnews'),	
		esc_html__( 'The first column in footer', 'flatnews' )
	),
	'fn-footer-sidebar-1' => fn_sidebar_register(
		esc_html__('Footer Column 2', 'flatnews'),	
		esc_html__( 'The second column in footer', 'flatnews' )
	),
	'fn-footer-sidebar-2' => fn_sidebar_register(
		esc_html__('Footer Column 3', 'flatnews'),	
		esc_html__( 'The third column in footer', 'flatnews' )
	),
	'fn-after-footer-sidebar' => fn_sidebar_register(
		esc_html__('After Footer', 'flatnews'),
		esc_html__( 'The sidebar at the very bottom of the page', 'flatnews' )
	),	
);

do_action('sneeit_setup_sidebars', $Fn_Sidebar_Register);
do_action('sneeit_support_custom_sidebars', array(
	'class'         => 'custom-section',
	'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="alt-widget-content">',
	'after_widget'  => '<div class="clear"></div></div></div>',
	'before_title'  => '</div><h2 class="widget-title"><span class="widget-title-content">',
	'after_title'   => '</span></h2><div class="clear"></div><div class="widget-content">'
));

$flatnews_widget_title_icon_field = array(
	'label' => esc_html__('Title FontAwesome Icon Code', 'flatnews'), 
	'description' => wp_kses(
		sprintf(__('Example: fa-home. <a href="%s" target="_blank">Check Full List of Icon Codes Here</a>', 'flatnews'), esc_url('https://fortawesome.github.io/Font-Awesome/icons/')),
		array(
			'a' => array(
				'href' => array(),
				'target' => array()
			),					
		)
	)
);

// widget without handle or action will call shortcode as default
$flatnews_widget_defines = array(
	'terms' => array(
		'title' => esc_html__('* FlatNews: Categories / Tags', 'flatnews'),
		'description' => esc_html__('Show category list', 'flatnews'),
		'display_callback' => 'flatnews_widget_categories',				
		'fields' => array(
			'title_icon' => $flatnews_widget_title_icon_field,
			'taxonomy' => array(
				'label' =>esc_html__('Taxonomy', 'flatnews'),
				'type' => 'select',
				'choices' => array(
					'category' => esc_html__('Categories', 'flatnews'),
					'post_tag' => esc_html__('Tags', 'flatnews'),
				)
			),
			'number' => array(
				'label' =>esc_html__('Number Items', 'flatnews'),
				'type' => 'number',	
				'default' => 5
			),
			'orderby' => array(
				'label' =>esc_html__('Order By', 'flatnews'),
				'type' => 'select',
				'choices' => array(
					'name' => esc_html__('Name', 'flatnews'),
					'count' => esc_html__('Post Count', 'flatnews'),
				)
			),
			'order' => array(
				'label' =>esc_html__('Order', 'flatnews'),
				'type' => 'select',
				'choices' => array(
					'ASC' => esc_html__('Ascending', 'flatnews'),
					'DESC' => esc_html__('Descending', 'flatnews'),
				)
			),
			'show_count' => array(
				'label' =>esc_html__('Show Post Count', 'flatnews'),
				'type' => 'checkbox',				
			),
		)
	),
	
	'image' => array(
		'title' => esc_html__('* FlatNews: Image', 'flatnews'),
		'description' => esc_html__('Image widget, easy for upload ads', 'flatnews'),
		'display_callback' => 'flatnews_widget_image',
		'fields' => array(
			'title_icon' => $flatnews_widget_title_icon_field,
			'image' => array(
				'label' =>esc_html__('Image', 'flatnews'),
				'type' => 'image',
				'default' => ''
			),
			'image_retina' => array(
				'label' =>esc_html__('Image Retina (2x)', 'flatnews'),
				'type' => 'image',
				'default' => ''
			),
			'mobile_image' => array(
				'label' =>esc_html__('Image for Mobile', 'flatnews'),
				'type' => 'image',
				'default' => ''
			),
			'mobile_image_retina' => array(
				'label' =>esc_html__('Image Retina (2x) for Mobile', 'flatnews'),
				'type' => 'image',
				'default' => ''
			),
			'image_link' => array(
				'label' =>esc_html__('Image Link', 'flatnews'),
				'type' => 'url'
			),
			'new_window' => array(
				'label' =>esc_html__('Open Link in New Window', 'flatnews'),
				'type' => 'checkbox',
				'show' => array(
					array('image_link', '!=', '')
				)
			)
		)
	),
	'facebook_page' => array(
		'title' => esc_html__('* FlatNews: Facebook Fan Page', 'flatnews'),
		'description' => esc_html__('Facebook Fan Page Box', 'flatnews'),
		'display_callback' => 'flatnews_widget_facebook_page',
		'fields' => array(
			'title_icon' => $flatnews_widget_title_icon_field,
			'href' => array(
				'label' =>esc_html__('Facebook Page URL', 'flatnews'),
				'type' => 'url',
				'default' => 'https://www.facebook.com/Sneeit-622691404530609/'
			),
			'width' => array(
				'label' => esc_html__('Width in Pixels', 'flatnews'), 
				'type' => 'range', 
				'min' => 180,
				'max' => 500,
				'default' => 300
			),
			'height' => array(
				'label' => esc_html__('Height in Pixels', 'flatnews'),
				'type' => 'range',
				'min' => 70,
				'max' => 800,
				'default' => 130
			),
			'adapt-container-width' => array(
				'label' => esc_html__('Adapt to Plugin Container Width', 'flatnews'),
				'type' => 'checkbox',
				'default' => true
			),
			'show-facepile' => array(
				'label' => esc_html__("Show Friend's Faces", 'flatnews'),
				'type' => 'checkbox',
				'default' => false
			),
			'small-header' => array(
				'label' => esc_html__('Use Small Header', 'flatnews'),
				'type' => 'checkbox',
				'default' => false
			),
			'hide-cover' => array(
				'label' => esc_html__('Hide Cover Photo', 'flatnews'),
				'type' => 'checkbox',
				'default' => false
			),
			'show-posts' => array(
				'label' => esc_html__('Show Page Posts', 'flatnews'),
				'type' => 'checkbox',
				'default' => false
			)
		)
	),	
	
	'social_icons' => array(
		'title' => esc_html__('* FlatNews: Social Icons', 'flatnews'),
		'description' => esc_html__('List of social icons', 'flatnews'),
		'display_callback' => 'flatnews_widget_social_icons',
		'fields' => array(
			'title_icon' => $flatnews_widget_title_icon_field,
			'social_links' => array(
				'title' => esc_html__('Social Links', 'flatnews'),
				'description' => esc_html__('One link per line. If a link can not display, that\'s mean the icon pack does not support that network. Leave this blank to hide.', 'flatnews'),
				'type' => 'textarea',
			)
		)
	),	
	
	'social_counter' => array(
		'title' => esc_html__('* FlatNews: Social Counter', 'flatnews'),
		'description' => esc_html__('Social Counter with Links', 'flatnews'),
		'display_callback' => 'flatnews_widget_social_counter',
		'fields' => array(
			'title_icon' => $flatnews_widget_title_icon_field,
			'twitter_url' => array(
				'label' => esc_html__('Twitter URL', 'flatnews'), 
				'type' => 'url',
				'default' => 'https://twitter.com/tiennguyentweet'
			),
			'facebook_url' => array(
				'label' =>esc_html__('Facebook Page URL', 'flatnews'),
				'type' => 'url',
				'default' => 'https://www.facebook.com/Sneeit-622691404530609/'
			),
			'google_plus_url' => array(
				'label' =>esc_html__('Google Plus URL', 'flatnews'),
				'type' => 'url',
				'default' => 'https://plus.google.com/u/0/+TienNguyenPlus'
			),
			'instagram_url' => array(
				'label' =>esc_html__('Instagram URL', 'flatnews'),
				'type' => 'url',
				'default' => 'https://www.instagram.com/envato/'
			),
			'pinterest_url' => array(
				'label' =>esc_html__('Pinterest URL', 'flatnews'),
				'type' => 'url',
				'default' => 'https://www.pinterest.com/tvnguyen/'
			),
			'behance_url' => array(
				'label' =>esc_html__('Behance Profile URL', 'flatnews'),
				'type' => 'url',
				'default' => 'https://www.behance.net/tiennguyenvan'
			),
			'youtube_url' => array(
				'label' =>esc_html__('Youtube Channel URL', 'flatnews'),
				'type' => 'url',
				'default' => 'https://www.youtube.com/channel/UCMwiaL6nKXKnSrgwqzlbkaw'
			),
		)
	),
	'quote' => array(
		'title' => esc_html__('* FlatNews: Quote Box', 'flatnews'),
		'description' => esc_html__('Quote box with background', 'flatnews'),
		'display_callback' => 'flatnews_widget_quote_display',
		'fields' => array(		
			'title_icon' => $flatnews_widget_title_icon_field,
			'content' => array(
				'label' => esc_html__('Content', 'flatnews'), 
				'type' => 'textarea',
				'default' => ''
			),
			'author' => array(
				'label' =>esc_html__('Author Name', 'flatnews'),
				'default' => ''
			),
			'image' => array(
				'label' =>esc_html__('Author Image', 'flatnews'),
				'type' => 'image',
				'default' => '',
				'show' => array(
					array('author', '!=', '')
				)
			),
			'link' => array(
				'label' =>esc_html__('Author Link', 'flatnews'),
				'type' => 'URL',
				'default' => '',
				'show' => array(
					array('author', '!=', '')
				)
			),
			'desc' => array(
				'label' =>esc_html__('Author Description', 'flatnews'),
				'type' => 'URL',
				'default' => '',
				'show' => array(
					array('author', '!=', '')
				)
			)
		)
	),	
	'html' => array(
		'title' => esc_html__('* FlatNews: HTML Box', 'flatnews'),
		'description' => esc_html__('To place your custom HTML code, example ads', 'flatnews'),
		'display_callback' => 'flatnews_widget_html_display',
		'fields' => array(		
			'title_icon' => $flatnews_widget_title_icon_field,
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
	
	'slides' => array(
		'title' => esc_html__('* FlatNews Article Box:  Slider', 'flatnews'),
		'description' => esc_html__('Show articles as slider', 'flatnews'),
		'display_callback' => 'flatnews_widget_slider_display',
		'fields'  => $FNAB_Fields['slider'],
	),
	'carousel' => array(
		'title' => esc_html__('* FlatNews Article Box:  Carousel', 'flatnews'), 
		'description' => esc_html__('Show article as carousel block', 'flatnews'), 
		'display_callback' => 'flatnews_widget_carousel_display', 
		'fields' => $FNAB_Fields['carousel']
	),	
	'sticky' => array(
		'title' => esc_html__('* FlatNews Article Box: Sticky', 'flatnews'), 
		'description' => esc_html__('Show articles as sticky block', 'flatnews'), 
		'display_callback' => 'flatnews_widget_sticky_display', 
		'fields' => $FNAB_Fields['sticky']
	),
	'grid' => array(
		'title' => esc_html__('* FlatNews Article Box:  Grid', 'flatnews'), 
		'description' => esc_html__('Show article as grid block', 'flatnews'), 
		'display_callback' => 'flatnews_widget_grid_display', 
		'fields' => $FNAB_Fields['grid']
	),
	'flex' => array(
		'title' => esc_html__('* FlatNews Article Box:  Flex', 'flatnews'), 
		'description' => esc_html__('Show article as complex block', 'flatnews'), 
		'display_callback' => 'flatnews_widget_flex_display', 
		'fields' => $FNAB_Fields['flex']
	),	
	'blog' => array(
		'title' => esc_html__('* FlatNews Article Box:  Blog Roll', 'flatnews'), 
		'description' => esc_html__('Show article as blogging block', 'flatnews'), 
		'display_callback' => 'flatnews_widget_blog_display', 
		'fields' => $FNAB_Fields['blog']
	),	
	
);

// adjust value
if (defined('PHP_VERSION_ID')) {
	$flatnews_widget_defines['social_counter']['fields']['linkedin_url'] = array(
		'label' =>esc_html__('Public Linkedin Profile URL', 'flatnews'),
		'type' => 'url',
		'default' => 'https://vn.linkedin.com/in/tien-nguyen-van-4982736b'
	);
}

do_action('sneeit_setup_widgets', $flatnews_widget_defines);