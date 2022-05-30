<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">	
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php esc_url(bloginfo( 'pingback_url' )); ?>">
	<?php wp_head();?>
</head>


<body <?php body_class(); ?>>
<?php

$header_layout = get_theme_mod('header_layout');
if (!$header_layout) {
	$header_layout = 'default';
}


?>
<header class="fn-header fn-header-layout-<?php echo esc_attr($header_layout); ?>
<?php
if (get_theme_mod('header_wrapper_full_width')) {
	echo ' fn-header-full-width';
}
if (get_theme_mod('header_row_full_width')) {
	echo ' fn-header-row-inner-full-width';
}
?>
">
	<?php fn_display_sidebar('fn-before-header-sidebar'); ?>
	<?php get_header('layout-'.$header_layout); ?>
	<div class="clear"></div>
	<?php fn_display_sidebar('fn-after-header-sidebar'); ?>	
</header>

<?php

if ( ! get_theme_mod('disable_responsive') ) {
	do_action('sneeit_display_responsive');
}
?>

<section class="fn-primary">	
	
	<?php $fn_mobile_header_ads_code = get_theme_mod('mobile_header_ads_code', '');
	if (wp_is_mobile() && $fn_mobile_header_ads_code) : ?>	
		<div class="fn-header-banner fn-header-banner-mobile mobile">
			<?php echo do_shortcode($fn_mobile_header_ads_code); ?>
		</div>
	<?php endif; ?>
	<main class="fn-content">
		<?php fn_display_sidebar('fn-before-content-sidebar'); ?>