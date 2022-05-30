<?php
global $Fn_Primary_Width;
global $Fn_Content_Width;

$Fn_Primary_Width = 
	get_theme_mod('content_width', 730) + 
	get_theme_mod('content_sidebar_gap', 40) +
	get_theme_mod('sidebar_width', 300);

$fn_prim_pad = get_theme_mod('primary_padding', '0px 30px 30px 30px');
$fn_prim_pad = explode(' ', $fn_prim_pad);
$fn_prim_pad_right = intval($fn_prim_pad[1]);
$fn_prim_pad_left = intval($fn_prim_pad[3]);

$Fn_Content_Width = $Fn_Primary_Width + $fn_prim_pad_right + $fn_prim_pad_left;


if ( ! isset( $content_width ) ) {
	$content_width = $Fn_Content_Width;
}

add_action( 'after_setup_theme', 'flatnews_theme_basic_setup' );
function flatnews_theme_basic_setup() {	
	add_theme_support( 'woocommerce' );
	
	// https://codex.wordpress.org/Function_Reference/load_theme_textdomain
	load_theme_textdomain( 'flatnews', get_template_directory() . '/languages' );

	// https://codex.wordpress.org/Function_Reference/add_editor_style
	add_editor_style( FLATNEWS_THEME_URL_CSS . 'editor.css' );
	
//	add_theme_support( 'woocommerce' );
	
	// https://codex.wordpress.org/Function_Reference/add_theme_support
	// https://codex.wordpress.org/Post_Formats
	add_theme_support( 'post-formats', array(/*'aside','gallery', 'link',*/ 'image', /*'quote', 'status',*/ 'video', 'audio',/* 'chat'*/));
	
	add_theme_support( 'title-tag' );
	
	// https://codex.wordpress.org/Post_Thumbnails
	// https://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
	// https://codex.wordpress.org/Function_Reference/add_image_size
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 9999 );	
		
	
	add_image_size( 'large', 650, 9999 ); 
	add_image_size( 'medium', 400, 9999 );
	add_image_size( 'thumbnail', 250, 9999 );
	
	// Serve scaled images
	add_image_size( 'scale-050', 50, 9999 );
	add_image_size( 'scale-100', 100, 9999 );
	add_image_size( 'scale-150', 150, 9999 );
	add_image_size( 'scale-200', 200, 9999 );
	add_image_size( 'scale-300', 300, 9999 );
	add_image_size( 'scale-350', 350, 9999 );
	add_image_size( 'scale-450', 450, 9999 );
	add_image_size( 'scale-500', 500, 9999 );
	add_image_size( 'scale-550', 550, 9999 );
	
		
	// retina if have
	add_image_size( 'retina2x', 800, 9999 );
	add_image_size( 'retina3x', 1200, 9999 );
	add_image_size( 'retina4x', 1600, 9999 );
	add_image_size( 'retina5x', 2000, 9999 );
	add_image_size( 'retina6x', 2400, 9999 );
	
	add_theme_support( 'automatic-feed-links' );
}

// for performance since 2.9
/*
add_filter( 'script_loader_src', 'flatnews_remove_query_strings', 15, 1 );
add_filter( 'style_loader_src', 'flatnews_remove_query_strings', 15, 1 );
function flatnews_remove_query_strings( $src ){
	$parts = explode( '?', $src );
	return $parts[0];
}
*/
function flatnews_enqueue_url($file = '') {
	$id = explode('.', $file);
	$id = $id[0];
	
	$rtl = (is_rtl()? 'rtl-' : '');
	$rtl_ = ($rtl ? 'rtl/' : '');
	$min = FLATNEWS_IS_LOCALHOST ? '' : '.min';
	$min_ = ($min ? 'min/' : '');
	
	/* enqueue css*/	
	if (strpos($file, '.css')) {
		return FLATNEWS_THEME_URL_CSS.$min_.$rtl_.$rtl.$id.$min.'.css';
	}
	/* enqueue js */
	return FLATNEWS_THEME_URL_JS.$min_.$rtl_.$rtl.$id.$min.'.js';
}

