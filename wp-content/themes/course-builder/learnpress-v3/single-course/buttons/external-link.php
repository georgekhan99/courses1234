<?php
/**
 * Template for displaying Continue button in single course.
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
?>

<form name="course-external-link" class="course-external-link form-button lp-form" method="get"
      action="<?php echo esc_url( $course->get_external_link() ); ?>">

    <button type="submit" class="lp-button button"><?php echo esc_html( $course->get_external_link_text() ); ?></button>

</form>
