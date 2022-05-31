<?php 
get_header();
if ( have_posts() ) :
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
		echo '<div class="fn-post fn-singular">';			
		$fn_post->start_tag();
		
		if (!function_exists('sneeit_framework')) :
			?><div id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php
		endif;
		
		$fn_post->crumbs(esc_html__('Home', 'flatnews'));

		$fn_post->feature('above-title');
		$fn_post->title();
		$fn_post->sub_title();
		$fn_post->excerpt();

		echo '<div class="entry-meta">';
		$fn_post->author();
		$fn_post->date_time(array(
			'before_text' => (get_theme_mod('article_author') ? ' <span class="entry-date-sep"> - </span> ': '')
		));
		$fn_post->comments_number();

		$fn_post->sharing_buttons('top');
		echo '</div>';

		$fn_post->feature('under-title');

		fn_display_sidebar('fn-before-post-body-sidebar');
		fn_display_sidebar('fn-left-post-body-sidebar');
		
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

		fn_display_sidebar('fn-after-post-body-sidebar');

		$fn_post->categories(array(
			'before' => '<div class="entry-taxonomies"><span class="entry-taxonomies-label"><i class="fa fa-folder-open-o"></i> '.  esc_html__('CATEGORIES', 'flatnews') . ' </span> ',
			'after' => '</div>',
			'link_class' => '',
		));
		
		$fn_post->tags(array(
			'before' => '<div class="entry-taxonomies"><span class="entry-taxonomies-label"><i class="fa fa-hashtag"></i> '.  esc_html__('TAGS', 'flatnews') . ' </span> ',
			'after' => '</div>',
			'link_class' => '',
		));
		if (!function_exists('sneeit_framework')) {
			the_tags();
		}
		
		$fn_post->sharing_buttons(array(
			'before' => '<div class="entry-sharing-buttons entry-sharing-bottom"><span><i class="fa fa-send"></i> '.esc_html__('Share This', 'flatnews').'</span>',
			'after' => '<div class="clear"></div></div><div class="clear"></div>',
			'position' => 'bottom'
		));
		
		$fn_post->author_box(array(
			'before' => '<div class="author-box">',
			'after' => '</div>',
			'template' =>	'<h4 class="author-box-top">'. esc_html__('AUTHOR', 'flatnews').'[avatar][name][social]</h4>' .
							'<div class="clear"></div>'.
							'<div class="author-box-bot">[bio]</div>'.		
							'<div class="clear"></div>',
			'social_args' => array(
				'before' => '<span class="author-box-social-links">',
				'after' => '</span>'
			)
		));
		if (!function_exists('sneeit_framework')) :
			?><div class="clear"></div></div><?php
		endif;
		
		$fn_post->end_tag(array('site_logo_mod_key' => 'site_logo'));
		
		fn_display_sidebar('fn-related-post-sidebar');

		$fn_post->post_nextprev(array(
			'before' => '<div class="pagers">',
			'after' => '<div class="clear"></div></div>', 
			'before_next_link' => '<div class="pager pager-newer"><div class="pager-inner"><span class="page-label">'.  esc_html__('NEWER POST', 'flatnews').'</span>',
			'after_next_link' => '</div></div>', 
			'before_prev_link' => '<div class="pager pager-older"><div class="pager-inner"><span class="page-label">'.  esc_html__('OLDER POST', 'flatnews').'</span>',
			'after_prev_link' => '</div></div>', 
		));
		
		comments_template();
		
	endwhile;

