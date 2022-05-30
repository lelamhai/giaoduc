<div class="fn-header-row fn-header-row-break"><div class="fn-header-row-inner">
	<?php get_header('breaking-news'); ?>
	<div class="clear"></div>
</div></div><!--.fn-header-row-4-->

<div class="fn-header-row fn-header-row-logo h-fn-header-row-logo">
	<img src="<?php the_field('h-banner', 'options') ?>"> 
	<div class="fn-header-row-inner h-fn-header-row-inner">
		<?php
		flatnews_site_title();
		
		$fn_header_ads_code = get_theme_mod('header_ads_code', '');	
		?>
		<?php if ($fn_header_ads_code) : ?>
			<div class="fn-header-banner fn-header-banner-desktop">
				<?php echo do_shortcode($fn_header_ads_code); ?>
			</div>
		<?php endif; ?>
		
		<div class="clear"></div>
	</div>
</div><!--.fn-header-row-2-->

<div class="fn-header-row fn-header-row-main-menu"><div class="fn-header-row-inner">
	<?php do_action('sneeit_display_compact_menu', 'main-menu'); ?>
	<div class="clear"></div>
</div></div><!--.fn-header-row-3-->