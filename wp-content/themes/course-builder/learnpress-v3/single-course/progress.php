<?php
/**
 * Template for displaying progress of single course.
 *
 * @author   ThimPress
 * @package  CourseBuilder/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$course = LP_Global::course();
$user   = LP_Global::user();

if ( ! $course || ! $user ) {
	return;
}

// get course id
$course_id = $course->get_id();

if ( ! $user->has_enrolled_course( $course_id ) ) {
	return;
}

// user course data
$course_data       = $user->get_course_data( $course_id );
$course_results    = $course_data->get_results( false );
$passing_condition = $course->get_passing_condition();
$result            = round( $course_results['result'], 2 );
$grade             = $course_results['grade'];

$completed_items = $course_results['completed_items'];
$course_items    = $course->count_items( '', true );
?>

<div class="learn-press-course-results-progress">
	<div class="button-wrapper">
		<?php
		if (function_exists('learn_press_course_continue_button')){
			learn_press_course_continue_button();
		}
		?>

		<?php
		if ( function_exists( 'thim_course_wishlist_button' ) ) {
			thim_course_wishlist_button( $course_id );
		}
		?>
	</div>

    <?php if ( get_theme_mod( 'thim_learnpress_lessons_completed', true ) ) { ?>
        <div class="items-progress">

        <?php if ( false !== ( $heading = apply_filters( 'learn-press/course/items-completed-heading', __( 'Items completed', 'course-builder' ) ) ) ) { ?>
            <h4 class="lp-course-progress-heading">
                <?php echo esc_html( $heading ); ?>:  <span class="number"><?php printf( __( '%d of %d items', 'course-builder' ), $course_results['completed_items'], $course->count_items('', true) ); ?></span>
            </h4>
        <?php } ?>

        <div class="learn-press-progress lp-course-progress">
            <div class="progress-bg lp-progress-bar">
                <div class="progress-active lp-progress-value"
                     style="left: <?php echo $course_results['count_items'] ? absint( $course_results['completed_items'] / $course_results['count_items'] * 100 ) : 0; ?>%;">
                </div>
            </div>
        </div>

    </div>
    <?php } ?>

    <?php if ( get_theme_mod( 'thim_learnpress_course_results', true ) ) { ?>
        <div class="course-progress">
            <?php if ( false !== ( $heading = apply_filters( 'learn-press/course/result-heading', __( 'Course results', 'course-builder' ) ) ) ) { ?>
                <h4 class="lp-course-progress-heading">
                    <?php echo esc_html( $heading ); ?>:
                    <div class="lp-course-status">
                <span class="number"><?php echo round( $course_results['result'], 2 ); ?><span
                            class="percentage-sign">%</span></span>
                        <?php if ( $grade = $course_results['grade'] ) { ?>
                            <span class="lp-label grade <?php echo esc_attr( $grade ); ?>">
                    <?php learn_press_course_grade_html( $grade ); ?>
                    </span>
                        <?php } ?>
                    </div>
                </h4>
            <?php } ?>

            <div class="learn-press-progress lp-course-progress <?php echo $course_data->is_passed() ? ' passed' : ''; ?>"
                     data-value="<?php echo $course_results['result']; ?>"
                     data-passing-condition="<?php echo $passing_condition; ?>">
                    <div class="progress-bg lp-progress-bar">
                        <div class="progress-active lp-progress-value" style="left: <?php echo $course_results['result']; ?>%;">
                        </div>
                    </div>
                    <div class="lp-passing-conditional"
                         data-content="<?php printf( esc_html__( 'Passing condition: %s%%', 'course-builder' ), $passing_condition ); ?>"
                         style="left: <?php echo $passing_condition; ?>%;">
                    </div>
                </div>
        </div>
    <?php } ?>

</div>