<?php
function flatnews_widget_social_counter_callback() {	
	$block_id = flatnews_get_server_request('block_id');	
			
	$social_list = array(
		'twitter' => array( 'followers', esc_html__('Followers', 'flatnews'), esc_html__('Follow', 'flatnews')), 
		'facebook' => array( 'likes', esc_html__('Likes', 'flatnews'), esc_html__('Like', 'flatnews')),
		'google_plus' => array( 'followers', esc_html__('Followers', 'flatnews'), esc_html__('Follow', 'flatnews')), 
		'instagram' => array( 'followers', esc_html__('Followers', 'flatnews'), esc_html__('Follow', 'flatnews')), 
		'pinterest' => array( 'followers', esc_html__('Followers', 'flatnews'), esc_html__('Follow', 'flatnews')), 
		'behance' => array( 'followers', esc_html__('Followers', 'flatnews'), esc_html__('Follow', 'flatnews')),
		'youtube' => array( 'subscribers', esc_html__('Subscribers', 'flatnews'), esc_html__('Subscribe', 'flatnews')),
	);
	
	if (defined('PHP_VERSION_ID')) {
		$social_list['linkedin'] = array( 'connections', esc_html__('Connections', 'flatnews'), esc_html__('Connect', 'flatnews'));
	}
		
	
	$social_url = array();
	foreach ($social_list as $key => $value) :
		$social_url[$key] = flatnews_get_server_request($key);
	endforeach;
	
	$index = 0;		
	
	// output as HTML
	ob_start(); 	
	foreach ($social_list as $key => $value) : ?>
		<?php if ($social_url[$key]) : 
		$counter = 	apply_filters('sneeit_number_'.$key.'_'.$value[0], $social_url[$key]);
		if ($counter == -1) {			
			continue;
		}
		
		$social_name = esc_attr(str_replace('_', '-', $key));
		?>

		<a class="social-counter social-counter-<?php echo $index; ?> social-counter-<?php echo $social_name ?>" href="<?php echo esc_url($social_url[$key]); ?>" target="_blank">
			<span class="icon"><i class="fa fa-<?php echo $social_name; ?>"></i></span>
			<span class="count"><?php echo esc_html($counter); ?></span>			
			<span class="action">
				<span><?php echo esc_html($value[2]); ?></span>
			</span>
			<span class="clear"></span>
		</a>
		<div class="clear"></div>
		<?php $index++; ?>
		<?php endif; ?>
	<?php endforeach;
	
	$value = ob_get_clean();
	
	// save to cache
	set_transient(FLATNEWS_SOCIAL_COUNT_CACHE_KEY.'-'.$block_id, $value, FLATNEWS_SOCIAL_COUNT_CACHE_TIMEOUT);
	
	echo $value;		
	die();
}
if (is_admin()) :
	add_action( 'wp_ajax_nopriv_flatnews_widget_social_counter', 'flatnews_widget_social_counter_callback' );
	add_action( 'wp_ajax_flatnews_widget_social_counter', 'flatnews_widget_social_counter_callback' );
endif;// is_admin for ajax