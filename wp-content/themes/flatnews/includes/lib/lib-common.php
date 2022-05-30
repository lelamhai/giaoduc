<?php
function flatnews_title_to_slug($title = '', $sep = '-') {
	$slug = esc_attr(sanitize_title_with_dashes($title));
	if (!$sep || strlen($sep) > 1) {
		$sep = '-';
	}
	
	if (!((ord($sep) >= ord('A') && ord($sep) <= ord('Z')) || 
		(ord($sep) >= ord('a') && ord($sep) <= ord('z')) || 
		(ord($sep) >= ord('0') && ord($sep) <= ord('9')) ||
		(ord($sep) == ord('_') || ord($sep) == ord($sep))
		)) {
		$sep = '-';
	}
	if (ord($slug[0]) >= ord('0') && ord($slug[0]) <= ord('9')) {
		$slug[0] = $sep;
	}
	for ($i = 0; $i < strlen($slug); $i++) {		
		if ((ord($slug[$i]) >= ord('A') && ord($slug[$i]) <= ord('Z')) || 
			(ord($slug[$i]) >= ord('a') && ord($slug[$i]) <= ord('z')) || 
			(ord($slug[$i]) >= ord('0') && ord($slug[$i]) <= ord('9')) ||
			(ord($slug[$i]) == ord('_') || ord($slug[$i]) == ord($sep))
			) {
			continue;
		}		
		$slug[$i] = $sep;
	}
	return $slug;
}

function flatnews_related_path($path = '') {
	
	if ($path) {
		
	}
	return $path;
}

function flatnews_site_title() {
	if (get_theme_mod('site_logo')) {
		$logo_src = get_theme_mod('site_logo');
		$logo_retina = get_theme_mod('site_logo_retina');
		
		if (wp_is_mobile() && get_theme_mod('mobile_site_logo')) {
			$logo_src = get_theme_mod('mobile_site_logo');
			$logo_retina = get_theme_mod('mobile_site_logo_retina');
		}
		
		$site_title = '<a href="'.esc_url(get_home_url()).'" title="'.esc_attr(get_bloginfo('name')).'">';
		$site_title .= '<img alt="'.esc_attr(get_bloginfo('name')).'" src="'.esc_url($logo_src).'" data-retina="'.esc_url($logo_retina).'"/>';
		$site_title .= '</a>';
	}
	else {
		$site_title = '<a href="'.esc_url(get_home_url()).'" title="'.esc_attr(get_bloginfo( 'name')).'">';
		$site_title .= get_bloginfo('name');
		$site_title .= '</a>';
	}
	
	if (!is_home() && !is_front_page()) : ?>
		<h2 class="fn-site-title"><?php echo $site_title; ?></h2>
	<?php else : ?>
		<h1 class="fn-site-title h-fn-site-title">
            <a href="<?php echo get_home_url() ?>">
                <img src="<?php the_field('h-log', 'options') ?>" alt="<?php echo get_bloginfo() ?>"> 
            </a>
        </h1>
	<?php endif;
}

function flatnews_get_image_attachment_id($image_url) {
	global $wpdb;
	$prefix = $wpdb->prefix;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $prefix . "posts" . " WHERE guid='%s';", $image_url )); 
	if ( $attachment ) {
		foreach ( $attachment as $attachment_id ) 
		{
			return $attachment_id;
		}
	}
    return NULL;
}

