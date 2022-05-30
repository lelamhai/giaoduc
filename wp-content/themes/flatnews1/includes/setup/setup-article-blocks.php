<?php

/* 
 * FIELD SETTINGS
 * **************
 */
/* - BLOCK HEADER */
$FNAB_Header_Fields = array_merge(
	array(	
		'title' => array(
			'label' => esc_html__('Title', 'flatnews'),		
			'description' => esc_html__('Header Title Text', 'flatnews'),		
		),
		'title_url' => array(
			'label' => esc_html__('Title URL', 'flatnews'), 
			'description' => esc_html__('Header Text URL. Leave blank to use default', 'flatnews'),
			'type' => 'url'
		),
		'title_icon' => array(
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
		),
		
		'block_color' => array(
			'label' => esc_html__('Block Main Color', 'flatnews'), 		
			'type' => 'color'
		),			
		'explore_all' => array(
			'label' => esc_html__('Explore All Button Text', 'flatnews'), 		
			'description' => esc_html__('Text for explore all button. Leave blank to hide', 'flatnews'),
			'default' => 'EXPLORE ALL',
		),		
		'block_description' => array(
			'label' => esc_html__('Block Description', 'flatnews'), 		
			'type' => 'content',
		),	
	),
	apply_filters('sneeit_articles_query_fields', array()),
	array(
		'text_align' => array(
			'label' => esc_html__('Text Align', 'flatnews'), 
			'description' => esc_html__('Block content text align', 'flatnews'),
			'type' => 'select', 
			'default' => 'left',
			'choices' => array(
				'left' => esc_html__('Left', 'flatnews'), 
				'center' => esc_html__('Center', 'flatnews'), 
				'right' => esc_html__('Right', 'flatnews'), 
			),
			'heading' => esc_html__('Specific Block Design', 'flatnews'), 
		),
	)
);

/* - BLOCK DISPLAY */
$FNAB_Display_Common_Fields = apply_filters('sneeit_articles_display_fields', array());
$FNAB_Display_Common_Fields['meta_order']['choices'] = array(		
	'author' => esc_html__('Authors', 'flatnews'),		
	'comment' => esc_html__('Comments', 'flatnews'),
	'date' => esc_html__('Date', 'flatnews'),
);
$FNAB_Display_Common_Fields['meta_order']['default'] = 'author,date,comment';
unset($FNAB_Display_Common_Fields['show_view_count']);

/* -- pagination */
$FNAB_Display_Pagination_Fields = apply_filters('sneeit_articles_pagination_fields', array());

/* - SPECIFIC BLOCKS */
/* -- SLIDER */
$FNAB_Slider_Fields = array(
	'show_nav' => array(
		'label' => esc_html__('Show Navigate Buttons', 'flatnews'), 
		'description' => esc_html__('The arrow buttons which allow user navigate slides', 'flatnews'), 
		'type' => 'checkbox', 
		'default' => true,
	),
	'show_dots' => array(
		'label' => esc_html__('Show Dot Buttons', 'flatnews'), 
		'description' => esc_html__('The dot buttons which allow user navigate slides', 'flatnews'), 
		'type' => 'checkbox', 
		'default' => true
	),
	'speed' => array(
		'label' => esc_html__('Animate Speed', 'flatnews'), 
		'description' => esc_html__('The animate speed in miliseconds', 'flatnews'), 
		'type' => 'range',
		'max' => 10000,
		'min' => 1000,
		'step' => 1000,
		'default' => 5000
	),
);


/* -- FLEXIBLE */
$FNAB_Flex_Big_Layout_Images = array(
	'item-in-in',
	'item-under-in',
	'item-under-above',
	'item-under-under',
	'item-underover-in',
	'item-underover-above',
	'item-underover-under',
	'item-above-in',
	'item-above-above',
	'item-above-under'	
);
$FNAB_Flex_Big_Layout_Choices = array();
foreach ($FNAB_Flex_Big_Layout_Images as $value) {
	$FNAB_Flex_Big_Layout_Choices[$value] = wp_kses('<img src="'.esc_attr(FLATNEWS_THEME_URL_IMAGES).$value.'.png"/>', array('img' => array('src' => array())));
}