add_action( 'wp_enqueue_scripts', 'flatnews_enqueue_scripts_styles' );
function flatnews_enqueue_scripts_styles() {
	$header_layout = get_theme_mod('header_layout');
		
	// enqueue style
	wp_enqueue_style( 'flatnews-main', flatnews_enqueue_url('main.css'), array(), FLATNEWS_THEME_VERSION );
	$inline_style = '';
	
	global $Fn_Primary_Width;
	global $Fn_Content_Width;
	
	$content_width = (int) get_theme_mod('content_width', 730);
	$sidebar_width = (int) get_theme_mod('sidebar_width', 300);
	
	$inline_style .= '.fn-primary{width:'.$Fn_Primary_Width.'px}';
	$inline_style .= '.fn-content{width:'.($content_width * 100 / $Fn_Primary_Width).'%}';
	$inline_style .= '.fn-main-sidebar{width:'.($sidebar_width * 100 / $Fn_Primary_Width).'%}';
		
	if (!get_theme_mod('header_row_inner_full_width', false)) {
		$inline_style .= '.fn-header, .fn-header-row-inner{width:'.$Fn_Content_Width.'px}';	
	}
	
	if (!get_theme_mod('footer_row_inner_full_width', false)) {
		$inline_style .= '.fn-footer, .fn-footer-row-inner{width:'.$Fn_Content_Width.'px}';				
	}
		
	if ( ! get_theme_mod('disable_responsive') ) {
		wp_enqueue_style( 
			'flatnews-responsive', 
			flatnews_enqueue_url('responsive.css'), 
			array(), 
			FLATNEWS_THEME_VERSION,
			'(max-width: '.($Fn_Content_Width-1).'px)'
		);
		$inline_style .= '*{max-width: 100%;}img{height: auto;}';
	}
	if ($inline_style) {
		wp_add_inline_style('flatnews-main', $inline_style);
	}		
	
	
	wp_enqueue_style( 'flatnews-ie-8', flatnews_enqueue_url('ie-8.css'), array(), FLATNEWS_THEME_VERSION );
	wp_style_add_data( 'flatnews-ie-8', 'conditional', 'lt IE 8' );
	wp_enqueue_style( 'flatnews-ie-9', flatnews_enqueue_url('ie-9.css'), array(), FLATNEWS_THEME_VERSION );
	wp_style_add_data( 'flatnews-ie-9', 'conditional', 'lt IE 9' );
	
	
	// woo commerce custom styles
	if ( function_exists('is_woocommerce') && is_woocommerce() ) {
		wp_enqueue_style( 'flatnews-woocommerce', flatnews_enqueue_url('woocommerce.css'), array(), FLATNEWS_THEME_VERSION );					

		// static style for woocommerce
		$main_color = get_theme_mod( 'main_color' );
		wp_add_inline_style('flatnews-woocommerce', '
			.woo-mini-cart-very-right {
				border-top-color: ' . $main_color . '!important;
			}
			.widget.woocommerce.widget_shopping_cart .buttons .button.checkout,
			.widget.woocommerce.widget_price_filter .ui-slider .ui-slider-handle,
			.widget.woocommerce.widget_price_filter .ui-slider .ui-slider-range,
			.woocommerce-product-search input[type="submit"],
			.woocommerce span.onsale,
			.woocommerce .button.single_add_to_cart_button,
			.woocommerce .button.checkout,
			.woocommerce .button.checkout-button,
			.woocommerce table.shop_table input[name="update_cart"],
			.woocommerce #payment #place_order, .woocommerce-page #payment #place_order,
			.woocommerce #review_form #respond .form-submit input {
				background-color: ' . $main_color . '!important;
			}
			.woocommerce ul.products li.product > a.add_to_cart_button,
			.woocommerce-page ul.products li.product > a.add_to_cart_button,
			.woocommerce .woocommerce-breadcrumb a {
				color: ' . $main_color . '!important;
			}
			.widget.woocommerce.widget_price_filter .price_slider_wrapper .ui-widget-content {
				border-color: ' . $main_color . '!important;
			}
		');
	}
		
		
	// inline style			
	wp_enqueue_script(
		'flatnews-main', 
		flatnews_enqueue_url('main.js'), 
		array(
			'jquery', 
			'jquery-effects-slide'			
		), 
		FLATNEWS_THEME_VERSION,
		true
	);
	add_thickbox();
	if ( is_singular() ) {
		wp_enqueue_script( "comment-reply" );
	}
	
	$localize = array(
		'text' => array(			
			'Copy All Code'  => esc_html__('Copy All Code', 'flatnews'), 
			'Select All Code' => esc_html__('Select All Code', 'flatnews'), 
			'All codes were copied to your clipboard' => esc_html__('All codes were copied to your clipboard', 'flatnews'), 
			'Can not copy the codes / texts, please press [CTRL]+[C] (or CMD+C with Mac) to copy' => esc_html__('Can not copy the codes / texts, please press [CTRL]+[C] (or CMD+C with Mac) to copy', 'flatnews'),			
			'THIS PREMIUM CONTENT IS LOCKED' => esc_html__('THIS PREMIUM CONTENT IS LOCKED', 'flatnews'),
			'STEP 1: Share to a social network' => esc_html__('STEP 1: Share to a social network', 'flatnews'),
			'STEP 2: Click the link on your social network' => esc_html__('STEP 2: Click the link on your social network', 'flatnews'),
			
		),
		'ajax_url' => admin_url('admin-ajax.php'),
		'is_rtl' => is_rtl(),
		'is_gpsi' => flatnews_is_gpsi(),
		'facebook_app_id' => get_theme_mod('facebook_comment_app_id'),
		'disqus_short_name' => get_theme_mod('disqus_short_name'),
		'primary_comment_system' => get_theme_mod('primary_comment_system'),
		'locale' => get_locale(),
	);
	
	wp_localize_script( 'flatnews-main', 'flatnews', $localize);
}

