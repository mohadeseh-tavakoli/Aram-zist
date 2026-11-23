<?php
/* Template Name: درباره من */
get_header();
$blocks = array(
	'تحصیلات و گواهینامه‌ها' => 'about_education',
	'سوابق کاری'             => 'about_experience',
	'حوزه‌های تخصص'          => 'about_expertise',
	'دستاوردها'              => 'about_achievements',
);
?>
<section class="page-hero"><div class="wrap split">
	<div><h1><?php the_title(); ?></h1><p><?php echo esc_html( aram_opt( 'about_short' ) ); ?></p></div>
	<img src="<?php echo esc_url( ARAM_URI . '/assets/images/portrait.jpg' ); ?>" width="700" height="394" alt="">
</div></section>
<div class="wrap section narrow entry">
	<?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
	<h2><?php esc_html_e( 'فلسفه کاری', 'aram-zist' ); ?></h2><p><?php echo esc_html( aram_opt( 'about_philosophy' ) ); ?></p>
	<?php foreach ( $blocks as $label => $key ) : ?>
		<h2><?php echo esc_html( $label ); ?></h2>
		<ul class="checks"><?php foreach ( aram_lines( aram_opt( $key ) ) as $l ) { echo '<li>' . aram_icon( 'check' ) . esc_html( $l ) . '</li>'; } // phpcs:ignore ?></ul>
	<?php endforeach; ?>
	<h2><?php esc_html_e( 'شیوه تدریس', 'aram-zist' ); ?></h2><p><?php echo esc_html( aram_opt( 'about_teaching' ) ); ?></p>
	<p><a class="btn btn-orange" href="<?php echo esc_url( aram_shop_url() ); ?>"><?php esc_html_e( 'مشاهده دوره‌ها', 'aram-zist' ); ?></a></p>
</div>
<?php get_footer(); ?>
