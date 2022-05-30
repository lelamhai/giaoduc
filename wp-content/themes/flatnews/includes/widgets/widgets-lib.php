<?php
function flatnews_widget_common_header($class_names = array(), $instance = array(), $args = array()) {
	
	echo '<div';
	if (isset($args['widget_id'])) {
		echo ' id="'.$args['widget_id'].'"';
	}
	echo ' class="fn-block fn-widget';
	if (is_array($class_names)) {
		foreach ($class_names as $class_name) {
			echo ' '.$class_name;
		}
	} else if ($class_names) {
		echo ' '.$class_names;
	}
	if (isset($instance['enable_tab']) && $instance['enable_tab']) {
		echo ' tab';
	}
	
	echo '">';
	if (isset($instance['flatnews_before_title'])) {
		echo $instance['flatnews_before_title'];
	}
	if (!empty($instance['title'])) {
		echo '<h2 class="fn-block-title">';
		
		echo '<span class="fn-block-title-text">';
		if (!empty($instance['title_icon'])) {
			$title_icon = apply_filters('sneeit_get_font_awesome_tag', $instance['title_icon']);
			if ($title_icon) {
				echo $title_icon . ' ';
			}
			
		}
		echo $instance['title'].'</span></h2>';
	}
	echo '<div class="fn-block-content">';
}

function flatnews_widget_common_footer() {
	echo '</div><div class="clear"></div></div>';
}