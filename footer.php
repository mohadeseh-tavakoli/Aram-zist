<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
</main>
<footer class="site-footer">
	<div class="wrap footer-row">
		<div class="footer-brand">
			<strong><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong>
			<span><?php echo esc_html( aram_opt( 'footer_text' ) ); ?></span>
			<?php echo aram_social_links(); // phpcs:ignore ?>
		</div>
		<nav aria-label="<?php esc_attr_e( 'منوی فوتر', 'aram-zist' ); ?>">
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'fallback_cb' => 'aram_fallback_menu', 'depth' => 1 ) ); ?>
		</nav>
		<form class="newsletter" action="<?php echo esc_url( aram_page_url( 'contact' ) ); ?>" method="get">
			<label for="nl" class="sr"><?php esc_html_e( 'ایمیل', 'aram-zist' ); ?></label>
			<span><?php esc_html_e( 'برای دریافت پیام و مشاوره، از فرم تماس استفاده کنید.', 'aram-zist' ); ?></span>
			<a class="btn" href="<?php echo esc_url( aram_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'تماس با من', 'aram-zist' ); ?></a>
		</form>
	</div>
	<div class="wrap copy">© <?php echo esc_html( number_format_i18n( (int) gmdate( 'Y' ), 0 ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?></div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
