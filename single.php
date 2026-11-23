<?php get_header(); while ( have_posts() ) : the_post(); ?>
<article <?php post_class( 'wrap section narrow entry' ); ?>>
	<h1><?php the_title(); ?></h1>
	<p class="meta"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></p>
	<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large' ); } ?>
	<?php the_content(); ?>
	<?php if ( comments_open() || get_comments_number() ) { comments_template(); } ?>
</article>
<?php endwhile; get_footer(); ?>
