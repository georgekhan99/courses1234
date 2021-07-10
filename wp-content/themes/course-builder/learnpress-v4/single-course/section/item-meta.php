<?php
/**
 * Template for displaying item section meta in single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/section/item-meta.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$user   = learn_press_get_current_user();
$course = learn_press_get_course( $section->get_course_id() );

$item_id   = $item->get_id();
$course_id = $section->get_course_id();

$item_status = $user->get_item_status( $item_id, $course_id );

?>

<span class="course-item-meta">

	<?php do_action( 'learn-press/course-section-item/before-' . $item->get_item_type() . '-meta', $item ); ?>

	<?php if ( $item->is_preview() && ! $user->has_completed_item( $item->get_id(), $course->get_id() ) ): ?>

        <span class="lp-label lp-label-preview"><?php esc_html_e( 'Preview', 'course-builder' ); ?></span>

	<?php else: ?>

		<?php
		if ( $user->can_view_item( $item_id, $course_id ) !== false ) {
			if ( get_post_type( $item_id ) == 'lp_quiz' ) {
				if ( $course->is_final_quiz( $item_id ) ) {
					?>
					<span class="lp-label item-loop-meta-text item-final"><?php esc_html_e( 'Final Quiz', 'course-builder' ); ?></span>
					<?php
				}
				if ( $item_status == 'completed' ) {
					

					if ( $item->get_status_title() === 'Passed' ) {
						?>
						<span class="lp-icon item-status item-has-status item-status-passed" title="<?php esc_attr_e( 'Passed', 'course-builder' ); ?>"></span>
					<?php } else {
						?>
						<span class="lp-icon item-status item-has-status item-status-failed" title="<?php esc_attr_e( 'Failed', 'course-builder' ); ?>"></span>
						<?php
					}
				} elseif ( $item_status == 'started' ) {
					?>
					<span class="lp-label lp-label-in-progress"><?php esc_html_e( 'In Progress', 'course-builder' ); ?></span>
					<?php
				} elseif ( $item_status == 'viewed' ){
					?>
					<span class="lp-icon item-status item-has-status item-status-viewed" title="<?php esc_attr_e( 'Viewed', 'course-builder' ); ?>"></span>
					<?php
				} else {
					echo '<span class="lp-icon item-status"></span>';
				}
			} else {
				if ( $item_status == 'completed' ) {
					?>
					<span class="lp-icon item-status item-has-status item-status-completed" title="<?php esc_attr_e( 'Completed', 'course-builder' ); ?>"></span>
					<?php
				} elseif ( $item_status == 'started' ||  $item_status == 'viewed' ) {
					?>
                    <span class="lp-icon item-status item-has-status"></span>
					<?php
				}
				else {
					echo '<span class="lp-icon item-status"></span>';
				}
			}
		}else {
			echo '<span class="lp-icon item-status"></span>';
		}
		?>

	<?php endif; ?>

	<?php do_action( 'learn-press/course-section-item/after-' . $item->get_item_type() . '-meta', $item ); ?>

</span>