function flatnews_get_first_image_src_in_content($content = '', $size = 'medium') {
	$src = '';
	if (!($content)) {
		$content = get_the_content();
		if (!($content)) {
			global $post;
			if (is_object($post)) {
				if (property_exists($post, 'post_content')) {
					$content = $post->post_content;
				}
			}
		}
	}
	if ($content) {
		
		$start_image_tag = strpos($content, '<img ');
		if ($start_image_tag !== false) {
			
			// get image id first, if already in library, return match size src, 
			// else, return src only
			
			$start_class_1 = strpos($content, 'class="', $start_image_tag);
			$start_class_2 = strpos($content, 'class=\'', $start_image_tag);
			if (!($start_class_1 === false && $start_class_2 === false)) {
				
				$start_class = -1;
				if ($start_class_1 === false) {
					$start_class = $start_class_2;
				} else if ($start_class_2 === false) {
					$start_class = $start_class_1;
				} else if ($start_class_1 < $start_class_2) {
					$start_class = $start_class_1;
				} else {
					$start_class = $start_class_2;
				}
				
				if ($start_class != -1) {
					
					$offset_key = 'class="';
					$end_class_1 = strpos($content, '"', $start_class + strlen($offset_key));
					$end_class_2 = strpos($content, '\'', $start_class + strlen($offset_key));
					$end_class = -1;
					if ($end_class_1 === false) {
						$end_class = $end_class_2;
					} else if ($end_class_2 === false) {
						$end_class = $end_class_1;
					} else if ($end_class_1 < $end_class_2) {
						$end_class = $end_class_1;
					} else {
						$end_class = $end_class_2;
					}
					
					if ($end_class != -1) {
						
						$len = $end_class - ($start_class + strlen($offset_key));
						$cls = substr($content, $start_class + strlen($offset_key), $len);
						
						if ($cls && strpos($cls, 'wp-image-') !== false) {
							$cls = substr($cls, strpos($cls, 'wp-image-') + strlen('wp-image-'));
						}
						if (strpos($cls, ' ') !== false) {
							$cls = substr($cls, 0, strpos($cls, ' '));
						}
						if (strpos($cls, '\t') !== false) {
							$cls = substr($cls, 0, strpos($cls, '\t'));
						}
						
						if ($cls && is_numeric($cls)) {
							$src = wp_get_attachment_image_src((int)$cls, $size);
							if (is_array($src) && !empty($src)) {
								return $src[0];
							}
						}
					}
				}
			}
			
			
			
			$start_src_1 = strpos($content, 'src="', $start_image_tag);
			$start_src_2 = strpos($content, 'src=\'', $start_image_tag);
			if (!($start_src_1 === false && $start_src_2 === false)) {
				$start_src = -1;
				if ($start_src_1 === false) {
					$start_src = $start_src_2;
				} else if ($start_src_2 === false) {
					$start_src = $start_src_1;
				} else if ($start_src_1 < $start_src_2) {
					$start_src = $start_src_1;
				} else {
					$start_src = $start_src_2;
				}
				
				if ($start_src != -1) {
					$offset_key = 'src="';
					$end_src_1 = strpos($content, '"', $start_src + strlen($offset_key));
					$end_src_2 = strpos($content, '\'', $start_src + strlen($offset_key));
					$end_src = -1;
					if ($end_src_1 === false) {
						$end_src = $end_src_2;
					} else if ($end_src_2 === false) {
						$end_src = $end_src_1;
					} else if ($end_src_1 < $end_src_2) {
						$end_src = $end_src_1;
					} else {
						$end_src = $end_src_2;
					}
					
					if ($end_src != -1) {
						$len = $end_src - ($start_src + strlen($offset_key));
						return substr($content, $start_src + strlen($offset_key), $len);
					}
				}
			}
		}
	}
	
	return $src;
}

