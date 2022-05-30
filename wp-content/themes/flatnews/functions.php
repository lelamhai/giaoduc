<?php
/*DEFINES*/
/*common*/
define('FLATNEWS_THEME_VERSION', '5.5');
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