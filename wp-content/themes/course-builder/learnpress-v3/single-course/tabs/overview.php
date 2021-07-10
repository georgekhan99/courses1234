<?php
/**
 * Template for displaying overview tab of single course.
 *
 * @author  ThimPress
 * @package CourseBuilder/Templates
 * @version 3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>

<?php global $course; ?>

<?php $description_heading = apply_filters( 'learn_press_single_course_description_heading', '', $course ); ?>

<?php if ( $description_heading ) { ?>

    <h2 class="course-description-heading" id="learn-press-course-description-heading">
		<?php echo esc_attr( $description_heading ); ?>
    </h2>

<?php } ?>

<div class="course-description" id="learn-press-course-description">
	<div id="tab-overview">
		<?php do_action( 'learn_press_begin_single_course_description' ); ?>

		<?php echo $course->get_content(); ?>

		<?php do_action( 'learn_press_end_single_course_description' ); ?>
	</div>
</div>