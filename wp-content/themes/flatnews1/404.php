<?php get_header(); ?>
	<div class="widget content-scroll no-title">
		<div class='post-404'>
			<div class='title'>404</div>
			<div class='desc'>
				<?php esc_html_e('The page you are looking for no longer exists. Perhaps you can return back to the homepage or search another query to see if you can find something.', 'flatnews') ?>
			</div>
			<div class='link'>
				<a href="<?php echo home_url(); ?>" class="bg"><i class='fa fa-car'></i> <?php esc_html_e('Back Home', 'flatnews'); ?></a>
			</div>
			<div class="search">
				<?php get_search_form(); ?>
			</div>
		</div>
	</div>
<?php get_footer(); ?>