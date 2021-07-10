<?php
/**
 * Template Name: Home Page
 *
 **/
get_header();
?>
	<div id="home-main-content" class="home-content home-page container" role="main">
		<?php
		while ( have_posts() ) : the_post();
			the_content();
		endwhile;
		?>
	</div><!-- #home-main-content -->
<?php get_footer();
