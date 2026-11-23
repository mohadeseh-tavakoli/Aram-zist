<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function aram_setup() {
	load_theme_textdomain( 'aram-zist', ARAM_DIR . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 260, 'flex-width' => true, 'flex-height' => true ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_image_size( 'aram-course', 640, 440, true );
	register_nav_menus( array(
		'primary' => __( 'منوی اصلی', 'aram-zist' ),
		'footer'  => __( 'منوی فوتر', 'aram-zist' ),
	) );
}
add_action( 'after_setup_theme', 'aram_setup' );

function aram_widgets() {
	register_sidebar( array(
		'name' => __( 'سایدبار فروشگاه', 'aram-zist' ), 'id' => 'shop-sidebar',
		'before_widget' => '<section id="%1$s" class="widget %2$s">', 'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'aram_widgets' );

/* Testimonials and FAQ are managed from the admin as simple content types. */
function aram_post_types() {
	register_post_type( 'aram_testimonial', array(
		'labels' => array( 'name' => __( 'نظرات هنرجویان', 'aram-zist' ), 'singular_name' => __( 'نظر', 'aram-zist' ), 'add_new_item' => __( 'افزودن نظر', 'aram-zist' ), 'edit_item' => __( 'ویرایش نظر', 'aram-zist' ) ),
		'public' => false, 'show_ui' => true, 'menu_icon' => 'dashicons-format-quote', 'supports' => array( 'title', 'editor', 'thumbnail' ),
	) );
	register_post_type( 'aram_faq', array(
		'labels' => array( 'name' => __( 'سؤالات متداول', 'aram-zist' ), 'singular_name' => __( 'سؤال', 'aram-zist' ), 'add_new_item' => __( 'افزودن سؤال', 'aram-zist' ), 'edit_item' => __( 'ویرایش سؤال', 'aram-zist' ) ),
		'public' => false, 'show_ui' => true, 'menu_icon' => 'dashicons-editor-help', 'supports' => array( 'title', 'editor', 'page-attributes' ),
	) );
}
add_action( 'init', 'aram_post_types' );

function aram_testimonial_metabox() {
	add_meta_box( 'aram_rating', __( 'امتیاز (۱ تا ۵)', 'aram-zist' ), function ( $post ) {
		wp_nonce_field( 'aram_rating_save', 'aram_rating_nonce' );
		$v = (int) get_post_meta( $post->ID, '_aram_rating', true );
		printf( '<input type="number" min="1" max="5" name="aram_rating" value="%d">', $v ? $v : 5 );
	}, 'aram_testimonial', 'side' );
}
add_action( 'add_meta_boxes', 'aram_testimonial_metabox' );

function aram_testimonial_save( $post_id ) {
	if ( ! isset( $_POST['aram_rating_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['aram_rating_nonce'] ) ), 'aram_rating_save' ) ) { return; }
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }
	update_post_meta( $post_id, '_aram_rating', max( 1, min( 5, absint( isset( $_POST['aram_rating'] ) ? $_POST['aram_rating'] : 5 ) ) ) );
}
add_action( 'save_post_aram_testimonial', 'aram_testimonial_save' );
