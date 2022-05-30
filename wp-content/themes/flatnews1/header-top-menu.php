<?php 
if ( has_nav_menu( 'top-menu' ) ) : ?>
<div class="fn-top-menu-wrapper">
<?php
	wp_nav_menu( array(
		'theme_location' => 'top-menu',
		'container_class' => 'fn-top-menu',
		'container' => 'nav',
	));
	?>	
</div>	
<?php
endif;	
	
	