<?php

function flatnews_widget_social_counter( $args, $instance, $widget_id, $widget_declaration) {
	flatnews_widget_common_header('fn-widget-social-counter', $instance, $args);	
	
	// get from cache first	
	$cache = get_transient(FLATNEWS_SOCIAL_COUNT_CACHE_KEY.'-'.$args['widget_id']);	
	
	if ($cache && !current_user_can('manage_options')) :		
		echo $cache;	
	else:			
	?>
	<div class="data hide">
		<?php foreach ( $instance as $name => $url ) :
			if (strpos($name, '_url') === false) {
				continue;
			}
			
			if ($url) : ?>
				<span class="value" data-key="<?php echo esc_attr(str_replace('_url', '', $name)); ?>" data-url="<?php echo esc_attr($url); ?>"></span>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<div class="loader"><i class="fa fa-4x fa-spin fa-spinner"></i></div>
	<?php
	endif;
	
	flatnews_widget_common_footer();
}