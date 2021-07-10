<?php
/**
 * Template for displaying loop course of section.
 *
 * @author  ThimPress
 * @package  CourseBuilder/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if ( ! isset( $section ) ) {
	return;
}

?>

<li class="section" id="section-<?php echo esc_attr( $section->get_id() ); ?>"
    data-id="<?php echo esc_attr( $section->get_id() ); ?>">

	<?php
	/**
	 * @since  3.0.0
	 *
	 * @see learn_press_curriculum_section_title - 5
	 * @see learn_press_curriculum_section_content - 10
	 */
	do_action( 'learn-press/section-summary', $section ); ?>

</li>