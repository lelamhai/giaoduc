<?php 
get_header(); 
global $wp_query;

?>
<div class="fn-archive">
	<div class="fn-archive-header">		
		<?php 
		$archive_page_title = '';
		if (is_search() && get_search_query()) {
			$archive_page_title = sprintf(__('Search query: <strong>%s</strong>', 'flatnews'), get_search_query());
		} else if (is_category()) {
			$archive_page_title = sprintf(__('Category: <strong>%s</strong>', 'flatnews'), $wp_query->queried_object->name);
		} else if (is_tag()) {
			$archive_page_title = sprintf(__('Tag: <strong>%s</strong>', 'flatnews'), $wp_query->queried_object->name);
		} else if (is_author()) {
			$archive_page_title = sprintf(__('Author: <strong>%s</strong>', 'flatnews'), $wp_query->queried_object->data->display_name);
		} ?>
		
		<?php if ($archive_page_title) : ?>
		<h1 class="fn-archive-title"><?php echo $archive_page_title; ?></h1>
		<?php endif; ?>		
	<?php
	
	if (isset($wp_query->queried_object) && 
		isset($wp_query->queried_object->description) && 
		!empty($wp_query->queried_object->description) ) {
		echo '<p class="archive-page-description">';
		if (is_author()) {
			echo get_avatar(get_the_author_ID(), 48, null, null, array(
				'class' => 'author-page-avatar'
			));
		}
		echo $wp_query->queried_object->description.'</p>';
	}
	?>
	</div>
	<div class="clear"></div>
	<div class="fn-archive-content">
	<?php
		global $FNAB_Fields_Archive;
		$args = array();
		foreach ($FNAB_Fields_Archive as $key => $value) {
			if (isset($value['default'])) {
				$args[$key] = get_theme_mod('archive_'.$key, $value['default']);
			} else {
				$args[$key] = get_theme_mod('archive_'.$key);
			}			
		}
		
		echo fn_block('blog', $args);
	?>
	</div>
</div>	
<?php
get_footer();