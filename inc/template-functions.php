<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function aram_lines( $text ) {
	return array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $text ) ) );
}
function aram_has_wc() { return class_exists( 'WooCommerce' ); }
function aram_shop_url() { return aram_has_wc() ? wc_get_page_permalink( 'shop' ) : home_url( '/' ); }
function aram_page_url( $slug ) {
	$p = get_page_by_path( $slug );
	return $p ? get_permalink( $p ) : home_url( '/' . $slug . '/' );
}

function aram_fallback_menu() {
	$pid   = (int) get_option( 'page_for_posts' );
	$items = array(
		'صفحه اصلی'  => home_url( '/' ),
		'فروشگاه'    => aram_shop_url(),
		'دوره‌ها'     => aram_shop_url(),
		'درباره من'  => aram_page_url( 'about' ),
		'وبلاگ'      => $pid ? get_permalink( $pid ) : home_url( '/?post_type=post' ),
		'تماس با من' => aram_page_url( 'contact' ),
	);
	echo '<ul class="menu">';
	foreach ( $items as $label => $url ) { printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) ); }
	echo '</ul>';
}

function aram_icon( $name ) {
	$i = array(
		'search' => '<circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/>',
		'user'   => '<circle cx="12" cy="8" r="4"/><path d="M4 21c1-4 4-6 8-6s7 2 8 6"/>',
		'cart'   => '<path d="M3 4h2l2.4 11h10.2L20 7H6.2"/><circle cx="9" cy="19" r="1.5"/><circle cx="17" cy="19" r="1.5"/>',
		'menu'   => '<path d="M4 7h16M4 12h16M4 17h16"/>',
		'close'  => '<path d="M6 6l12 12M18 6L6 18"/>',
		'star'   => '<path d="M12 3l2.7 5.6 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.9 1-6.1-4.4-4.3 6.1-.9z" fill="currentColor" stroke="none"/>',
		'check'  => '<path d="M5 12.5l4.5 4.5L19 7.5"/>',
		'infinity' => '<path d="M7 8c-3 0-4 8 0 8 3 0 7-8 10-8 4 0 3 8 0 8-3 0-7-8-10-8z"/>',
		'shield' => '<path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/>',
		'chat'   => '<path d="M4 5h16v11H9l-5 4z"/>',
		'next'   => '<path d="M15 6l-6 6 6 6"/>',
		'prev'   => '<path d="M9 6l6 6-6 6"/>',
	);
	return '<svg class="icon" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ( isset( $i[ $name ] ) ? $i[ $name ] : '' ) . '</svg>';
}

function aram_stars( $rating ) {
	$rating = max( 0, min( 5, (float) $rating ) );
	$out = '<span class="stars" role="img" aria-label="' . esc_attr( sprintf( __( 'امتیاز %s از ۵', 'aram-zist' ), number_format_i18n( $rating, 1 ) ) ) . '">';
	for ( $n = 1; $n <= 5; $n++ ) { $out .= '<span class="' . ( $n <= round( $rating ) ? 'on' : '' ) . '">' . aram_icon( 'star' ) . '</span>'; }
	return $out . '</span>';
}

function aram_social_links() {
	$map = array( 'instagram' => 'اینستاگرام', 'telegram' => 'تلگرام', 'whatsapp' => 'واتساپ', 'linkedin' => 'لینکدین' );
	$out = '';
	foreach ( $map as $k => $label ) {
		$u = aram_opt( 'social_' . $k );
		if ( $u ) { $out .= sprintf( '<a href="%s" rel="noopener" target="_blank">%s</a>', esc_url( $u ), esc_html( $label ) ); }
	}
	return $out ? '<div class="social">' . $out . '</div>' : '';
}

function aram_schema() {
	if ( ! is_front_page() ) { return; }
	$data = array( '@context' => 'https://schema.org', '@graph' => array(
		array( '@type' => 'WebSite', 'name' => get_bloginfo( 'name' ), 'url' => home_url( '/' ), 'inLanguage' => 'fa-IR' ),
		array( '@type' => 'Organization', 'name' => get_bloginfo( 'name' ), 'url' => home_url( '/' ) ),
	) );
	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'aram_schema' );

/* The theme is Persian-only: force RTL regardless of the site locale. */
function aram_force_rtl( $attrs ) {
	return false === strpos( $attrs, 'dir=' ) ? $attrs . ' dir="rtl"' : $attrs;
}
add_filter( 'language_attributes', 'aram_force_rtl' );
