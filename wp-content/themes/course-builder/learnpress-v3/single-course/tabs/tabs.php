<?php
/**
 * Template for displaying tab nav of single course.
 *
 * @author   ThimPress
 * @package  CourseBuilder/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>

<?php
// course tabs
$tabs = learn_press_get_course_tabs();
$theme_options_data = get_theme_mods();

if ( empty( $tabs ) ) {
	return;
}

$active_tab = get_theme_mod('default_tab_course');


?>
<div class="course-tabs learn-press-tabs" id="learn-press-course-tabs">
	<div class="nav-tabs-wrapper">
		<div class="container">
			<ul class="learn-press-nav-tabs course-nav-tabs" data-cookie="tab-cookie" data-cookie2="tab-id">

				<?php foreach ( $tabs as $key => $tab ) { ?>

					<?php $classes = array( 'learn-press-nav-tab course-nav course-nav-tab-' . esc_attr( $key ) );

                    if ( $active_tab === $tab['id'] ) {
                        $classes[] = 'active default';
                    }

                    ?>

					<li class="<?php echo join( ' ', $classes ); ?>">
						<a href="?tab=<?php echo esc_attr( $tab['id'] ); ?>"
						   data-tab="#<?php echo esc_attr( $tab['id'] ); ?>"><?php echo $tab['title']; ?></a>
					</li>

				<?php } ?>

			</ul>
		</div>
	</div>
	<div class="tabs-wrapper">
		<div class="container">
			<?php foreach ( $tabs as $key => $tab ) { ?>

				<div class="course-tab-panel-<?php echo esc_attr( $key ); ?> course-tab-panel <?php if ( $active_tab === $tab['id'] ) { echo 'active';} ?>"
				     id="<?php echo esc_attr( $tab['id'] ); ?>">

					<?php
					if ( apply_filters( 'learn_press_allow_display_tab_section', true, $key, $tab ) ) {
						if ( is_callable( $tab['callback'] ) ) {
							call_user_func( $tab['callback'], $key, $tab );
						} else {
							/**
							 * @since 3.0.0
							 */
							do_action( 'learn-press/course-tab-content', $key, $tab );
						}
					}
					?>

				</div>

			<?php } ?>
		</div>
	</div>
</div>