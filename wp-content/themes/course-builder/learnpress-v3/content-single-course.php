<?php
/**
 * Template for displaying course content within the loop.
 *
 * @author      ThimPress
 * @package     CourseBuilder/Templates
 * @version     3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if ( post_password_required() ) {
	echo get_the_password_form();

	return;
}

$course = LP_Global::course();
$user   = LP_Global::user();

$layouts = get_theme_mod( 'learnpress_single_course_style', 1 );

$layouts = isset( $_GET['layout'] ) ? $_GET['layout'] : $layouts;
?>

<?php
/**
 * @since 3.0.0
 */
do_action( 'learn-press/before-main-content' );

do_action( 'learn-press/before-single-course' );
?>

	<div id="learn-press-course">
		<div class="course-summary">
			<?php if ( learn_press_is_learning_course() ) {
				learn_press_get_template( 'single-course/content-learning.php', array( 'course' => $course ) );
			} else {
				learn_press_get_template( 'single-course/content-landing-' . $layouts . '.php' );
			} ?>
		</div>
	</div>

<?php
/**
 * @since 3.0.0
 */
do_action( 'learn-press/after-main-content' );

do_action( 'learn-press/after-single-course' );


/**
 * @deprecated
 */
