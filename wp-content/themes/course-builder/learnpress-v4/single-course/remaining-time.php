<?php
/**
 * Template for displaying the remaining time for course.
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 3.2.0
 */

defined( 'ABSPATH' ) or die();

$user = LP_Global::user();
$course = LP_Global::course();
if ( ! $course || ! $user ) {
	return;
}
if ( ! $user->has_enrolled_course( $course->get_id() ) || get_theme_mod( 'thim_learnpress_course_results', true ) == false ) {
	return;
}


if ( isset( $remaining_time ) && $course->get_duration() ) {
?>
<div class="course-remaining-time message message-warning learn-press-message">
    <p>
        <?php learn_press_label_html( __( 'Enrolled', 'course-builder' ), 'enrolled' ); ?>

		<?php echo sprintf( __( 'You have %s remaining for the course', 'course-builder' ), $remaining_time );?>
    </p>
</div>
<?php }?>