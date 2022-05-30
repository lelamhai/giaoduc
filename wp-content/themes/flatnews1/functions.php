<?php
/*DEFINES*/
/*common*/
define('FLATNEWS_THEME_VERSION', '6.8');
define('FLATNEWS_REQUIRED_SNEEIT_PLUGIN_VERSION', '8.1');
define('FLATNEWS_REQUIRED_ENVATO_PLUGIN_VERSION', '2.0.1');
define('FLATNEWS_IS_LOCALHOST', apply_filters('sneeit_is_localhost', false));

/*URL URI*/
define('FLATNEWS_THEME_URL',			get_template_directory_uri());
define('FLATNEWS_THEME_URL_CSS',		FLATNEWS_THEME_URL . '/assets/css/');
define('FLATNEWS_THEME_URL_IMAGES',		FLATNEWS_THEME_URL . '/assets/images/');
define('FLATNEWS_THEME_URL_JS',			FLATNEWS_THEME_URL . '/assets/js/');
define('FLATNEWS_THEME_URL_PLUGINS',	FLATNEWS_THEME_URL . '/assets/plugins/');
define('FLATNEWS_THEME_URL_LANGUAGES',	FLATNEWS_THEME_URL . '/languages/');

/*absolute path*/
define('FLATNEWS_THEME_PATH', get_template_directory());
define('FLATNEWS_THEME_PATH_INCLUDES',	FLATNEWS_THEME_PATH			. '/includes/');
define('FLATNEWS_THEME_PATH_DEFINES',		FLATNEWS_THEME_PATH_INCLUDES	. 'defines/');
define('FLATNEWS_THEME_PATH_LIB',			FLATNEWS_THEME_PATH_INCLUDES	. 'lib/');
define('FLATNEWS_THEME_PATH_BLOCKS',		FLATNEWS_THEME_PATH_INCLUDES	. 'blocks/');
define('FLATNEWS_THEME_PATH_SETUP',		FLATNEWS_THEME_PATH_INCLUDES	. 'setup/');
define('FLATNEWS_THEME_PATH_AJAX',		FLATNEWS_THEME_PATH_INCLUDES	. 'ajax/');
define('FLATNEWS_THEME_PATH_SHORTCODES',	FLATNEWS_THEME_PATH_INCLUDES	. 'shortcodes/');
define('FLATNEWS_THEME_PATH_WIDGETS',		FLATNEWS_THEME_PATH_INCLUDES	. 'widgets/');
define('FLATNEWS_THEME_PATH_INCLUDABLES',	FLATNEWS_THEME_PATH_INCLUDES	. 'includables/');

/*related part*/
define('FLATNEWS_THEME_PART_INCLUDES',	'/includes/');
define('FLATNEWS_THEME_PART_DEFINES',	FLATNEWS_THEME_PART_INCLUDES . 'defines/');
define('FLATNEWS_THEME_PART_LIB',		FLATNEWS_THEME_PART_INCLUDES . 'lib/');
define('FLATNEWS_THEME_PART_SETUP',		FLATNEWS_THEME_PART_INCLUDES . 'setup/');
define('FLATNEWS_THEME_PART_AJAX',		FLATNEWS_THEME_PART_INCLUDES . 'ajax/');
define('FLATNEWS_THEME_PART_SHORTCODES',	FLATNEWS_THEME_PART_INCLUDES . 'shortcodes/');
define('FLATNEWS_THEME_PART_WIDGETS',	FLATNEWS_THEME_PART_INCLUDES . 'widgets/');
define('FLATNEWS_THEME_PART_INCLUDABLES',	FLATNEWS_THEME_PART_INCLUDES . 'includables/');

/*INCLUDE*/
require_once FLATNEWS_THEME_PATH_DEFINES		. 'define-init.php';
require_once FLATNEWS_THEME_PATH_LIB			. 'lib-init.php';
require_once FLATNEWS_THEME_PATH_BLOCKS		. 'blocks-init.php';
require_once FLATNEWS_THEME_PATH_SETUP		. 'setup-init.php';
require_once FLATNEWS_THEME_PATH_AJAX			. 'ajax-init.php';
require_once FLATNEWS_THEME_PATH_SHORTCODES	. 'shortcodes-init.php';
require_once FLATNEWS_THEME_PATH_WIDGETS		. 'widgets-init.php';


function agency_regsiter_styles()
{
    // ------------------- css ----------------- \\
    // style css
    wp_enqueue_style('agency-slick', get_template_directory_uri() . "/OwlCarousel/owl.carousel.css", array(), FLATNEWS_THEME_VERSION);
    // ------------------- script ----------------- \\
    // wp_enqueue_script('agency-slick', get_template_directory_uri() . "/assets/slick/slick.js", array(), FLATNEWS_THEME_VERSION, true);
}
add_action('wp_enqueue_scripts', 'agency_regsiter_styles');

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array('page_title'=>'Home Config','menu_title'=>'Home Config','menu_slug'=>'acf-options-theme-options'));
}