// https://stackoverflow.com/questions/1361149/get-img-thumbnails-from-vimeo
function flatnews_get_vimeo_image_src_in_content($content = '', $size = 'small') {	
	$src = '';
	if ( strpos( $content, 'vimeo' ) === false ) {
		return $src;
	}
	if ($size == 'thumbnail') {
		$size = 'small';
	} else if ($size == 'full') {
		$size = 'large';
	}
	
	
	if ($size && $content && function_exists('sneeit_framework')) {
		// search and get vimeo ID
		$vimeo_id = apply_filters('sneeit_get_vimeo_id', $content);
		if ($vimeo_id) {			
			$src = get_transient('vimeo_thumb-'.$vimeo_id);
			if ($src === false) {
				// load vimeo thumbnail via API
				$vimeo_thumb_xml = wp_remote_get(esc_url('https://vimeo.com/api/v2/video/'.$vimeo_id.'.php'), array( 
					'sslverify' => false, 
					'compress'    => false,
					'decompress'  => false,
					'timeout'	=> FLATNEWS_REMOTE_TIMEOUT));

				if ( !is_wp_error($vimeo_thumb_xml) ) {
					$hash = unserialize(wp_remote_retrieve_body($vimeo_thumb_xml));
					$src = $hash[0]['thumbnail_large'];	
					set_transient('vimeo_thumb-'.$vimeo_id, $src, 60*60*24*365);
					update_option('vimeo_thumb-'.$vimeo_id, $src);
				} else {
					$src = get_option('vimeo_thumb-'.$vimeo_id, '');
				}
			}
		}
	}
	
	return $src;
}


// https://stackoverflow.com/questions/2068344/how-to-get-thumbnail-of-youtube-video-link-using-youtube-api/2068371#2068371
/*
latest short format: https://youtu.be/NLqAF9hrVbY
iframe: https://www.youtube.com/embed/NLqAF9hrVbY
iframe (secure): https://www.youtube.com/embed/NLqAF9hrVbY
watch: https://www.youtube.com/watch?v=NLqAF9hrVbY
users: https://www.youtube.com/user/Scobleizer#p/u/1/1p3vcRhsYGo
ytscreeningroom: https://www.youtube.com/ytscreeningroom?v=NRHVzbJVx8I
any/thing/goes!: https://www.youtube.com/sandalsResorts#p/c/54B8C800269D7C1B/2/PPS-8DMrAn4
any/subdomain/too: https://gdata.youtube.com/feeds/api/videos/NLqAF9hrVbY
more params: https://www.youtube.com/watch?v=spDj54kf-vY&feature=g-vrec
query may have dot: https://www.youtube.com/watch?v=spDj54kf-vY&feature=youtu.be
nocookie domain: https://www.youtube-nocookie.com
 */
function flatnews_get_youtube_image_src_in_content($content = '', $size = 'thumbnail') {	
	$src = '';
	
	if ( strpos( $content, 'youtube' ) === false && strpos( $content, 'youtu.be' ) === false ) {
		return $src;
	}
	
	if ($size && $content && function_exists('sneeit_framework')) {		
		// search and get vimeo ID
		$youtube_id = apply_filters('sneeit_get_youtube_id', $content);
		if ($youtube_id) {
			$src = 'https://img.youtube.com/vi/'.$youtube_id.'/hqdefault.jpg';
		}
	}
	return $src;
}

/*
 * Get the first image of post as SRC only
 */