/* --- clone fields for big and small item*/
/* ---- BIG ITEM */
$FNAB_Flex_Big_Display_Common_Fields = array_merge(array(
	'item_layout' => array(
		'label' => esc_html__('Item Layout', 'flatnews'), 		
		'type' => 'visual', 
		'default' => 'item-in-in',
		'choices' => $FNAB_Flex_Big_Layout_Choices,
		'heading' => esc_html__('Big Item Design', 'flatnews'), 
	),
	'item_highlight' => array(
		'label' => esc_html__('Highlight Big Item', 'flatnews'), 		
		'description' => esc_html__('Add solid background color to item content box', 'flatnews'), 		
		'type' => 'checkbox',
		'show' => array(			
			array('item_layout', '!=', 'item-in-in')
		)
	),
), $FNAB_Display_Common_Fields);	
unset($FNAB_Flex_Big_Display_Common_Fields['meta_order']['heading']);
$FNAB_Flex_Big_Display_Common_Fields_Temp = array();
foreach ($FNAB_Flex_Big_Display_Common_Fields as $key => $value) {
	$FNAB_Flex_Big_Display_Common_Fields_Temp['big_'.$key] = $value;	
}
$FNAB_Flex_Big_Display_Common_Fields = $FNAB_Flex_Big_Display_Common_Fields_Temp;
$FNAB_Flex_Big_Display_Common_Fields['big_thumb_height']['show'] = array(
	array('big_auto_thumb', '!=', 'on')
);
$FNAB_Flex_Big_Display_Common_Fields['big_show_readmore']['show'] = array(
	array('big_snippet_length', '!=', 0)
);


/* ---- SMALL ITEM */
$FNAB_Flex_Small_Layout_Images = array(
	'item-right-in',
	'item-right-above',
	'item-right-under',
	'item-left-in',
	'item-left-above',
	'item-left-under'	
);
$FNAB_Flex_Small_Layout_Choices = array();
foreach ($FNAB_Flex_Small_Layout_Images as $value) {
	$FNAB_Flex_Small_Layout_Choices[$value] = wp_kses('<img src="'.esc_attr(FLATNEWS_THEME_URL_IMAGES).$value.'.png"/>', array('img' => array('src' => array())));
}
$FNAB_Flex_Small_Display_Common_Fields = array_merge(array(
	'item_layout' => array(
		'label' => esc_html__('Item Layout', 'flatnews'), 		
		'type' => 'visual', 
		'default' => 'item-in-in',
		'choices' => $FNAB_Flex_Small_Layout_Choices,
		'heading' => esc_html__('Small Item Design', 'flatnews'), 
	),
), $FNAB_Display_Common_Fields);
unset($FNAB_Flex_Small_Display_Common_Fields['meta_order']['heading']);

/* - FINALIZE */
global $FNAB_Fields;
$FNAB_Fields = array();
/* -- slider */
$FNAB_Fields['slider'] = array_merge(
	$FNAB_Header_Fields,	
	$FNAB_Slider_Fields,	
	$FNAB_Display_Common_Fields	
);

$FNAB_Fields['slider']['thumb_height']['description'] = esc_html__('Thumbnail height in pixels', 'flatnews');
$FNAB_Fields['slider']['thumb_height']['min'] = 100;
$FNAB_Fields['slider']['thumb_height']['default'] = 400;
unset($FNAB_Fields['slider']['auto_thumb']);

/* -- carousel */
$FNAB_Fields['carousel'] = array_merge(
	$FNAB_Header_Fields,
	$FNAB_Slider_Fields,
	array(
		'columns' => array(
			'label' => esc_html__('Number Columns', 'flatnews'), 
			'description' => esc_html__('Number columns of carousel', 'flatnews'),
			'type' => 'range', 
			'min' => 2,
			'max' => 5,
			'default' => 2
		),
	),		
	$FNAB_Display_Common_Fields	
);
$FNAB_Fields['carousel']['thumb_height']['description'] = esc_html__('Thumbnail height in pixels', 'flatnews');
$FNAB_Fields['carousel']['thumb_height']['min'] = 100;
$FNAB_Fields['carousel']['thumb_height']['default'] = 400;
unset($FNAB_Fields['carousel']['auto_thumb']);

/* -- grid */
$FNAB_Grid_Layout_Images = array(
	'fn-grid-w50h100-2w50h50',
	'fn-grid-w50h100-w50h50-2w25h50',
	'fn-grid-w50h100-4w25h50',
	'fn-grid-w60h100-3w40h33',	
	'fn-grid-2w50h60-3w33h40',
	'fn-grid-2w50h70-5w20h30',
	'fn-grid-2w33h66-5w33h33',
	'fn-grid-w50h100-2w25h100'
);
$FNAB_Grid_Layout_Choices = array();
foreach ($FNAB_Grid_Layout_Images as $value) {
	$FNAB_Grid_Layout_Choices[$value] = wp_kses('<img src="'.esc_attr(FLATNEWS_THEME_URL_IMAGES).$value.'.png"/>', array('img' => array('src' => array())));
}
$FNAB_Fields['grid'] = array_merge(
	$FNAB_Header_Fields,	
	array(
		/* -- Grid */
		'grid_layout' => array(
			'label' => esc_html__('Grid Layout', 'flatnews'), 		
			'type' => 'visual', 
			'default' => 'fn-grid-w50h100-2w50h50',
			'choices' => $FNAB_Grid_Layout_Choices,
		),
		'item_spacing' => array(
			'label' => esc_html__('Item Spacing', 'flatnews'), 		
			'description' => esc_html__('Spacing between items as pixels', 'flatnews'), 		
			'type' => 'range',
			'default' => 0,
			'max' => 50,			
		),
	),
	
	$FNAB_Display_Common_Fields
);
$FNAB_Fields['grid']['thumb_height']['description'] = esc_html__('Thumbnail height in pixels', 'flatnews');
$FNAB_Fields['grid']['thumb_height']['min'] = 100;
$FNAB_Fields['grid']['thumb_height']['default'] = 400;
unset($FNAB_Fields['grid']['auto_thumb']);

