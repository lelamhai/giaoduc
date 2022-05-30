<?php
/**
 * @param Sneeit_Articles_Query_Item $item
 */
function fn_block_article_item_slider($item) {	
	return (
	'<div'.$item->item_class().'>
		<div class="item-inner">
			<div class="item-mid">				
				<div class="item-mid-content"><div class="item-mid-content-inner">					
					<a href="'.$item->permalink.'" class="item-mid-content-gradient"></a>
					'.$item->categories().'
					'.$item->title().'
					'.$item->meta().'
					'.$item->snippet().'									
				</div></div>
				'.$item->format_icon().'
				'.$item->review().'
				'.$item->thumbnail().'
			</div>
		</div>
	</div>'
	);
}