function flatnews_get_post_img_src($post_id = 0, $size = 'medium', $default_src = '') {
	$src = '';
	if (!$post_id) {
		$post_id = get_the_ID();
		if (!$post_id) {
			global $post;
			if (is_object($post)) {
				if (property_exists($post, 'ID')) {
					$post_id = $post->ID;
				}
			}
		}
	}
	
	if ($post_id) {
		if ( get_post_meta( $post_id, 'feature_video_url', true ) ) {
			$feature_video_url = get_post_meta( $post_id, 'feature_video_url', true );
			$src = flatnews_get_first_image_src_in_content( $feature_video_url, $size );
			
			if ( ! $src ) {
				$src = flatnews_get_vimeo_image_src_in_content( $feature_video_url, $size );
			}
			
			if ( ! $src ) {
				$src = flatnews_get_youtube_image_src_in_content( $feature_video_url, $size );
			}
		}
		if ( ! $src && has_post_thumbnail( $post_id ) ) {
			$post_thumbnail_id = get_post_thumbnail_id( $post_id );
			if ( $post_thumbnail_id ) {
				$image_attributes = wp_get_attachment_image_src( $post_thumbnail_id, $size );
				if ( is_array( $image_attributes ) && isset( $image_attributes[0] ) ) {
					$src = $image_attributes[0];
				}
			}
		}
		
		if ( ! $src ) {
			$content_post = get_post( $post_id );
			$content = $content_post->post_content;
			
			// search image in post
			$src = flatnews_get_first_image_src_in_content( $content, $size );
			if ( ! $src ) {
				$src = flatnews_get_vimeo_image_src_in_content( $content, $size );
			}
			if ( ! $src ) {
				$src = flatnews_get_youtube_image_src_in_content($content, $size);
			}
		}
	}
	
	if ( ! $src && $default_src ) {
		if ( is_string( $default_src ) ) {
			$src = $default_src;
		}
		else {
			$src = get_theme_mod( 'default_thumbnail_image' );
			if ( ! $src ) {				
				if ( 'thumbnail' == $size ) {
					$src = 'https://lorempixel.com/260/200/';
				} 
				else if ( 'medium' == $size ) {
					$src = 'https://lorempixel.com/340/300/';
				} 
				else if ( 'large' == $size ) {
					$src = 'https://lorempixel.com/700/400/';
				}
			}
		}
	}
	return $src;
}

/*in case need optimize src*/
function flatnews_get_post_image_optimize_src($attr) {
	if (isset($attr['src'])) {
		$attr['data-s'] = $attr['src'];
		$attr['src'] = '';
	}
	if (isset($attr['srcset'])) {
		$attr['data-ss'] = $attr['srcset'];
		unset($attr['srcset']);
	}		

	return $attr;
}

/*sizes: thumbnail, large, medium, full*/
function flatnews_get_post_image( $post_id = 0, $size = 'thumbnail', $attr = NULL, $default_src = '', $optimize_src = true) {
	$html = '';
	$src = '';
	
	// validate post id
	if ( ! $post_id ) {
		$post_id = get_the_ID();
		if ( ! $post_id ) {
			global $post;
			if ( is_object( $post ) ) {
				if ( property_exists( $post, 'ID' ) ) {
					$post_id = $post->ID;
				}
			}
		}
	}
	
	// validate attr
	if ( !is_array( $attr ) ) {
		$attr = array();
	}
	
	if ( $post_id ) {
		$attr['alt'] = esc_attr( get_the_title( $post_id ) );
		
	}
	$src = flatnews_get_post_img_src( $post_id, $size, $default_src );
	
	if ( $src ) {
		$src_id = flatnews_get_image_attachment_id( $src );
		if ( $src_id ) {
			if ($optimize_src) {
				add_filter('wp_get_attachment_image_attributes', 'flatnews_get_post_image_optimize_src');
			}
			
			$html = wp_get_attachment_image( $src_id, $size, false, $attr );
			
			if ($optimize_src) {
				remove_filter('wp_get_attachment_image_attributes', 'flatnews_get_post_image_optimize_src');
			}
		} 
		else {
			// maybe external image or not in library
			$html = '<img src="' . esc_url( $src ) . '"';
			foreach ( $attr as $key => $value ) {
				$html .= ' ' . $key . '="' . esc_attr( $value ) . '"';
			}
			$html .= '/>';
		}		
	}
	
	return $html;
}


/*  ----------------------------------------------------------------------------
    mbstring support
 */

if (!function_exists('mb_strlen')) {
    function mb_strlen ($string) {
        return strlen($string);
    }
}

