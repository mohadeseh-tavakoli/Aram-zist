<?php get_header(); ?>
<section class="page-hero"><div class="wrap"><h1><?php echo is_search() ? esc_html( sprintf( __( 'نتایج جستجو برای «%s»', 'aram-zist' ), get_search_query() ) ) : wp_kses_post( get_the_archive_title() ); ?></h1></div></section>
<div class="wrap section">
	<?php if ( have_posts() ) : ?>
	<div class="post-grid">
		<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class( 'post-card' ); ?>>
			<?php if ( has_post_thumbnail() ) { echo '<a href="' . esc_url( get_permalink() ) . '">'; the_post_thumbnail( 'aram-course', array( 'loading' => 'lazy' ) ); echo '</a>'; } ?>
			<div class="post-card-body"><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p></div>
		</article>
		<?php endwhile; ?>
	</div>
	<?php the_posts_pagination( array( 'prev_text' => '→', 'next_text' => '←' ) ); ?>
	<?php else : ?><p><?php esc_html_e( 'مطلبی یافت نشد.', 'aram-zist' ); ?></p><?php endif; ?>
</div>
<?php get_footer(); ?>
