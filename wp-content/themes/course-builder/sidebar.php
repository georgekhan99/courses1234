<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 */
if ( ! is_active_sidebar( 'sidebar' ) || ( isset( $_GET['layout'] ) && ( $_GET['layout'] === 'no-sidebar' ) ) ) {
	return;
}

$thim_options = get_theme_mods();
$sticky_sidebar = isset( $thim_options['sticky_sidebar'] ) && ( $thim_options['sticky_sidebar'] == true ) ? ' sticky-sidebar' : '';

if ( get_post_type() != 'lp_collection' ) {
	?>

	<aside id="secondary" class="widget-area col-sm-12 col-md-3<?php echo esc_attr( $sticky_sidebar ); ?>">
		<?php dynamic_sidebar( 'sidebar' ); ?>
	</aside><!-- #secondary -->
<?php } ?>