if (!function_exists('mb_strpos')) {
    function mb_strpos($haystack,$needle,$offset=0) {
        return strpos($haystack,$needle,$offset);
    }
}
if (!function_exists('mb_strrpos')) {
    function mb_strrpos ($haystack,$needle,$offset=0) {
        return strrpos($haystack,$needle,$offset);
    }
}
if (!function_exists('mb_strtolower')) {
    function mb_strtolower($string) {
        return strtolower($string);
    }
}
if (!function_exists('mb_strtoupper')) {
    function mb_strtoupper($string){
        return strtoupper($string);
    }
}
if (!function_exists('mb_substr')) {
    function mb_substr($string,$start,$length = false) {
	    if ($length) {
		    return substr($string,$start, $length);
	    }
	    return substr($string,$start);
    }
}
if (!function_exists('mb_internal_encoding')) {
    function mb_internal_encoding($string) {
        return $string;
    }
}
if (!function_exists('mb_http_output')) {
    function mb_http_output($string) {
        return $string;
    }
}
if (!function_exists('mb_http_output')) {
    function mb_http_output($string) {
        return $string;
    }
}
if (!function_exists('mb_http_input')) {
    function mb_http_input($string) {
        return $string;
    }
}
if (!function_exists('mb_language')) {
    function mb_language($string) {
        return $string;
    }
}
if (!function_exists('mb_regex_encoding')) {
    function mb_regex_encoding($string) {
        return $string;
    }
}

function flatnews_substring($string, $start, $length = 150) {	
	mb_internal_encoding('UTF-8');
	mb_http_output('UTF-8');
	mb_http_input('UTF-8');
	mb_language('uni');
	mb_regex_encoding('UTF-8');
	
	return mb_substr($string, $start, $length);
	
}

/*Use this function inside loop
 * wrap = true mean wrap content by p tag
 * one_line = true mean remove all html tags in content
 */
function flatnews_get_the_snippet($length = 150, $hellip = true) {
	$html = '';
	global $post;
	
	if ( is_object( $post ) ) {
		if ( property_exists( $post, 'post_excerpt' ) && $post->post_excerpt ) {
			$html = $post->post_excerpt;
		} else if ( property_exists ($post, 'post_content') && $post->post_content ){
			$html = $post->post_content;
		}
	}
	
	if ( ( !$html ) && get_the_content( '', false) ) {
		$html = get_the_content( '', false );
	}
	
	if ((!$html) && get_the_excerpt()) {
		$html = get_the_excerpt();
	}
	
	if ($html) {
		$html = do_shortcode( $html );
		$html = strip_tags( $html );
		if ( strlen( $html ) > $length ) {			
			$html = flatnews_substring( $html, 0, $length );
		}
	}
	
	if ( $hellip ) {
		if ( is_string( $hellip ) ) {
			$html .= ' ' . $hellip . ' ';
		} else {
			$html .= ' ... ';
		}
	}
	
	return $html;
}
function flatnews_remove_html_slashes($content) {
	return filter_var(stripslashes($content), FILTER_SANITIZE_SPECIAL_CHARS);
}
function flatnews_safe_array_get($arr, $element, $default = '') {
	$value = $default;
	
	if (is_array($arr) && array_key_exists($element, $arr)) {
		$value = $arr[$element];
	}
	return $value;
}
function flatnews_pagenav_index($position = 'top'){
	global $wp_query;
	$current = max( 1, get_query_var('paged') );	
	$big = 999999999; // need an unlikely integer
	
	if ( 'bottom' == $position ) {
		echo '<div class="clear"></div>';
	}
	
	echo '<div class="archive-page-pagination archive-page-pagination-'.$position.'">';
	echo paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => $current,
		'total' => $wp_query->max_num_pages,
		'prev_text'    => wp_kses(__('<i class="fa fa-angle-left"></i>', 'flatnews'),array('i'=>array('class'=>array()))),
		'next_text'    => wp_kses(__('<i class="fa fa-angle-right"></i>', 'flatnews'),array('i'=>array('class'=>array())))
	) );
	
	$listed = $current * $wp_query->query_vars['posts_per_page'];
	if ($listed > $wp_query->found_posts) {
		$listed = $wp_query->found_posts;
	}
	if ( $wp_query->max_num_pages > 1 || 'bottom' == $position ) {
		echo '<span class="archive-page-pagination-info">'.	wp_kses(sprintf(__('<span class="value">%1$s</span> / %2$s POSTS', 'flatnews'), $listed, $wp_query->found_posts).'</span>', array('span'=>array('class'=>array())));
	}
	echo '<div class="clear"></div></div>';
}
function flatnews_has_form_controls($str = '') {
	if (!$str) {
		return false;
	}
	if (strpos($str, '<form') !== false) {
		return true;
	}
	if (strpos($str, '<input') !== false) {
		return true;
	}
	if (strpos($str, '<textarea') !== false) {
		return true;
	}
	if (strpos($str, '<select') !== false) {
		return true;
	}
	if (strpos($str, '<option') !== false) {
		return true;
	}
	
	return false;
}

