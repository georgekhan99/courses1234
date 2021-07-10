<?php
/**
 * The Sidebar containing the main widget areas.
 *
 */
if ( ! is_active_sidebar( 'sidebar_shop' ) ) {
	return;
}
$thim_options = get_theme_mods();
$sticky_sidebar = isset( $thim_options['sticky_sidebar'] ) && ( $thim_options['sticky_sidebar'] == true ) ? ' sticky-sidebar' : '';


?>

<div id="secondary" class="widget-area col-sm-3<?php echo esc_attr( $sticky_sidebar ); ?>">
	<?php if ( ! dynamic_sidebar( 'sidebar_shop' ) ) :
		dynamic_sidebar( 'sidebar_shop' );
	endif; ?>
</div><!-- #sidebar-shop -->
