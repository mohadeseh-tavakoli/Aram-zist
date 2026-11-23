<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function aram_enqueue() {
	// Vazirmatn via Google Fonts. To self-host, see README ("Fonts").
	wp_enqueue_style( 'aram-font', 'https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;700;800&display=swap', array(), null );
	wp_enqueue_style( 'aram-main', ARAM_URI . '/assets/css/main.css', array(), ARAM_VERSION );
	wp_enqueue_script( 'aram-main', ARAM_URI . '/assets/js/main.js', array(), ARAM_VERSION, array( 'in_footer' => true, 'strategy' => 'defer' ) );
	wp_localize_script( 'aram-main', 'aramI18n', array(
		'required' => __( 'این فیلد الزامی است.', 'aram-zist' ),
		'email'    => __( 'ایمیل معتبر وارد کنید.', 'aram-zist' ),
		'phone'    => __( 'شماره تلفن معتبر وارد کنید.', 'aram-zist' ),
		'short'    => __( 'پیام باید حداقل ۱۰ نویسه باشد.', 'aram-zist' ),
		'sending'  => __( 'در حال ارسال…', 'aram-zist' ),
	) );
	wp_add_inline_style( 'aram-main', sprintf( ':root{--green:%s;--orange:%s}', esc_attr( aram_opt( 'color_primary' ) ), esc_attr( aram_opt( 'color_accent' ) ) ) );
}
add_action( 'wp_enqueue_scripts', 'aram_enqueue' );

function aram_preconnect( $urls, $type ) {
	if ( 'preconnect' === $type ) { $urls[] = 'https://fonts.gstatic.com'; }
	return $urls;
}
add_filter( 'wp_resource_hints', 'aram_preconnect', 10, 2 );
