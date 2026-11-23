<section class="hero">
	<div class="wrap hero-grid">
		<div class="hero-text">
			<h1><?php echo esc_html( aram_opt( 'hero_title' ) ); ?></h1>
			<p><?php echo esc_html( aram_opt( 'hero_text' ) ); ?></p>
			<div class="actions">
				<a class="btn btn-orange" href="<?php echo esc_url( aram_shop_url() ); ?>"><?php echo esc_html( aram_opt( 'hero_cta1' ) ); ?></a>
				<a class="btn btn-ghost" href="<?php echo esc_url( aram_page_url( 'about' ) ); ?>"><?php echo esc_html( aram_opt( 'hero_cta2' ) ); ?></a>
			</div>
		</div>
		<figure class="hero-figure">
			<img src="<?php echo esc_url( ARAM_URI . '/assets/images/portrait.jpg' ); ?>" width="1400" height="788" alt="<?php esc_attr_e( 'تصویر روانشناس', 'aram-zist' ); ?>" fetchpriority="high">
		</figure>
	</div>
	<ul class="wrap trust">
		<li><?php echo aram_icon( 'shield' ); // phpcs:ignore ?><span><?php esc_html_e( 'پرداخت امن', 'aram-zist' ); ?></span></li>
		<li><?php echo aram_icon( 'check' ); // phpcs:ignore ?><span><?php esc_html_e( 'پشتیبانی دائمی', 'aram-zist' ); ?></span></li>
		<li><?php echo aram_icon( 'infinity' ); // phpcs:ignore ?><span><?php esc_html_e( 'دسترسی مادام‌العمر', 'aram-zist' ); ?></span></li>
	</ul>
</section>