/* -- blogging */
$FNAB_Blog_Layout_Images = array(
	'item-in-in',
	'item-under-in',
	'item-under-above',
	'item-under-under',
	'item-underover-in',
	'item-underover-above',
	'item-underover-under',
	'item-above-in',
	'item-above-above',
	'item-above-under',
	'item-right-in',
	'item-right-above',
	'item-right-under',
	'item-left-in',
	'item-left-above',
	'item-left-under'
);
$FNAB_Blog_Layout_Choices = array();
foreach ($FNAB_Blog_Layout_Images as $value) {
	$FNAB_Blog_Layout_Choices[$value] = wp_kses('<img src="'.esc_attr(FLATNEWS_THEME_URL_IMAGES).$value.'.png"/>', array('img' => array('src' => array())));
}
global $FNAB_Fields_Archive;
$FNAB_Fields_Archive = array_merge(		
	array(		
		'columns' => array(
			'label' => esc_html__('Column Number', 'flatnews'), 		
			'type' => 'range', 
			'min' => 1,
			'max' => 5,
			'default' => 1			
		),		
		'item_layout' => array(
			'label' => esc_html__('Item Layout', 'flatnews'), 		
			'type' => 'visual', 
			'default' => 'item-right-in',
			'choices' => $FNAB_Blog_Layout_Choices,
		),		
		'item_spacing' => array(
			'label' => esc_html__('Item Spacing', 'flatnews'), 		
			'description' => esc_html__('Spacing between items as pixels', 'flatnews'), 		
			'type' => 'range',
			'default' => 20,
			'max' => 50,			
		),
		'item_highlight' => array(
			'label' => esc_html__('Highlight Item', 'flatnews'), 		
			'description' => esc_html__('Add solid background color to item content box', 'flatnews'), 		
			'type' => 'checkbox',
			'show' => array(			
				array('item_layout', '==', 'item-under-in'), '||',				
				array('item_layout', '==', 'item-under-above'), '||',
				array('item_layout', '==', 'item-under-under'), '||',
				array('item_layout', '==', 'item-underover-in'), '||',
				array('item_layout', '==', 'item-underover-above'), '||',
				array('item_layout', '==', 'item-underover-under'), '||',
				array('item_layout', '==', 'item-above-in'), '||',
				array('item_layout', '==', 'item-above-above'), '||',
				array('item_layout', '==', 'item-above-under')
			)
		),
		'item_align' => array(
			'label' => esc_html__('Item Align Style', 'flatnews'), 		
			'type' => 'visual', 
			'default' => 'top',
			'choices' => array(
				'top' => wp_kses('<img src="'.esc_attr(FLATNEWS_THEME_URL_IMAGES).'item-align-top.png"/>', array(
					'img' => array(
						'src' => array()
					)
				)),
				'flex' => wp_kses('<img src="'.esc_attr(FLATNEWS_THEME_URL_IMAGES).'item-align-flex.png"/>', array(
					'img' => array(
						'src' => array()
					)
				))
			),
			'show' => array(
				array('columns', '>', 1)
			)
		),
	),
	
	$FNAB_Display_Common_Fields,
	$FNAB_Display_Pagination_Fields
);
$FNAB_Fields['blog'] = array_merge(
	$FNAB_Header_Fields,	
	$FNAB_Fields_Archive
);


