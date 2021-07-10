<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package thim
 */
if ( ! is_active_sidebar( 'sidebar_courses' ) ) {
	return;
}
$thim_options = get_theme_mods();
$sticky_sidebar = isset( $thim_options['sticky_sidebar'] ) && ( $thim_options['sticky_sidebar'] == true ) ? ' sticky-sidebar' : '';


$wrapper_layout = 'sidebar-left';

$option_name = 'learnpress_archive_layout';

if ( is_single() ){

    $option_name = 'learnpress_single_layout';

    if ( thim_check_is_course_taxonomy() ) {
        $option_name = 'learnpress_archive_layout';
    }
}

if ( get_theme_mod( $option_name ) != '' ) {
	$wrapper_layout = get_theme_mod( $option_name );
}

// Get class layout
$sidebar_class_col = 'flex-last';
if ( $wrapper_layout == 'sidebar-left' ) {
	$sidebar_class_col = "flex-first";
}
if ( $wrapper_layout == 'sidebar-right' ) {
	$sidebar_class_col = 'flex-last';
}

?>
<?php if ( $wrapper_layout != 'full-sidebar' ) { ?>
	<aside id="secondary" class="sidebar-courses widget-area col-md-3<?php echo esc_attr( $sticky_sidebar ); ?> <?php echo esc_attr( $sidebar_class_col ); ?>">

        <?php do_action( 'thim_before_sidebar_course' ); ?>

        <?php if ( ! dynamic_sidebar( 'sidebar_courses' ) ) :
			dynamic_sidebar( 'sidebar_courses' );
		endif; // end sidebar widget area ?>

	</aside><!-- #secondary -->
<?php } ?>