<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #main-content div and all content after.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 */
?>

</div><!-- #main-content -->

<?php if ( is_active_sidebar( 'after_main' ) ) : ?>
	<div class="after-main">
		<div class="container">
			<?php thim_footer_after_main_widgets(); ?>
		</div>
	</div>
<?php endif; ?>

<?php
$footer_palette = get_theme_mod( 'footer_palette', 'light' );
$footer_style   = get_theme_mod( 'footer_style' );

if ( is_page_template( 'templates/home-page.php' ) || is_page_template( 'templates/home-page-2.php' ) ) {
	$footer_color = get_post_meta( get_the_ID(), 'thim_footer_palette', true );
	if ( $footer_color != 'default' ) {
		$footer_palette = $footer_color;
	}
}

if ( is_404() ) {
	$footer_palette = 'dark';
} ?>

<footer id="colophon"
		class="site-footer <?php echo esc_attr( $footer_palette ); ?> <?php echo esc_attr( $footer_style ); ?>">
	<?php thim_footer_layout(); ?>
</footer><!-- #colophon -->
</div><!-- wrapper-container -->

<?php do_action( 'thim_space_body' ); ?>
<?php wp_footer(); ?>
</body>
</html>
