<?php get_header(); get_template_part( 'template-parts/hero' ); ?>

<section class="section wrap" aria-labelledby="c-h">
	<div class="sec-head"><h2 id="c-h" class="sec-title"><?php esc_html_e( 'دوره‌های محبوب', 'aram-zist' ); ?></h2><a class="more" href="<?php echo esc_url( aram_shop_url() ); ?>"><?php esc_html_e( 'مشاهده همه دوره‌ها', 'aram-zist' ); ?></a></div>
	<?php
	$products = aram_has_wc() ? wc_get_products( array( 'limit' => 3, 'status' => 'publish', 'orderby' => 'popularity', 'featured' => false ) ) : array();
	$feat     = aram_has_wc() ? wc_get_products( array( 'limit' => 3, 'status' => 'publish', 'featured' => true ) ) : array();
	$products = $feat ? $feat : $products;
	if ( $products ) : ?>
	<div class="course-grid"><?php foreach ( $products as $p ) { get_template_part( 'template-parts/course-card', null, array( 'product' => $p ) ); } ?></div>
	<?php elseif ( current_user_can( 'edit_theme_options' ) ) : ?>
	<p class="notice"><?php esc_html_e( 'برای نمایش دوره‌ها، ووکامرس را فعال کنید و محصول اضافه کنید (فقط مدیر این پیام را می‌بیند).', 'aram-zist' ); ?></p>
	<?php endif; ?>
</section>

<section class="section about-strip">
	<div class="wrap split">
		<img src="<?php echo esc_url( ARAM_URI . '/assets/images/portrait.jpg' ); ?>" width="700" height="394" loading="lazy" alt="">
		<div>
			<h2 class="sec-title"><?php esc_html_e( 'درباره روانشناس', 'aram-zist' ); ?></h2>
			<p><?php echo esc_html( aram_opt( 'about_short' ) ); ?></p>
			<a class="btn" href="<?php echo esc_url( aram_page_url( 'about' ) ); ?>"><?php esc_html_e( 'بیشتر بخوانید', 'aram-zist' ); ?></a>
		</div>
	</div>
</section>

<section class="section wrap" aria-labelledby="b-h">
	<h2 id="b-h" class="sec-title"><?php esc_html_e( 'در این مسیر چه می‌آموزید؟', 'aram-zist' ); ?></h2>
	<ul class="benefits">
		<?php foreach ( array( 'خودشناسی', 'اعتماد به نفس', 'مدیریت استرس', 'روابط بهتر', 'هوش هیجانی' ) as $b ) { echo '<li>' . aram_icon( 'check' ) . esc_html( $b ) . '</li>'; } // phpcs:ignore ?>
	</ul>
</section>

<?php
$posts = new WP_Query( array( 'posts_per_page' => 3, 'ignore_sticky_posts' => true, 'no_found_rows' => true ) );
if ( $posts->have_posts() ) : ?>
<section class="section wrap" aria-labelledby="free-h">
	<div class="sec-head"><h2 id="free-h" class="sec-title"><?php esc_html_e( 'محتوای آموزشی رایگان', 'aram-zist' ); ?></h2></div>
	<div class="post-grid">
		<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
		<article class="post-card">
			<?php if ( has_post_thumbnail() ) { echo '<a href="' . esc_url( get_permalink() ) . '" tabindex="-1" aria-hidden="true">'; the_post_thumbnail( 'aram-course', array( 'loading' => 'lazy' ) ); echo '</a>'; } ?>
			<div class="post-card-body"><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3></div>
		</article>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>
</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/testimonials' ); get_template_part( 'template-parts/faq' ); ?>

<section class="wrap section">
	<div class="cta-band">
		<div><h2><?php echo esc_html( aram_opt( 'cta_title' ) ); ?></h2><p><?php echo esc_html( aram_opt( 'cta_text' ) ); ?></p></div>
		<a class="btn btn-orange" href="<?php echo esc_url( aram_shop_url() ); ?>"><?php esc_html_e( 'مشاهده فروشگاه', 'aram-zist' ); ?></a>
	</div>
</section>
<?php get_footer(); ?>
