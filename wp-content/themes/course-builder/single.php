<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */
?>

<?php
while ( have_posts() ) : the_post(); ?>
	<?php get_template_part( 'templates/template-parts/content', 'single' ); ?>
<?php endwhile; // end of the loop. ?>
