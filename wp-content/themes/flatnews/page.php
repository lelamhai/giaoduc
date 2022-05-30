<?php 
get_header();
if (have_posts() ) :
	while ( have_posts() ) : the_post();		
		// create post object
		$fn_post = apply_filters('sneeit_singular', array());

		if (!is_object($fn_post)) {
			break;
		}
		
		// check content layout
		$content_layout = get_post_meta($fn_post->ID, 'content-layout', true);
		if ($content_layout == 'builder') {
			echo '<div class="fn-builder">';
			remove_filter( 'the_content', 'wpautop' );
			the_content();
			echo '<div class="clear"></div></div>';
			break;
		}

		// show article
		echo '<div class="fn-page fn-singular">';
		
		$fn_post->feature('above-title');
		$fn_post->title();
		$fn_post->sub_title();
		$fn_post->excerpt();
		
		$fn_post->feature('under-title');		

		echo '<div class="entry-body">';
		the_content();
		wp_link_pages( array( 
			'before'           => '<div class="clear"></div><div class="entry-pagination">',
			'after'            => '<div class="clear"></div></div><div class="clear"></div>',
			'link_before'      => '<div class="entry-pag-num">',
			'link_after'       => '</div>',
			'next_or_number'   => 'number',
			'separator'        => '',
			'nextpagelink'     => '<i class="fa fa-fa-caret-left"></i>',
			'previouspagelink' => '<i class="fa fa-fa-caret-right"></i>',						
		) );
		echo '</div>';
		comments_template();
		echo '</div>'; // fn-post
	endwhile;

endif;
get_footer();