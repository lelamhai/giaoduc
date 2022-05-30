<?php
function flatnews_save_comment_count_callback() {	
	$id = flatnews_get_server_request('id');
	$count = flatnews_get_server_request('count');
	$system = flatnews_get_server_request('system');
	
	echo '['.$id.']['.$count.']['.$system.']';
	update_post_meta((int) $id, $system.'_comment_count', $count);
	echo get_post_meta($id, $system.'_comment_count', true);
	
	die();
}
if (is_admin()) :
	add_action( 'wp_ajax_nopriv_flatnews_save_comment_count', 'flatnews_save_comment_count_callback' );
	add_action( 'wp_ajax_flatnews_save_comment_count', 'flatnews_save_comment_count_callback' );
endif;// is_admin for ajax