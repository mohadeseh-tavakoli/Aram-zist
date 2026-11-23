<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Course meta fields on the product screen: video, features, curriculum, outcomes. */
function aram_product_fields() {
	echo '<div class="options_group">';
	woocommerce_wp_text_input( array( 'id' => '_aram_video', 'label' => __( 'لینک ویدیوی معرفی', 'aram-zist' ), 'description' => __( 'لینک YouTube/Aparat یا فایل ویدیو (اختیاری)', 'aram-zist' ), 'desc_tip' => true ) );
	woocommerce_wp_textarea_input( array( 'id' => '_aram_features', 'label' => __( 'ویژگی‌های دوره', 'aram-zist' ), 'description' => __( 'هر خط یک مورد', 'aram-zist' ), 'desc_tip' => true ) );
	woocommerce_wp_textarea_input( array( 'id' => '_aram_curriculum', 'label' => __( 'سرفصل‌ها', 'aram-zist' ), 'description' => __( 'هر خط یک سرفصل', 'aram-zist' ), 'desc_tip' => true ) );
	woocommerce_wp_textarea_input( array( 'id' => '_aram_outcomes', 'label' => __( 'آنچه خواهید آموخت', 'aram-zist' ), 'description' => __( 'هر خط یک مورد', 'aram-zist' ), 'desc_tip' => true ) );
	echo '</div>';
}
add_action( 'woocommerce_product_options_general_product_data', 'aram_product_fields' );

function aram_save_product_fields( $product ) {
	// WooCommerce verifies its own nonce and capability before this hook fires.
	// phpcs:disable WordPress.Security.NonceVerification.Missing
	if ( isset( $_POST['_aram_video'] ) ) { $product->update_meta_data( '_aram_video', esc_url_raw( wp_unslash( $_POST['_aram_video'] ) ) ); }
	foreach ( array( '_aram_features', '_aram_curriculum', '_aram_outcomes' ) as $k ) {
		if ( isset( $_POST[ $k ] ) ) { $product->update_meta_data( $k, sanitize_textarea_field( wp_unslash( $_POST[ $k ] ) ) ); }
	}
	// phpcs:enable
}
add_action( 'woocommerce_admin_process_product_object', 'aram_save_product_fields' );

/* Single product: extra tab for curriculum, labelled outcomes in the description tab. */
function aram_product_tabs( $tabs ) {
	global $product;
	if ( $product && $product->get_meta( '_aram_curriculum' ) ) {
		$tabs['curriculum'] = array( 'title' => __( 'سرفصل‌ها', 'aram-zist' ), 'priority' => 15, 'callback' => 'aram_tab_curriculum' );
	}
	if ( isset( $tabs['additional_information'] ) && ! $product->has_attributes() && ! $product->has_dimensions() && ! $product->has_weight() ) { unset( $tabs['additional_information'] ); }
	$tabs['reviews']['title'] = __( 'نظرات کاربران', 'aram-zist' ) . ' (' . (int) $product->get_review_count() . ')';
	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'aram_product_tabs' );

function aram_tab_curriculum() {
	global $product;
	echo '<ol class="curriculum">';
	foreach ( aram_lines( $product->get_meta( '_aram_curriculum' ) ) as $line ) { echo '<li>' . esc_html( $line ) . '</li>'; }
	echo '</ol>';
}

function aram_after_description() {
	global $product;
	$out = aram_lines( $product->get_meta( '_aram_outcomes' ) );
	if ( ! $out ) { return; }
	echo '<h3>' . esc_html__( 'آنچه در این دوره خواهید آموخت', 'aram-zist' ) . '</h3><ul class="checks">';
	foreach ( $out as $l ) { echo '<li>' . aram_icon( 'check' ) . esc_html( $l ) . '</li>'; }
	echo '</ul>';
}
add_filter( 'the_content', function ( $c ) {
	if ( is_singular( 'product' ) && in_the_loop() && is_main_query() ) {
		ob_start(); aram_after_description(); $c .= ob_get_clean();
	}
	return $c;
} );

/* Course box beside the add-to-cart: features, lifetime access, video. */
function aram_course_box() {
	global $product;
	$video = $product->get_meta( '_aram_video' );
	echo '<ul class="course-features">';
	echo '<li>' . aram_icon( 'infinity' ) . esc_html__( 'دسترسی همیشگی', 'aram-zist' ) . '</li>';
	foreach ( aram_lines( $product->get_meta( '_aram_features' ) ) as $l ) { echo '<li>' . aram_icon( 'check' ) . esc_html( $l ) . '</li>'; }
	echo '</ul>';
	if ( $video ) { printf( '<p><a class="btn btn-ghost" href="%s" target="_blank" rel="noopener">%s</a></p>', esc_url( $video ), esc_html__( 'مشاهده ویدیوی معرفی', 'aram-zist' ) ); }
}
add_action( 'woocommerce_single_product_summary', 'aram_course_box', 35 );

