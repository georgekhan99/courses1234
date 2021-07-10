<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */
$postid = get_the_ID();
$class  = '';
if ( get_post_meta( $postid, 'thim_custom_layout', true ) != 'no-sidebar' ) {
	$class = get_post_meta( $postid, 'thim_custom_layout', true );
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
	<div class="entry-content">
		<?php
		the_content();
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'course-builder' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
