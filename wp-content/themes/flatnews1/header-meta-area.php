<div class="fn-header-btn">	
	<?php 	
	get_header('woocommerce');
	?>
	
	<?php if (!get_theme_mod('disable_header_search')): ?>
	<a class="fn-header-btn-search" href="javascript:void(0)"><?php esc_html_e('Search', 'flatnews'); ?> <i class="fa fa-search"></i></a>				
	<?php endif; ?>
	
</div>
<?php if (!get_theme_mod('disable_header_search')): ?>
<div class="fn-header-search-box">
	<?php get_search_form(); ?>
</div>
<?php endif; ?>
<div class="fn-header-social-links">
	<?php
	get_header('social-icons');
	?>
</div>				
<div class="clear"></div>