if ( flatnews_is_gpsi() ) {	
	remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
	add_action( 'wp_footer', 'wp_enqueue_scripts' );
}

add_action( 'admin_enqueue_scripts', 'flatnews_setup_basic_admin_enqueue_scripts', 10, 1);
function flatnews_setup_basic_admin_enqueue_scripts($hook) {
	if ('post.php' != $hook && 'post-new.php' != $hook) {
		return;
	}
	
	wp_enqueue_style( 'flatnews-editor', FLATNEWS_THEME_URL_CSS . '/editor.css', array(), FLATNEWS_THEME_VERSION );
}

add_action("login_head", "flatnews_login_logo");
function flatnews_login_logo() {
	if (get_theme_mod('site_logo')) {
		wp_enqueue_script('flatnews-login', FLATNEWS_THEME_URL_JS . 'login.js', array('jquery'), FLATNEWS_THEME_VERSION, true);
		wp_localize_script( 'flatnews-login', 'flatnews_login_js', array(
			'home_url' => get_home_url(),
			'blog_logo_src' => get_theme_mod('site_logo')
		) );
	}	
}
function flatnews_setup_basic_body_class($classes){
	
	// SIDEBAR LAYOUT
	// check if users set a specific sidebar layout 
	// then we must use the thing they set
	$sidebar_layout = '';
	if ( is_singular() ) {
		$sidebar_layout = get_post_meta(get_the_ID(), 'singular-sidebar-layout', true);			
	}

	// if they leave as default
	// we need to check global options
	if (!$sidebar_layout) {
		$prefix = '';
		// in case this is not item page or item sidebar layout is default
		if (function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
			if ( is_shop() ){
				// always check just in case this is not item or item sidebar name is default
				$prefix = 'shop';
			}	
			elseif ( is_product() ) {
				$prefix = 'product';
			}
			else {
				$prefix = 'archive-product';
			}
		}
		// or process with normal pages
		else {
			if ( is_home() || is_front_page() ) {
				$prefix = 'home';
			} 
			elseif ( is_page() ) {
				$prefix = 'page';
			} 
			elseif ( is_single() ) {
				$prefix = 'single';
			}
			else {
				$prefix = 'archive';
			}
		}
		if ($prefix) {
			$sidebar_layout = get_theme_mod($prefix.'-sidebar-layout', '');
		}
		
	}
	
	// if did not set, just use the default
	if ( ! $sidebar_layout ) {
		$sidebar_layout = 'right';
	}

	$classes[] = 'sidebar-' . $sidebar_layout;
	
	// add solid class if wrapper background == box background (white)
	$wrapper_background_color = get_theme_mod('wrapper_background_color');
	if ($wrapper_background_color) {
		$wrapper_background_color = strtolower($wrapper_background_color);
		if ($wrapper_background_color == '#ffffff' ||
			$wrapper_background_color == '#fff' ||
			$wrapper_background_color == 'white') {
			$classes[] = 'solid-wrapper';
		}
	}
	
	$main_menu_background_color = get_theme_mod('main_menu_background_color');
	if ($main_menu_background_color) {
		$main_menu_background_color = strtolower($main_menu_background_color);
		if ($main_menu_background_color == '#ffffff' ||
			$main_menu_background_color == '#fff' ||
			$main_menu_background_color == 'white') {
			$classes[] = 'solid-menu';
		}
	}
	
	$header_full_width = get_theme_mod('header_full_width');
	if ($header_full_width) {
		$classes[] = 'full-width-header';
	}
		
	// FLATNEWS STARTED HERE
	// block header layout
	$classes[] = 'fn-bh-'.get_theme_mod('block_header_layout', 'text-bg-bot-border');
		
	return $classes;
}
add_filter('body_class', 'flatnews_setup_basic_body_class', 10, 1);

