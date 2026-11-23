<?php get_header(); while ( have_posts() ) : the_post(); ?>
<section class="page-hero"><div class="wrap"><h1><?php the_title(); ?></h1></div></section>
<div class="wrap section narrow entry"><?php the_content(); ?></div>
<?php endwhile; get_footer(); ?>
