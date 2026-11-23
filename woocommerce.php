<?php
/** WooCommerce wrapper for shop, categories and single products. Uses WC hooks, no template overrides. */
get_header();
if ( is_shop() || is_product_taxonomy() ) {
	aram_shop_hero();
	echo '<div class="wrap section shop-wrap">';
	aram_shop_sidebar();
	echo '<div>';
	woocommerce_content();
	echo '</div></div>';
} else {
	echo '<div class="wrap section">';
	woocommerce_content();
	echo '</div>';
}
get_footer();