function flatnews_post_classes( $classes, $class, $post_id ) {
    if (is_single() || is_page()) {
        $classes[] = 'post';
		$classes[] = 'hentry';		
    }
 
    return $classes;
}
add_filter( 'post_class', 'flatnews_post_classes', 10, 3 );

do_action('sneeit_support_font_awesome');
do_action('sneeit_support_thread_comments');
do_action('sneeit_support_ie_html5');
do_action('sneeit_support_view_counter');
do_action('sneeit_optimize_images');
do_action('sneeit_sticky_columns', '.fn-sticky-col');

if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function flatnews_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
	}
	add_action( 'wp_head', 'flatnews_render_title' );
}


global $primary_comment_system;
$primary_comment_system = get_theme_mod('primary_comment_system');

add_filter( 'get_comments_number', 'flatnews_get_comments_number', 1, 2 );
function flatnews_get_comments_number($count, $post_id) {
	global $primary_comment_system;	
	$comment_number = get_post_meta($post_id, $primary_comment_system.'_comment_count', true);
	
	if ( is_numeric( $comment_number ) ) {
		return ( (double) $comment_number );
	}

	return $count;
}




add_filter( 'mce_buttons_2', 'flatnews_setup_basic_mce_buttons_2', 10, 1);
function flatnews_setup_basic_mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'fontselect' ); // Add Font Select
	array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
	return $buttons;
}



add_action( 'admin_enqueue_scripts', 'flatnews_admin_enqueue_scripts');
function flatnews_admin_enqueue_scripts() {
	wp_enqueue_style( 'flatnews-style', FLATNEWS_THEME_URL_CSS . 'admin.css', array(), FLATNEWS_THEME_VERSION );
}


add_action('wp_head', 'flatnews_wp_head');
function flatnews_wp_head() {
	if ( get_theme_mod( 'head_html' ) ) {
		echo get_theme_mod('head_html');
	}
	if ( get_theme_mod( 'head_css' ) ) {
		echo '<styl'.'e type="t'.'ext/c'.'ss">'.get_theme_mod('head_css').'</st'.'yle>';
	}
	if ( get_theme_mod( 'head_js' ) ) {
		echo '<sc'.'ript type="te'.'xt/jav'.'a'.'scr'.'ipt">'.get_theme_mod('head_js').'</s'.'cript>';
	}
	
	if ( get_theme_mod( 'main_color' ) ) {
		echo '<meta name="theme-color" content="' . get_theme_mod( 'main_color' ) . '" />';
	}
	
}

add_action('wp_footer', 'flatnews_wp_footer');
function flatnews_wp_footer() {
	if ( get_theme_mod('footer_html') ) {
		echo get_theme_mod('footer_html');
	}
	if ( get_theme_mod('footer_css') ) {
		echo '<st'.'yle type="text/cs'.'s">'.get_theme_mod('footer_css').'</st'.'yle>';
	}
	if ( get_theme_mod('footer_js') ) {
		echo '<scr'.'ipt type="text/jav'.'ascr'.'ipt">'.get_theme_mod('footer_js').'</sc'.'ript>';
	}	
}

if ( ! get_theme_mod('disable_responsive') ) {
	do_action('sneeit_setup_responsive', array(
		'logo' => get_theme_mod('mobile_site_logo'),
		'logo_retina' => get_theme_mod('mobile_site_logo_retina'),		
		'left_content' => '<div class="fn-mob-menu-box"></div><div class="clear"></div>', 
		'right_content' => (get_theme_mod('disable_header_search', false)? '' : '[clone:.fn-header-search-box .fn-search-form]<div class="clear"></div>'),
		'sticky_enable' => get_theme_mod('mobile_header_sticky', 'up'),
		'header_content_class' => 'fn-mob-header',
		'left_content_class' => 'fn-mob-under', 
		'right_content_class' => 'fn-mob-above', 
		'logo_class' => 'fn-mob-logo', 
		'left_icon_class' => 'fn-mob-tgl',
		'right_icon_class' => 'fn-mob-tgl',
		'right_icon' => (get_theme_mod('disable_header_search', false)? '' : 'fa-search' )
	));
}