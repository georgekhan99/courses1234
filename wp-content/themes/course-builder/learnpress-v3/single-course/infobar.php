<?php
/**
 * Template for displaying infobar of landing course.
 *
 * @author  ThimPress
 * @package  CourseBuilder/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>

<?php
$course_info_button = get_post_meta( get_the_ID(), 'thim_course_info_button', true );
$course_includes    = get_post_meta( get_the_ID(), 'thim_course_includes', true );
?>

<div class="info-bar">

	<?php if ( function_exists( 'learn_press_course_price' ) ) { ?>
        <div class="price-box">

	        <?php
	        global  $post;
	        $course_pri      = LP_Course::get_course( $post->ID );
	        $is_required = $course_pri->is_required_enroll();

	        if ( $course_pri->is_free() || ! $is_required ) : ?>
                <span class="course-price"><?php echo esc_html__( 'Free', 'course-builder' ). '</span>';
            else:
	            learn_press_course_price();
            endif;
		        ?>
        </div>
	<?php } ?>

    <div class="inner-content">
        <div class="button-box">
			<?php learn_press_course_buttons(); ?>
			<?php if ( ! empty( $course_info_button ) ) { ?>
                <p class="intro"><?php echo ent2ncr( $course_info_button ); ?></p>
			<?php } ?>
        </div>

		<?php if ( ! empty( $course_includes ) ) { ?>
            <div class="includes-box">
				<?php echo ent2ncr( $course_includes ); ?>
            </div>
		<?php } ?>

		<?php thim_social_share( 'learnpress_single_' ); ?>
    </div>

</div>