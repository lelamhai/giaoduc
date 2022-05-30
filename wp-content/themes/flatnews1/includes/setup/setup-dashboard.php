<?php
if (function_exists('sneeit_framework') &&
/* since 2.8, we require sneeit 3.1 to work */
defined('SNEEIT_PLUGIN_VERSION') && version_compare(SNEEIT_PLUGIN_VERSION, '3.1', '>=')) :
	
	$flatnews_demo_declarations = array(
		
		'flatnews' => array(
			'name' => __('Flat News', 'flatnews'), 
			'screenshot' => FLATNEWS_THEME_URL_IMAGES .'/demo-screenshot-flatnews.jpg',
			'files' => array(			
				'https://www.dropbox.com/s/agl8dq3kmy1wobg/sneeit-demo-data-1482728510.gz?dl=1',
				'https://www.dropbox.com/s/64uzjvbzpvypl7k/sneeit-demo-media-files-1482728514.gz?dl=1',
				'https://www.dropbox.com/s/mu3duzl22ihd1zp/sneeit-demo-media-files-1482728516.gz?dl=1',
				'https://www.dropbox.com/s/e009204k5yhnjx6/sneeit-demo-media-files-1482728518.gz?dl=1',
				'https://www.dropbox.com/s/9r75nlskicopdir/sneeit-demo-media-files-1482728521.gz?dl=1',
				'https://www.dropbox.com/s/5o7mwnkd8f6myoe/sneeit-demo-media-files-1482728523.gz?dl=1',
				'https://www.dropbox.com/s/6d1ineesmnhfp3f/sneeit-demo-media-structure-1482728512.gz?dl=1'			
			)
		)
	);
	

	$flatnews_demo_installer = array(
		'menu-title' => esc_html__('Demo Installation', 'flatnews'), 
		'page-title' => esc_html__('Demo Installation', 'flatnews'),
		'html-before' => '',
		'html-after' => '',
		'declarations' => $flatnews_demo_declarations,
	);
	do_action('sneeit_demo_installer', $flatnews_demo_installer);
	
	
	if (0) :
	$flatnews_envato_theme_activation = array(
		'menu-title' => esc_html__('Theme Activation', 'flatnews'), 
		'page-title' => esc_html__('Theme Activation', 'flatnews'),
	);
	if ( ! apply_filters( 'sneeit_envato_theme_activation_check', 0 ) ) {
		$flatnews_envato_theme_activation['html-before'] 
			= esc_html__( 'After activating theme, you will get auto update feature!', 'flatnews' ); 		
	} else {
		$flatnews_envato_theme_activation['html-before'] 
			= esc_html__( 'You activated the theme successful!', 'flatnews' );
	}
	do_action('sneeit_envato_theme_activation', $flatnews_envato_theme_activation);
	do_action('sneeit_envato_theme_auto_update');
	endif;
	
	do_action( 'sneeit_social_api_key_collector', array(
		'menu-title' => esc_html__('Social API Keys', 'flatnews'), 
		'page-title' => esc_html__('Social API Keys', 'flatnews'),
		'html-before' => '',
		'html-after' => '',
		'declarations' => array('youtube' => true),
	));
	
endif;