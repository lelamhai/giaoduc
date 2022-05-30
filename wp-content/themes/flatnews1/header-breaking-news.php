<?php 

	
if (!get_theme_mod('break_disable', false) && get_theme_mod('break_show', true)) : 
	
	
	
	/**
	* @param Sneeit_Articles_Query_Item $item
	*/
	function fn_break_item($item) {
		return '<li '.$item->item_class().'>'.$item->categories().$item->title().'</li>';
	}
	function fn_break() {		
		$break_stuff = '';
		$break_text = get_theme_mod('break_text');
		if ($break_text) :
			$break_stuff .= '<h2>'. $break_text; 
			$break_icon = get_theme_mod('break_icon');
			if ($break_icon) {
				$break_stuff .= ' ' . apply_filters('sneeit_font_awesome_tag', $break_icon);
			}
			$break_stuff .= '</h2>';
		endif;


		$args = array(
			'categories' => get_theme_mod('break_cates'),
			'count' => get_theme_mod('break_count'),
			'article_display_callback' => 'fn_break_item',
			'number_cates' => 1,
		);

		$break_items = apply_filters('sneeit_articles_query', $args);
		if (is_string($break_items) && $break_items) {
			echo '<div class="fn-break"><div class="fn-break-inner">' . $break_stuff . '<div class="fn-break-gradient left"></div><div class="fn-break-content"><ul>'.$break_items.'</ul></div><div class="fn-break-gradient right"></div><div class="clear"></div></div></div>';		
		}			
	}
	
	
	
	$break_show = get_theme_mod('break_show', true);
	if (is_string($break_show)) {
		$break_show = explode(',', $break_show);
	}	
	
	if (!empty($break_show)) {
		foreach ($break_show as $break_show_check) {
			if (('all' == $break_show_check) ||
				('home' == $break_show_check && (is_front_page() || is_home())) ||
				('archive' == $break_show_check && (!is_singular() && !is_404()) ) ||
				('article' == $break_show_check && is_single()) ||
				('page' == $break_show_check && is_page() && !is_front_page())) {
				fn_break(); break;
			}
		}
	}
	
	
endif;