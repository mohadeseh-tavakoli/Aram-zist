<?php
/* Template Name: تماس با من */
get_header();
$msg  = isset( $_GET['aram_msg'] ) ? sanitize_key( wp_unslash( $_GET['aram_msg'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
$msgs = array(
	'ok'      => array( 'ok', 'پیام شما ارسال شد. به‌زودی پاسخ می‌دهم.' ),
	'invalid' => array( 'err', 'لطفاً فیلدها را بررسی کنید و دوباره تلاش کنید.' ),
	'slow'    => array( 'err', 'لطفاً چند لحظه صبر کنید و دوباره ارسال کنید.' ),
	'fail'    => array( 'err', 'ارسال پیام انجام نشد. لطفاً بعداً دوباره تلاش کنید.' ),
);
$phone = aram_opt( 'contact_phone' ); $email = aram_opt( 'contact_email' ); $addr = aram_opt( 'contact_address' ); $hours = aram_lines( aram_opt( 'contact_hours' ) ); $map = aram_opt( 'contact_map' );
?>
<section class="page-hero"><div class="wrap"><h1><?php the_title(); ?></h1><p><?php esc_html_e( 'برای مشاوره یا پرسش درباره دوره‌ها پیام بگذارید.', 'aram-zist' ); ?></p></div></section>
<div class="wrap section contact-grid">
	<form id="contact-form" class="form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
		<?php if ( isset( $msgs[ $msg ] ) ) { printf( '<p class="form-msg %s" role="status">%s</p>', esc_attr( $msgs[ $msg ][0] ), esc_html( $msgs[ $msg ][1] ) ); } ?>
		<input type="hidden" name="action" value="aram_contact">
		<?php wp_nonce_field( 'aram_contact', 'aram_contact_nonce' ); ?>
		<div class="hp" aria-hidden="true"><label>Website <input type="text" name="aram_website" tabindex="-1" autocomplete="off"></label></div>
		<p><label for="aram_name"><?php esc_html_e( 'نام و نام خانوادگی', 'aram-zist' ); ?></label><input id="aram_name" name="aram_name" required autocomplete="name"></p>
		<p><label for="aram_email"><?php esc_html_e( 'ایمیل', 'aram-zist' ); ?></label><input id="aram_email" name="aram_email" type="email" required dir="ltr" autocomplete="email"></p>
		<p><label for="aram_phone"><?php esc_html_e( 'تلفن (اختیاری)', 'aram-zist' ); ?></label><input id="aram_phone" name="aram_phone" type="tel" dir="ltr" autocomplete="tel"></p>
		<p><label for="aram_subject"><?php esc_html_e( 'موضوع', 'aram-zist' ); ?></label><input id="aram_subject" name="aram_subject" required></p>
		<p><label for="aram_message"><?php esc_html_e( 'پیام', 'aram-zist' ); ?></label><textarea id="aram_message" name="aram_message" rows="6" required minlength="10"></textarea></p>
		<button class="btn" type="submit"><?php esc_html_e( 'ارسال پیام', 'aram-zist' ); ?></button>
	</form>
	<aside class="contact-info">
		<?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
		<?php if ( $email ) { printf( '<p><strong>%s</strong><br><a href="mailto:%s">%s</a></p>', esc_html__( 'ایمیل', 'aram-zist' ), esc_attr( $email ), esc_html( $email ) ); } ?>
		<?php if ( $phone ) { printf( '<p><strong>%s</strong><br><a href="tel:%s" dir="ltr">%s</a></p>', esc_html__( 'تلفن', 'aram-zist' ), esc_attr( preg_replace( '/[^\d+]/', '', $phone ) ), esc_html( $phone ) ); } ?>
		<?php if ( $addr ) { printf( '<p><strong>%s</strong><br>%s</p>', esc_html__( 'آدرس', 'aram-zist' ), nl2br( esc_html( $addr ) ) ); } ?>
		<?php if ( $hours ) { echo '<p><strong>' . esc_html__( 'ساعات کاری', 'aram-zist' ) . '</strong><br>' . implode( '<br>', array_map( 'esc_html', $hours ) ) . '</p>'; } ?>
		<?php echo aram_social_links(); // phpcs:ignore ?>
		<?php if ( ! $email && ! $phone && current_user_can( 'edit_theme_options' ) ) : ?><p class="notice"><?php esc_html_e( 'اطلاعات تماس را از «نمایش › شخصی‌سازی › آرام زیستن › تماس» وارد کنید (فقط مدیر این پیام را می‌بیند).', 'aram-zist' ); ?></p><?php endif; ?>
		<?php if ( $map ) { printf( '<iframe class="map" src="%s" loading="lazy" title="%s" referrerpolicy="no-referrer-when-downgrade"></iframe>', esc_url( $map ), esc_attr__( 'نقشه', 'aram-zist' ) ); } ?>
	</aside>
</div>
<?php get_footer(); ?>
