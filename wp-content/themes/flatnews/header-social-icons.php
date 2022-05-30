<?php 
$social_links = get_theme_mod('social_links');
if ($social_links) :
	?>	
		<?php $social_links = apply_filters('sneeit_social_links_to_fontawesome', array(
			'urls' => $social_links,
			'before' => '<div class="fn-header-social-links">',
			'after' => '</div>'
		)); 
		
		if (!empty($social_links) && is_string($social_links)) {
			echo $social_links;
		}
		?>	
	<?php
endif;