<?php
/** Course card. Expects $args['product'] (WC_Product). */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$product = isset( $args['product'] ) ? $args['product'] : null;
if ( ! $product instanceof WC_Product ) { return; }
?>
<article class="course-card">
	<a class="course-thumb" href="<?php echo esc_url( $product->get_permalink() ); ?>" tabindex="-1" aria-hidden="true">
		<?php echo $product->get_image( 'aram-course', array( 'loading' => 'lazy' ) ); // phpcs:ignore ?>
		<?php if ( $product->is_on_sale() ) : ?><span class="badge"><?php esc_html_e( 'تخفیف', 'aram-zist' ); ?></span><?php endif; ?>
	</a>
	<div class="course-body">
		<h3><a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h3>
		<?php if ( $product->get_short_description() ) : ?><p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $product->get_short_description() ), 16 ) ); ?></p><?php endif; ?>
		<div class="course-meta">
			<?php if ( $product->get_review_count() ) { echo aram_stars( $product->get_average_rating() ); ?> <span class="muted">(<?php echo esc_html( number_format_i18n( $product->get_review_count() ) ); ?>)</span><?php } // phpcs:ignore ?>
		</div>
		<div class="course-foot">
			<span class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
			<a class="btn btn-sm" href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php esc_html_e( 'مشاهده دوره', 'aram-zist' ); ?></a>
		</div>
	</div>
</article>
