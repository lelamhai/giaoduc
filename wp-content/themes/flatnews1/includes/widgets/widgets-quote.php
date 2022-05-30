<?php

function flatnews_widget_quote_display( $args, $instance, $widget_id, $widget_declaration ) {	
	flatnews_widget_common_header('fn-widget-quote', $instance, $args);	
		
	?>	
	<div class="quote-icon"><i class="fa fa-quote-left"></i></div>
	<div class="quote-content"><?php echo $instance['content']; ?></div>	
	
	<?php if (!empty($instance['author'])): ?>
	<div class="quote-author">
		<?php if (!empty($instance['link'])) :
			echo '<a class="quote-author-link" title="'. esc_attr($instance['author']).'" href="'.  esc_url($instance['link']).'" target="_blank">';
		endif; ?>
		<?php
		if (!empty($instance['image'])) :
			$img_id = flatnews_get_attachment_id_from_src($instance['image']);
			if (!$img_id) {
				echo '<img alt="'.esc_attr($instance['author']).'" src="'.esc_url($instance['image']).'"/>';
			} else {
				echo wp_get_attachment_image($img_id);
			}		
		endif;
		?>	
		<span class="quote-author-name">
		<?php 		
		echo $instance['author']; 		
		?>
		</span>
		
		<?php if (!empty($instance['link'])) :
			echo '</a>';
		endif; ?>
		
		<?php if (!empty($instance['desc'])) :
			echo '<span class="quote-author-desc">'.$instance['desc'].'</span>';
		endif; ?>
		
	</div>
	<?php endif;?>
	<div class="clear"></div>
	
	<?php
	flatnews_widget_common_footer();
}