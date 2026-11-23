<?php
$q = new WP_Query( array( 'post_type' => 'aram_testimonial', 'posts_per_page' => 8, 'no_found_rows' => true ) );
?>
<section class="section wrap" aria-labelledby="t-h">
	<h2 id="t-h" class="sec-title"><?php esc_html_e( 'نظرات هنرجویان', 'aram-zist' ); ?></h2>
	<?php if ( $q->have_posts() ) : ?>
	<div class="slider" data-slider>
		<button class="icon-btn slider-prev" aria-label="<?php esc_attr_e( 'قبلی', 'aram-zist' ); ?>"><?php echo aram_icon( 'prev' ); // phpcs:ignore ?></button>
		<div class="slider-track" tabindex="0">
			<?php while ( $q->have_posts() ) : $q->the_post(); $r = (int) get_post_meta( get_the_ID(), '_aram_rating', true ); ?>
			<blockquote class="review">
				<?php echo aram_stars( $r ? $r : 5 ); // phpcs:ignore ?>
				<div><?php the_content(); ?></div>
				<footer><?php if ( has_post_thumbnail() ) { the_post_thumbnail( array( 56, 56 ), array( 'loading' => 'lazy' ) ); } ?><cite><?php the_title(); ?></cite></footer>
			</blockquote>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
		<button class="icon-btn slider-next" aria-label="<?php esc_attr_e( 'بعدی', 'aram-zist' ); ?>"><?php echo aram_icon( 'next' ); // phpcs:ignore ?></button>
	</div>
	<?php elseif ( current_user_can( 'edit_theme_options' ) ) : ?>
	<p class="notice"><?php esc_html_e( 'هنوز نظری ثبت نشده است. از منوی «نظرات هنرجویان» در پیشخوان نظر اضافه کنید (فقط مدیر این پیام را می‌بیند).', 'aram-zist' ); ?></p>
	<?php endif; ?>
</section>
