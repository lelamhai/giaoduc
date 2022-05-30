		<?php fn_display_sidebar('fn-after-content-sidebar'); ?>
	
	</main>
	<?php get_sidebar(); ?>

</section>


<footer class="fn-footer<?php
if (get_theme_mod('footer_wrapper_full_width')) {
	echo ' fn-footer-full-width';
}
if (get_theme_mod('header_row_full_width')) {
	echo ' fn-footer-row-inner-full-width';
}
?>">
	<div class="fn-footter-row fn-footer-row-sidebar-before">
		<div class="fn-footer-row-inner">
			<?php fn_display_sidebar('fn-before-footer-sidebar'); ?>
		</div>		
	</div>
	
	<div class="fn-footter-row fn-footer-row-menu">
		<div class="fn-footer-row-inner">
			<?php 
			if (has_nav_menu( 'footer-menu' )) {
				echo '<div class="fn-footer-menu-wrapper">';
				wp_nav_menu(array(
					'theme_location' => 'footer-menu'
				));
				echo '<div class="clear"></div></div>';
			}				
			?>			
		</div>		
	</div>
	
	<div class="fn-footter-row fn-footer-row-widgets">
		<div class="fn-footer-row-inner">
			<div class="fn-footer-col fn-footer-col-0">
				<div class="fn-footer-col-inner">
					<?php fn_display_sidebar('fn-footer-sidebar-0'); ?>
				</div>
			</div>
			<div class="fn-footer-col fn-footer-col-1">
				<div class="fn-footer-col-inner">
					<?php fn_display_sidebar('fn-footer-sidebar-1'); ?>
				</div>
			</div>
			<div class="fn-footer-col fn-footer-col-2">
				<div class="fn-footer-col-inner">
					<?php fn_display_sidebar('fn-footer-sidebar-2'); ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>		
	</div>

	<div class="fn-footter-row fn-footer-row-branding">
		<div class="fn-footer-row-inner">
			<div class="fn-footer-col fn-footer-col-0">
				<div class="fn-footer-col-inner">					
					<?php
					$footer_logo = get_theme_mod('footer_logo_image');
					if (!empty($footer_logo)) {
						echo '<a class="fn-footer-logo-img" href="'.home_url().'"><img src="'.esc_attr($footer_logo).'" alt="'.esc_attr(get_bloginfo('name')).'"/></a>';
					}
					$footer_social_links = get_theme_mod('footer_social_links');
					if (!empty($footer_social_links)) {						
						$footer_social_links = apply_filters('sneeit_social_links_to_fontawesome', array(
							'urls' => $footer_social_links,
							'before' => '<div class="fn-footer-social-links">',
							'after' => '</div>'
						));					
						
						if (!empty($footer_social_links) && is_string($footer_social_links)) {
							echo $footer_social_links;
						}
					}
					?>
					
				</div>
			</div>
			
			<div class="fn-footer-col fn-footer-col-1">
				<div class="fn-footer-col-inner">					
					<?php
										
					$footer_message = get_theme_mod('footer_message'); 					
					if (!empty($footer_message)) {
						echo '<div class="fn-footer-message">'.do_shortcode($footer_message).'</div>';
					}
					?>					
				</div>
			</div>
			
			<div class="fn-footer-col fn-footer-col-2">
				<div class="fn-footer-col-inner">
					<?php 
					$footer_search_replacer = get_theme_mod('footer_search_replacer');					
					if (empty($footer_search_replacer)) {
						$footer_search_title = get_theme_mod('footer_search_title');
						if (!empty($footer_search_title))  {
							echo '<span class="fn-footer-search-title">'.$footer_search_title.'</span>';
						}
						echo '<div class="fn-footer-search">';
						get_search_form();
						echo '</div>';
					} else {
						echo $footer_search_replacer;
					}
					?>					
				</div>
			</div>
				
			<div class="clear"></div>			
		</div>		
	</div>
	
	<div class="fn-footter-row fn-footer-row-copyright">
		<div class="fn-footer-row-inner">
			<?php 
			$footer_copyright_text = get_theme_mod('footer_copyright_text');			
			if ($footer_copyright_text) {
				echo '<div class="fn-footer-copyright">'.$footer_copyright_text.'</div>';
			}
			
			if (has_nav_menu( 'copyright-menu' )) {
				echo '<div class="fn-copyright-menu-wrapper">';
				wp_nav_menu(array(
					'theme_location' => 'copyright-menu'
				));
				echo '</div>';
			}			
			?>
			
			<div class="clear"></div>
		</div>		
	</div>
	
	<div class="fn-footter-row fn-footer-row-sidebar-after">
		<div class="fn-footer-row-inner">
			<?php fn_display_sidebar('fn-after-footer-sidebar'); ?>
		</div>		
	</div>
</footer>


<?php 
if (!get_theme_mod('disable_scroll_up', false) && function_exists('sneeit_framework')): 
	?><a class='scroll-up'><i class='fa fa-angle-up'></i></a><?php 
endif; 

?>


<?php wp_footer(); ?>

<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
  <script src="<?php echo get_bloginfo("template_directory"); ?>/OwlCarousel/owl.carousel.js"></script>
</body></html>