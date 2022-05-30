<?php
add_action( 'after_setup_theme', 'flatnews_child_lang_setup' );
function flatnews_child_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'flatnews', $lang );
}


