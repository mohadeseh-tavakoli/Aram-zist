<?php
$q = new WP_Query( array( 'post_type' => 'aram_faq', 'posts_per_page' => 10, 'orderby' => 'menu_order date', 'order' => 'ASC', 'no_found_rows' => true ) );
if ( ! $q->have_posts() && ! current_user_can( 'edit_theme_options' ) ) { return; }
?>
<section class="section wrap narrow" aria-labelledby="f-h">
	<h2 id="f-h" class="sec-title"><?php esc_html_e( 'سؤالات متداول', 'aram-zist' ); ?></h2>
	<?php if ( $q->have_posts() ) : $i = 0; ?>
	<div class="faq">
		<?php while ( $q->have_posts() ) : $q->the_post(); $i++; ?>
		<div class="faq-item">
			<h3><button aria-expanded="false" aria-controls="faq-<?php echo (int) $i; ?>"><?php the_title(); ?></button></h3>
			<div id="faq-<?php echo (int) $i; ?>" class="faq-panel" hidden><?php the_content(); ?></div>
		</div>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>
	<?php else : ?><p class="notice"><?php esc_html_e( 'سؤالی ثبت نشده است. از منوی «سؤالات متداول» در پیشخوان اضافه کنید (فقط مدیر این پیام را می‌بیند).', 'aram-zist' ); ?></p><?php endif; ?>
</section>
