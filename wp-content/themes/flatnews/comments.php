
<?php if (comments_open() && 
		!post_password_required() &&
		(!get_theme_mod('disable_wordpress_comment') ||
		!get_theme_mod('disable_facebook_comment') ||
		!get_theme_mod('disable_disqus_comment'))
) : ?>
<div id="comments">
	<h4 id="comments-title-tabs">
		<span class="comments-title-tab-text"><?php esc_html_e('COMMENTS', 'flatnews'); ?></span>
		<span id="comments-title-tabs-links"></span>		
	</h4>
	<div class="clear"></div>
	<div class="comments-title-tabs-hr"></div>
	<a name="comments"></a>
	
	<?php if (!get_theme_mod('disable_wordpress_comment')) {
		include FLATNEWS_THEME_PATH_INCLUDABLES.'includables-wordpress-comments.php';
	} ?>
	
	<?php if (!get_theme_mod('disable_facebook_comment')) {
		include FLATNEWS_THEME_PATH_INCLUDABLES.'includables-facebook-comments.php';
	} ?>
	
	<?php if (!get_theme_mod('disable_disqus_comment')) { 
		include FLATNEWS_THEME_PATH_INCLUDABLES.'includables-disqus-comments.php';
	} ?>		
</div><!--#comments-->	
<div class="clear"></div>

<?php endif;