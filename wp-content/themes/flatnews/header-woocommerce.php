<?php
if ( function_exists( 'is_woocommerce' ) && is_woocommerce() && !is_cart() && !is_checkout()) : ?>
<div class="woo-mini-cart">
	<?php
		list( $cart_items, $cart_subtotal, $cart_currency ) = flatnews_get_current_cart_info();		
	?>	
	<a class="header-button toggle-button no-mobile fn-header-btn-cart" id="cart-toggle" href="javascript:void(0)">
		<span class="inner">
			<span><?php esc_html_e('Cart', 'flatnews'); ?></span>
			<?php 
			echo '<span class="mini-cart-number-item">';
			if ( $cart_items ) {
				echo '(<strong>' . $cart_items . '</strong>)';
			}
			echo '</span>';
			?> 
			<i class="fa fa-shopping-bag color"></i>
			<span class="arrow border"></span>
		</span>
	</a>
	<a id="cart-toggle" class="header-button toggle-button" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
		<span class="inner">
			<i class="fa fa-shopping-cart color"></i> 
		</span>
	</a>
	
	<div class="woo-mini-cart-very-right">	
		<div id="flatnews-mini-cart">
			<div id="flatnews-mini-cart-widget">
				<?php the_widget('WC_Widget_Cart'); ?>
			</div>
		</div>
	</div>
</div>
<?php 
endif;