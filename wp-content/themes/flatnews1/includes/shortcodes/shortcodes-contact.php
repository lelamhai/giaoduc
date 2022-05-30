<?php
function flatnews_shortcode_contact_display( $atts = array(), $content = "" ) {	
	return 
		'<div class="flatnews-contact-form shad white">'.
			apply_filters('sneeit_contact_form', array(
				'target_email' => $atts['target_email'],
				'enable_name' => true,
				'enable_url' => $atts['enable_url'],
				'class_submit' => 'bg shad',
				'id_form' => 'flatnews-simple-contact-form',
				'id_submit' => 'flatnews-simple-contact-form-submit',
				'label_name' => esc_html__('Name:', 'flatnews'),
				'label_email' => esc_html__('Email:', 'flatnews'),
				'label_url' => esc_html__('Website:', 'flatnews'),
				'label_content' => esc_html__('Content:', 'flatnews'),
				'label_submit' => esc_html__('Send Content', 'flatnews'),
				'message_successful' => esc_html__('We received your contact. Thank you!', 'flatnews'),
				'message_required_email' => esc_html__('The email is requried', 'flatnews'),
				'message_required_content' => esc_html__('The content is requried', 'flatnews'),
				'message_short_content' => esc_html__('Your content is too short to submit', 'flatnews'),				
			)).	
		'<div class="clear"></div></div>';	
}