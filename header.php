<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip" href="#main"><?php esc_html_e( 'پرش به محتوا', 'aram-zist' ); ?></a>
<header class="site-header">
	<div class="wrap header-row">
		<button class="icon-btn nav-toggle" aria-expanded="false" aria-controls="primary-nav" aria-label="<?php esc_attr_e( 'منو', 'aram-zist' ); ?>"><?php echo aram_icon( 'menu' ); // phpcs:ignore ?></button>
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if ( has_custom_logo() ) { the_custom_logo(); } else { ?>
				<span class="brand-name"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
			<?php } ?>
		</a>
		<nav id="primary-nav" class="primary-nav" aria-label="<?php esc_attr_e( 'منوی اصلی', 'aram-zist' ); ?>">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'fallback_cb' => 'aram_fallback_menu', 'depth' => 2 ) ); ?>
		</nav>
		<div class="header-tools">
			<button class="icon-btn search-toggle" aria-expanded="false" aria-controls="header-search" aria-label="<?php esc_attr_e( 'جستجو', 'aram-zist' ); ?>"><?php echo aram_icon( 'search' ); // phpcs:ignore ?></button>
			<a class="icon-btn" href="<?php echo esc_url( aram_has_wc() ? wc_get_page_permalink( 'myaccount' ) : wp_login_url() ); ?>" aria-label="<?php esc_attr_e( 'حساب کاربری', 'aram-zist' ); ?>"><?php echo aram_icon( 'user' ); // phpcs:ignore ?></a>
			<?php if ( aram_has_wc() ) : ?>
			<a class="icon-btn cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php esc_attr_e( 'سبد خرید', 'aram-zist' ); ?>"><?php echo aram_icon( 'cart' ); echo aram_cart_count_html(); // phpcs:ignore ?></a>
			<?php endif; ?>
		</div>
	</div>
	<div id="header-search" class="header-search" hidden>
		<div class="wrap">
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label class="sr" for="hs"><?php esc_html_e( 'جستجو', 'aram-zist' ); ?></label>
				<input id="hs" type="search" name="s" placeholder="<?php esc_attr_e( 'جستجو در دوره‌ها…', 'aram-zist' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
				<?php if ( aram_has_wc() ) : ?><input type="hidden" name="post_type" value="product"><?php endif; ?>
				<button class="btn" type="submit"><?php esc_html_e( 'جستجو', 'aram-zist' ); ?></button>
			</form>
		</div>
	</div>
</header>
<main id="main">