function flatnews_get_server_request($key) {
	$value = '';
	if ($key) {
		if (isset($_GET[$key])) {
			$value = $_GET[$key];
		} else if (isset($_POST[$key])) {
			$value = $_POST[$key];
		}
	}
	return $value;
}

function flatnews_is_IE() {
	return preg_match('/(?i)msie [5-8]/',$_SERVER['HTTP_USER_AGENT']);
}

function flatnews_is_gpsi() {
	return (
		isset( $_SERVER['HTTP_USER_AGENT'] ) && 
		strpos( $_SERVER['HTTP_USER_AGENT'], 'Google Page Speed Insights') !== false
	);
}
function flatnews_get_attachment_id_from_src($src = '') {
	if (!$src) {
		return false;
	}
	
	global $wpdb;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $src )); 
	if (!$attachment || !is_array($attachment)) {
		return false;
	}
    return $attachment[0]; 	
}

function flatnews_get_attachment_from_src($src = '') {
	$attachment_id = flatnews_get_attachment_id_from_src($src); 
	
	if (!$attachment_id) {
		return false;
	}
	
	return wp_get_attachment_metadata($attachment_id);
}

function fn_display_sidebar($sidebar_id = '') {
	if (!$sidebar_id) {
		return;
	}
	$prefix = '';
	$sidebar = '';
	$layout = '';
	$sticky = false;
	
	// if user set sidebar on post
	// we must priority use that sidebar
	if ( is_singular() ) {
		$sidebar = get_post_meta(get_the_ID(), 'singular-'.$sidebar_id, true);
		if ('disable' == $sidebar) {			
			return;
		}
	}

	// but if they leave it as default
	// we will get from global options
	if (!$sidebar) {	
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
			$sidebar = get_theme_mod($prefix.'-'.$sidebar_id, $sidebar_id);
		}		
	}	

	// if did not set, just use the default
	if ( !$sidebar ) {
		$sidebar = $sidebar_id;
	}
	
	
	
	// get layout and sticky for MAIN SIDEBAR
	if ('fn-main-sidebar' == $sidebar_id) {
		// SIDEBAR LAYOUT
		// check if users set a specific sidebar layout 
		// then we must use the thing they set
		if ( is_singular() ) {
			$layout = get_post_meta(get_the_ID(), 'singular-sidebar-layout', true);			
		}
		
		// if they leave as default
		// we need to check global options
		if (!$layout && $prefix) {
			$layout = get_theme_mod($prefix.'-sidebar-layout', '');
		}
		// if global option is disable
		if ('full' == $layout) {			
			return;
		}

		// SIDEBAR STICKY
		if ($prefix) {
			$sticky = get_theme_mod($prefix.'-sidebar-sticky', false);
		}		
	}
	
	
	if ( ! function_exists( 'sneeit_framework' ) && is_active_sidebar( $sidebar ) ) {	
		dynamic_sidebar( $sidebar );	
	} 
	else {
		do_action( 'sneeit_display_sidebar', array(
			'id'    => $sidebar,
			'class' => $sidebar_id . ' fn-sidebar' . ($sticky?' fn-sticky-col':''),
		) );
	}
}