/* -- sticky */
$FNAB_Sticky_Layout_Images = array(
	'item-in-in',
	'item-under-in',
	'item-under-above',
	'item-under-under',
	'item-underover-in',
	'item-underover-above',
	'item-underover-under',
	'item-above-in',
	'item-above-above',
	'item-above-under'	
);
$FNAB_Sticky_Layout_Choices = array();
foreach ($FNAB_Sticky_Layout_Images as $value) {
	$FNAB_Sticky_Layout_Choices[$value] = wp_kses('<img src="'.esc_attr(FLATNEWS_THEME_URL_IMAGES).$value.'.png"/>', array('img' => array('src' => array())));
}
$FNAB_Fields['sticky'] = array_merge(
	$FNAB_Header_Fields,	
	array(			
		'item_layout' => array(
			'label' => esc_html__('Main Item Layout', 'flatnews'), 		
			'type' => 'visual', 
			'default' => 'item-in-in',
			'choices' => $FNAB_Sticky_Layout_Choices,
		),
		'item_spacing' => array(
			'label' => esc_html__('Item Spacing', 'flatnews'), 		
			'description' => esc_html__('Spacing between items as pixels', 'flatnews'), 		
			'type' => 'range',
			'default' => 20,
			'max' => 50,			
		),
		'item_highlight' => array(
			'label' => esc_html__('Highlight Big Item', 'flatnews'), 		
			'description' => esc_html__('Add solid background color to item content box', 'flatnews'), 		
			'type' => 'checkbox',
			'show' => array(			
				array('item_layout', '!=', 'item-in-in')
			),
			'default' => 'on'
		),
	),	
	$FNAB_Display_Common_Fields,
	array(
		'small_auto_thumb' => array(
			'label' => esc_html__('Auto Thumbnail Height', 'flatnews'), 
			'description' => esc_html__('Thumbnail image as natural height, instead of specific height of pixels', 'flatnews'),
			'type' => 'checkbox', 
			'default' => false,
			'heading' => esc_html__('Small Item Design', 'flatnews'), 
		),
		'small_thumb_height' => array(
			'label' => esc_html__('Thumbnail Height', 'flatnews'), 
			'description' => esc_html__('Thumbnail image height in pixels. Set to 0 hide', 'flatnews'),
			'type' => 'range', 
			'max' => 1999, 
			'min' => 10,
			'step' => 1,
			'default' => 150,
			'show' => array(
				array('small_auto_thumb', '!=', 'on')
			)
		),
	)
);
$FNAB_Fields['sticky']['count']['default'] = 3;
$FNAB_Fields['sticky']['thumb_height']['min'] = 10;
$FNAB_Fields['sticky']['thumb_height']['description'] = esc_html__('Thumbnail height in pixels', 'flatnews');

/* -- flexible*/
$FNAB_Flex_Layout_Images = array(
	'flex-layout-one-big',
	'flex-layout-top-big',
);
$FNAB_Flex_Layout_Choices = array();
foreach ($FNAB_Flex_Layout_Images as $value) {
	$FNAB_Flex_Layout_Choices[$value] = wp_kses('<img src="'.esc_attr(FLATNEWS_THEME_URL_IMAGES).$value.'.png"/>', array('img' => array('src' => array())));
}

$FNAB_Fields['flex'] = array_merge(
	$FNAB_Header_Fields,	
	array(				
		'flex_layout' => array(
			'label' => esc_html__('Layout Design', 'flatnews'), 		
			'type' => 'visual', 
			'default' => 'flex-layout-one-big',
			'choices' => $FNAB_Flex_Layout_Choices,			
		),
		'columns' => array(
			'label' => esc_html__('Number Columns', 'flatnews'),
			'type' => 'range',
			'default' => 2,
			'min' => 1,
			'max' => 3
		),
		'col_count' => array(
			'label' => esc_html__('Number Items in Each Column', 'flatnews'),
			'type' => 'range',
			'default' => 3,
			'min' => 1,
			'max' => 20,
			'show' => array(
				array('flex_layout', '!=', 'flex-layout-one-big')
			)
		),
		'first_col_count' => array(
			'label' => esc_html__('Number Items of 1st Column', 'flatnews'),
			'type' => 'range',
			'default' => 1,
			'min' => 1,
			'max' => 20,
			'show' => array(
				array('flex_layout', '==', 'flex-layout-one-big')
			)
		),
		'other_col_count' => array(
			'label' => esc_html__('Number Items of Other Columns', 'flatnews'),
			'type' => 'range',
			'default' => 4,
			'min' => 1,
			'max' => 20,
			'show' => array(
				array('flex_layout', '==', 'flex-layout-one-big')
			)
		),
		'item_spacing' => array(
			'label' => esc_html__('Item Spacing', 'flatnews'), 		
			'description' => esc_html__('Spacing between items as pixels', 'flatnews'), 		
			'type' => 'range',
			'default' => 20,
			'max' => 50,			
		),
	),
	$FNAB_Flex_Big_Display_Common_Fields,
	$FNAB_Flex_Small_Display_Common_Fields,
	$FNAB_Display_Pagination_Fields
);
unset($FNAB_Fields['flex']['count']);
$FNAB_Fields['flex']['orderby']['heading'] = esc_html__('Post Queries', 'flatnews');