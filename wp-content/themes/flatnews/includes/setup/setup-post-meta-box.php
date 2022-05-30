<?php

// post-meta-box without handle or action will call shortcode as default
$flatnews_post_meta_box_fields = array(
	'design-options' => array(
		'title' => esc_html__('Design Options', 'flatnews'),
		'fields' => array(
			'content-layout' => array(
				'label' => esc_html__('Content Layout (Page Template)', 'flatnews'),
				'description' => esc_html__('If you want to show page builder layout, select "Content Only"', 'flatnews'),
				'type' => 'select',
				'default' => '', 
				'choices' => array(					
					'' => esc_html__('Default', 'flatnews'),
					'builder' => esc_html__('Builder (Content Only)', 'flatnews')
				)
			),
			'sub-title' => array(
				'label' => esc_html__('Sub Title', 'flatnews'),
				'show' => array(
					array('content-layout', '!=', 'builder')
				)
			),
		)
	),
	'sidebar-options' => array(
		'title' => esc_html__('Sidebar Options', 'flatnews'),
		'description' => esc_html__('Select sidebar config as you want.', 'flatnews'),
		'fields' => fn_customizer_sidebar_settings('singular', true),
	),
	'feature-box' => array(
		'title'   => esc_html__('Extra Data for Feature Box', 'flatnews'),
		'context' => 'side',
		'fields'  => array(
			'post-feature-media' => array(
				'label'       => esc_html__('Video / Audio Embedded Code', 'flatnews'),
				'description' => esc_html__('Use this emebedded code as feature box instead of using feature image. If Youtube or Vimeo, only URL is also OK', 'flatnews'),
				'type'        => 'textarea',
			),
			'post-feature-caption' => array(
				'label'       => esc_html__('Caption for Feature Box', 'flatnews'),
				'description' => esc_html__('This caption will be show on the bottom right conner of feature box (regardless image or video or audio)', 'flatnews'),
				'type'        => 'textarea',
			),
		)
	),
);

do_action('sneeit_setup_post_meta_box', $flatnews_post_meta_box_fields);

do_action('sneeit_review_system', array(
	/* meta box id, also using to save / get data 
	 * optional, default: post-review
	 */
	'id' => 'post-review', 
	
	'title' => esc_html__('Review / Rating Box', 'flatnews'), /* optional, title for meta box */
	'description' => esc_html__('Input your rating review', 'flatnews'), /* optional, description for meta box */
		
	'type' => array('point'), /* optional, default: array('start', 'point', 'percent')  */
	'post_type' => array('post'), /* optional, what post type will support the meta box, default :array('post', 'page')*/
	'context' => 'advance', /*optional, position of metabox (advance, side, normal), default: advance*/
	
	'support' => array('conclusion','visitor'),/*option, what extra features for rating feature, default: array('summary', 'conclusion', 'visitor' ) visitor is mean support visitor rating */
	
	'priority' => 'default', /*optional, order of metabox, default: default*/
	
	'display' => array(
//		'hook' => 'flatnews_display_rating_hook', /* optional, must place hook inside post loop, default: the_content */
		'callback' => 'flatnews_display_rating_box', /*required: HTML review box at your hook*/
		
		/*modify template*/
		'class_star_bar' => '',
		'class_star_bar_top' => 'color',
		'class_star_bar_bottom' => '',
		
		'class_line_bar' => '',
		'class_line_bar_top' => 'bg',
		
		'class_average_value' => '',
		'class_average_value_text' => '',
		'class_average_value_canvas' => 'color',
		'class_average_value_star_bar' => '',
		'class_average_value_star_bar_top' => '',
		'class_average_value_star_bar_bottom' => '',
			
		'class_item' => '',
		'class_item_name' => '',
		'class_item_user' => '',
		'class_item_author' => '',
		'class_item_user_note' => '',
		
		/*text for translate*/
		'text_no_user_vote' => esc_html__('Have no any user vote', 'flatnews'),
		'text_n_user_votes' => esc_html__('%1$s user %2$s x %3$s', 'flatnews'),
		'text_vote' => esc_html__('vote', 'flatnews'),
		'text_votes' => esc_html__('votes', 'flatnews'),
		
		'text_click_line_rate' => esc_html__('Hover and click above bar to rate', 'flatnews'),
		'text_click_star_rate' => esc_html__('Hover and click above stars to rate', 'flatnews'),
		'text_rated' => esc_html__('You rated %s', 'flatnews'),			
		'text_will_rate' => esc_html__('You will rate %s', 'flatnews'),
		'text_submitting' => esc_html__('Submitting ...', 'flatnews'),
		'text_browser_not_support' => esc_html__('Your browser not support user rating', 'flatnews'),
		'text_server_not_response' => esc_html__('Server not response your rating', 'flatnews'),
		'text_server_not_accept' => esc_html__('Server not accept your rating', 'flatnews'),
		
		// backend
		'text_is_product_review' => esc_html__('Is product review?', 'flatnews'),
		'text_no' => esc_html__('No', 'flatnews'),
		'text_star' => esc_html__('Star', 'flatnews'),
		'text_point' => esc_html__('Point', 'flatnews'),
		'text_percent' => esc_html__('Percent', 'flatnews'),
		'text_add_star_criteria_for_product' => esc_html__('Add star criteria for this product', 'flatnews'),
		'text_add_point_criteria_for_product' => esc_html__('Add point criteria for this product', 'flatnews'),
		'text_add_percent_criteria_for_product' => esc_html__('Add percent criteria for this product', 'flatnews'),
		'text_criteria_name' => esc_html__('Criteria name', 'flatnews'),
		'text_criteria_value' => esc_html__('Criteria value', 'flatnews'),
		'text_1_star' => esc_html__('%s star', 'flatnews'),
		'text_n_stars' => esc_html__('%s stars', 'flatnews'),
		'text_n_stars' => esc_html__('%s stars', 'flatnews'),
		'text_add_new_criteria' => esc_html__('Add New Criteria', 'flatnews'),
		'text_input_summary' => esc_html__('Input Review Summary', 'flatnews'),
		'text_input_conclusion' => esc_html__('Input Review Conclusion', 'flatnews'),
		'text_allow_visitor' => esc_html__('Allow Visitor Review', 'flatnews'),
		
		'text_n_user_vote_x_score' => esc_html__('%1$s user %2$s x %3$s', 'flatnews'),
		
		/*decoration*/
		'star_icon' => '&#9733;', /*defaut: &#9733;*/
	)
));

function flatnews_display_rating_box($review) {
?><div id="post-review" class="post-review shad"><?php
	?><div class="post-review-main"><?php
		?><div class="post-review-average"><?php
			echo $review['average'];			
			?><div class="clear"></div><?php
			?><div class="post-review-average-label"><?php
				esc_html_e('OVERALL SCORE', 'flatnews');
			?></div><?php
			?><div class="clear"></div><?php
		?></div><?php /* .post-review-average */ 

		?><div class="post-review-items"><div class="post-review-items-inner"><?php
			echo $review['items'];
			?><div class="clear"></div><?php
		?></div></div><?php
		
		?><div class="clear"></div><?php
	?></div><?php /* post-review-main */

	if ($review['conclusion']):
		?><div class="clear"></div><?php
		?><div class="post-review-conclusion"><?php
			echo $review['conclusion'];
		?></div><?php
	endif;
	?><div class="clear"></div><?php
?></div><?php
}