endif;
?>
<div class="fn-footter-row fn-footer-row-widgets h-fn-footer-row-widgets">
		<div class="fn-footer-row-inner">
			<!-- column 1 -->
			<div class="fn-footer-col fn-footer-col-0">
				<div class="fn-footer-col-inner h-fn-footer-col-inner">
					<div class="general-news">
						<h2 class="fn-block-title"><span class="fn-block-title-text">Tin tổng hợp</span></h2>
						<div class="wrap-general-news">
							<?php 
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => 1,
								'meta_query' => array(
									array(
										'key'   => 'general-news',
										'value' => '1',
									)
								)
							);
							$the_query = new WP_Query( $args ); ?>
							
							<?php if ( $the_query->have_posts() ) : ?>
								<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
								<div class="post-big">
									<a href="<?php the_permalink()?>">
										<div class="img-big">
											<img src="<?php the_post_thumbnail_url('full')?>" alt="">
										</div>

										<div class="titile-big">
											<?php the_title()?>
										</div>

										<div class="description-big">
											<?php the_excerpt()?>
										</div>
									</a>
								</div>


								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>
							
							<?php else : ?>
								<p>Chưa có dữ liệu</p>
							<?php endif; ?>

						
							<?php 
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => 5,
								'offset' => 1,
								'meta_query' => array(
									array(
										'key'   => 'general-news',
										'value' => '1',
									)
								)
							);
							$the_query = new WP_Query( $args ); ?>
							
							<?php if ( $the_query->have_posts() ) : ?>
								<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
								<div class="post-normal">
									<a href="">
										<div class="img-normal">
											<img src="<?php the_post_thumbnail_url('full')?>" alt="">
										</div>
										<div class="title-noraml">
										<?php the_title()?>
										</div>
									</a>
								</div>
								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>
							
							<?php else : ?>
								<p>Chưa có dữ liệu</p>
							<?php endif; ?>
						</div>
					</div>	

				</div>
			</div>

			<!-- column 2 -->
			<div class="fn-footer-col fn-footer-col-1">
				<div class="fn-footer-col-inner h-fn-footer-col-inner">
					<div class="general-news">
						<h2 class="fn-block-title"><span class="fn-block-title-text">Thông tin sinh viên</span></h2>
						<div class="wrap-general-news">
							<?php 
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => 1,
								'meta_query' => array(
									array(
										'key'   => 'student-info',
										'value' => '1',
									)
								)
							);
							$the_query = new WP_Query( $args ); ?>
							
							<?php if ( $the_query->have_posts() ) : ?>
								<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
								<div class="post-big">
									<a href="<?php the_permalink()?>">
										<div class="img-big">
											<img src="<?php the_post_thumbnail_url('full')?>" alt="">
										</div>

										<div class="titile-big">
											<?php the_title()?>
										</div>

										<div class="description-big">
											<?php the_excerpt()?>
										</div>
									</a>
								</div>


								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>
							
							<?php else : ?>
								<p>Chưa có dữ liệu</p>
							<?php endif; ?>

						
							<?php 
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => 5,
								'offset' => 1,
								'meta_query' => array(
									array(
										'key'   => 'student-info',
										'value' => '1',
									)
								)
							);
							$the_query = new WP_Query( $args ); ?>
							
							<?php if ( $the_query->have_posts() ) : ?>
								<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
								<div class="post-normal">
									<a href="">
										<div class="img-normal">
											<img src="<?php the_post_thumbnail_url('full')?>" alt="">
										</div>
										<div class="title-noraml">
										<?php the_title()?>
										</div>
									</a>
								</div>
								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>
							
							<?php else : ?>
								<p>Chưa có dữ liệu</p>
							<?php endif; ?>
						</div>
					</div>	
				</div>
			</div>

			<!-- column 3 -->
			<div class="fn-footer-col fn-footer-col-2">
				<div class="fn-footer-col-inner h-fn-footer-col-inner">
				<div class="general-news">
						<h2 class="fn-block-title"><span class="fn-block-title-text">Tin nổi bật</span></h2>
						<div class="wrap-general-news">
							<?php 
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => 1,
								'meta_query' => array(
									array(
										'key'   => 'hot-post',
										'value' => '1',
									)
								)
							);
							$the_query = new WP_Query( $args ); ?>
							
							<?php if ( $the_query->have_posts() ) : ?>
								<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
								<div class="post-big">
									<a href="<?php the_permalink()?>">
										<div class="img-big">
											<img src="<?php the_post_thumbnail_url('full')?>" alt="">
										</div>

										<div class="titile-big">
											<?php the_title()?>
										</div>

										<div class="description-big">
											<?php the_excerpt()?>
										</div>
									</a>
								</div>


								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>
							
							<?php else : ?>
								<p>Chưa có dữ liệu</p>
							<?php endif; ?>

						
							<?php 
							$args = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => 5,
								'offset' => 1,
								'meta_query' => array(
									array(
										'key'   => 'hot-post',
										'value' => '1',
									)
								)
							);
							$the_query = new WP_Query( $args ); ?>
							
							<?php if ( $the_query->have_posts() ) : ?>
								<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
								<div class="post-normal">
									<a href="">
										<div class="img-normal">
											<img src="<?php the_post_thumbnail_url('full')?>" alt="">
										</div>
										<div class="title-noraml">
										<?php the_title()?>
										</div>
									</a>
								</div>
								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>
							
							<?php else : ?>
								<p>Chưa có dữ liệu</p>
							<?php endif; ?>
						</div>
					</div>	
				
				</div>
			</div>
			<div class="clear"></div>
		</div>		
	</div>




<?php
get_footer();