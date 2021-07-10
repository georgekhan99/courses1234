<?php
/**
 * Template for displaying page title.
 *
 * @author  ThimPress
 * @package CourseBuilder/Templates
 * @version 1.1
 */

$page_title = thim_page_title();
$layout     = $page_title['layout'];

if ( get_post_type() == 'lp_course' && is_single() ) {
	$layout = 'layout-2';
} ?>

	<div class="page-title <?php echo esc_attr( $layout ); ?>">
		<?php get_template_part( 'templates/page-title/' . $layout ); ?>
	</div>

<?php
$top_widgetarea = isset( $_GET['top_widgetarea'] ) ? $_GET['top_widgetarea'] : get_theme_mod( 'learnpress_top_sidebar_archive_display', true );
if ( ( $top_widgetarea === '1' || $top_widgetarea === true ) && ! is_single() ) {
	if ( get_post_type() == 'lp_course' || get_post_type() == 'lp_quiz' || thim_check_is_course() || thim_check_is_course_taxonomy() ) {
		if ( is_active_sidebar( 'top_sidebar_courses' ) ) { ?>
			<div id="top-sidebar-courses">
				<div class="container">
					<?php dynamic_sidebar( 'top_sidebar_courses' ); ?>
				</div>
			</div>
			<?php {
			}
		}
	}
}
