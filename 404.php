<?php get_header(); ?>
<section class="wrap section narrow center">
	<h1><?php esc_html_e( 'صفحه پیدا نشد', 'aram-zist' ); ?></h1>
	<p><?php esc_html_e( 'آدرسی که دنبالش بودید وجود ندارد.', 'aram-zist' ); ?></p>
	<a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'بازگشت به صفحه اصلی', 'aram-zist' ); ?></a>
</section>
<?php get_footer(); ?>