/* Instructor block under the product summary. */
function aram_instructor_box() {
	echo '<section class="instructor"><img src="' . esc_url( ARAM_URI . '/assets/images/portrait.jpg' ) . '" alt="" width="96" height="96" loading="lazy"><div><h3>' . esc_html__( 'مدرس دوره', 'aram-zist' ) . '</h3><p>' . esc_html( aram_opt( 'about_short' ) ) . '</p><a href="' . esc_url( aram_page_url( 'about' ) ) . '">' . esc_html__( 'بیشتر بدانید', 'aram-zist' ) . '</a></div></section>';
}
add_action( 'woocommerce_after_single_product_summary', 'aram_instructor_box', 12 );

/* Sticky purchase bar on mobile. */
function aram_sticky_cta() {
	if ( ! is_product() ) { return; }
	global $product;
	if ( ! $product || ! $product->is_purchasable() ) { return; }
	echo '<div class="sticky-cta"><span class="sticky-price">' . wp_kses_post( $product->get_price_html() ) . '</span><a class="btn" href="#product-' . esc_attr( $product->get_id() ) . '" data-scroll-buy>' . esc_html__( 'افزودن به سبد خرید', 'aram-zist' ) . '</a></div>';
}
add_action( 'wp_footer', 'aram_sticky_cta' );

/* Shop archive layout: sidebar with search, categories and price filter. */
function aram_shop_sidebar() {
	echo '<aside class="shop-side">';
	if ( is_active_sidebar( 'shop-sidebar' ) ) {
		dynamic_sidebar( 'shop-sidebar' );
	} else {
		the_widget( 'WC_Widget_Product_Search', array( 'title' => __( 'جستجوی دوره', 'aram-zist' ) ) );
		the_widget( 'WC_Widget_Product_Categories', array( 'title' => __( 'دسته‌بندی‌ها', 'aram-zist' ), 'hide_empty' => 1 ) );
		the_widget( 'WC_Widget_Price_Filter', array( 'title' => __( 'فیلتر قیمت', 'aram-zist' ) ) );
	}
	echo '</aside>';
}

function aram_shop_hero() {
	echo '<section class="page-hero"><div class="wrap"><h1>' . esc_html( woocommerce_page_title( false ) ) . '</h1><p>' . esc_html__( 'انتخاب دوره مناسب برای مسیر رشد شما', 'aram-zist' ) . '</p></div></section>';
}
add_filter( 'woocommerce_show_page_title', '__return_false' );
add_filter( 'loop_shop_columns', function () { return 3; } );
add_filter( 'loop_shop_per_page', function () { return 9; } );

function aram_loop_button_text( $text, $product ) {
	return $product->is_type( 'simple' ) ? __( 'مشاهده دوره', 'aram-zist' ) : $text;
}
add_filter( 'woocommerce_product_add_to_cart_text', 'aram_loop_button_text', 10, 2 );
add_filter( 'woocommerce_product_single_add_to_cart_text', function () { return __( 'افزودن به سبد خرید', 'aram-zist' ); } );

/* Short description in product loop cards. */
add_action( 'woocommerce_after_shop_loop_item_title', function () {
	global $product;
	$d = $product->get_short_description();
	if ( $d ) { echo '<p class="loop-desc">' . esc_html( wp_trim_words( wp_strip_all_tags( $d ), 16 ) ) . '</p>'; }
}, 6 );

/* Header cart count updates through WooCommerce AJAX fragments. */
function aram_cart_count_html() {
	$n = aram_has_wc() && WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	return '<span class="cart-count" data-count="' . (int) $n . '">' . esc_html( number_format_i18n( $n ) ) . '</span>';
}
add_filter( 'woocommerce_add_to_cart_fragments', function ( $f ) {
	$f['span.cart-count'] = aram_cart_count_html();
	return $f;
} );

/* Products without an image get one of the bundled wellness photos (stable per product). */
function aram_fallback_image( $image, $product, $size = 'woocommerce_thumbnail', $attr = array() ) {
	if ( $product && ! $product->get_image_id() ) {
		$n   = ( $product->get_id() % 4 ) + 1;
		$src = ARAM_URI . '/assets/images/courses/0' . $n . '.jpg';
		return '<img src="' . esc_url( $src ) . '" alt="' . esc_attr( $product->get_name() ) . '" width="768" height="512" loading="lazy" class="wp-post-image">';
	}
	return $image;
}
add_filter( 'woocommerce_product_get_image', 'aram_fallback_image', 10, 4 );
add_filter( 'woocommerce_placeholder_img_src', function () { return ARAM_URI . '/assets/images/courses/03.jpg'; } );
