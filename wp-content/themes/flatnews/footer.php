		<?php fn_display_sidebar('fn-after-content-sidebar'); ?>
	
	
	</main>
	<!-- <?php get_sidebar(); ?> -->
	<div class="wrap-sidebar1 fn-main-sidebar fn-block">

	<?php 
		$rows = get_field('h-sidebar1','options');
		if( $rows ) {
			foreach( $rows as $row ) {
				$image = $row['h-icon'];
				?>
					<div class="item-sidebar1">
						<div class="icon-left-sidebar1">
							<img src="<?php echo $row['h-icon']?>" alt="">
						</div>

						<div class="text-right-sidebar1 ">
							<a href="<?php echo $row['h-href-sidebar1']?>">
								<?php echo $row['h-text']?>
							</a>
						</div>
					</div>
				<?php
			}
			echo '</ul>';
		}
	?>
		
	</div>

	<div class="wrap-sidebar2 fn-main-sidebar fn-block">
		<div class="wrap-sidebar2">
			<div class="title-sidebar2">
				Văn bản chỉ đạo
			</div>
			<ul class="list-sidebar2">
			<?php 
				$rows = get_field('h-sidebar2','options');
				if( $rows ) {
					foreach( $rows as $row ) {
						$image = $row['h-icon'];
						?>
							<li class="item-sidebar2">
								<a href="<?php echo $row['h-href-sidebar2']?>"><?php echo $row['h-text-sidebar2']?></a>
							</li>
						<?php
					}
					echo '</ul>';
				}
			?>
			</ul>
		</div>
	</div>

	<div class="wrap-sidebar3 fn-main-sidebar fn-block">
		<div class="wrap-sidebar3">
		<?php 
				$rows = get_field('h-sidebar3','options');
				if( $rows ) {
					foreach( $rows as $row ) {
						$image = $row['h-icon'];
						?>
							<div class="image-sidebar3">
								<a href="<?php echo $row['h-href-sidebar3']?>">
									<img src="<?php echo $row['h-image-sidebar3']?>">
								</a>
							</div>
						<?php
					}
					echo '</ul>';
				}
			?>
		</div>
	</div>


	<div class="clear"></div>
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
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="<?php echo get_bloginfo("template_directory"); ?>/assets/slick/slick.js" type="text/javascript" charset="utf-8"></script>
<script>
	$('.h-slide').slick();
</script>

</body></html>