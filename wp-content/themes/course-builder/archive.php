<?php
/**
 * The template for displaying archive pages.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 */

$thim_options = get_theme_mods();
$pagination   = isset( $_GET['pagination'] ) ? $_GET['pagination'] : get_theme_mod( 'blog_archive_nav_style', 'pagination' );
$style        = isset( $_GET['style'] ) ? $_GET['style'] : get_theme_mod( 'archive_post_layout', 'list' );
$get_style    = isset( $_GET['style'] ) ? $_GET['style'] : 'false';

if ( have_posts() ) :?>
	<!--	Top Box-->
	<?php
	$top_box = isset( $_GET['top-box'] ) ? $_GET['top-box'] : get_theme_mod( 'topbox_archive_content_display', false );
	if ( $top_box == '1' || $top_box == 'true' ) {
		wp_enqueue_script( 'thim-change-layout' );
		?>
 		<div class="top-box">
			<?php thim_get_top_box(); ?>
		</div>
	<?php } ?>
	<div class="list-articles row style-<?php echo esc_attr( $style ); ?> " data-getstyle="<?php echo esc_attr( $get_style ); ?>">
		<?php
		/* Start the Loop */
		while ( have_posts() ) : the_post();
			get_template_part( 'templates/template-parts/content' );
		endwhile;
		?>
	</div><!-- .list-articles.blog-list -->
	<?php

	// Load More button
	if ( $pagination == 'loadmore' ) {
		global $wp_query;
		// don't display the button if there are not enough posts
		if ( $wp_query->max_num_pages > 1 ) {
			echo '<div class="thim-loadmore" data-style="'.esc_attr( $style ).'"> <button type="button" class="btn btn-default load-more">' . esc_attr__( 'LOAD MORE', 'course-builder' );
			ob_start();
			echo ob_get_contents();
			thim_loading_icon();
			echo '</button></div>';
		}
	} else {
		thim_paging_nav();
	}
	?>
	<?php
else :
	get_template_part( 'templates/template-parts/content', 'none' );
endif;