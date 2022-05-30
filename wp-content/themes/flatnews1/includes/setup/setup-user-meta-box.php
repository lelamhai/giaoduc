<?php

// user-meta-box without handle or action will call shortcode as default
do_action('sneeit_setup_user_meta_box', array(
	'user-extra-options' => array(
		'title' => esc_html__('Extra Author Options', 'flatnews'),		
		'fields' => array(
			'user-social-links' => array(
				'title' => esc_html__('Social Links', 'flatnews'),
				'description' => esc_html__('One link per line. If a link can not display, that\'s mean the icon pack does not support that network. Leave this blank to hide.', 'flatnews'),
				'type' => 'textarea',

			),
		)
	),
	
));

