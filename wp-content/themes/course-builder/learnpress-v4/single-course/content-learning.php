<?php
/**
 * Template for displaying content of learning course.
 *
 * @author      ThimPress
 * @package     CourseBuilder/Templates
 * @version     4.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();


$course = LP_Global::course();
if ( ! $course ) {
	return;
}
$page_title = thim_page_title();

/**
 * Extract $page_title to parameters
 *
 * @var $main_css
 * @var $overlay_css
 */

extract( $page_title );

$postid               = get_queried_object_id();
$using_custom_heading = get_post_meta( $postid, 'thim_enable_custom_title', true );

$custom_title_display_title  = get_post_meta( $postid, 'thim_group_custom_title_hide_title', true );
$custom_title                = get_post_meta( $postid, 'thim_group_custom_title_new_title', true );
$custom_description          = get_post_meta( $postid, 'thim_group_custom_title_custom_sub_title', true );
$custom_title_hide_sub_title = get_post_meta( $postid, 'thim_group_custom_title_hide_sub_title', true );

?>


<div class="header-course">
    <div class="header-course-bg" <?php echo ent2ncr( $main_css ); ?>>
        <span class="overlay-top-header" <?php echo ent2ncr( $overlay_css ); ?>></span>
    </div>
    <div class="header-content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
					<?php learn_press_get_template( 'single-course/thumbnail.php' ); ?>
                </div>
                <div class="col-md-6">
                    <div class="header-info">
						<?php
						$postid               = get_queried_object_id();
						$using_custom_heading = get_post_meta( $postid, 'thim_enable_custom_title', true );
						if ( $using_custom_heading && ( $custom_title_display_title == false ) ) {
							?>
                            <h1 class="course-title"><?php echo $custom_title; ?></h1>
							<?php
						} elseif ( $using_custom_heading && ( $custom_title_display_title == true ) ) {
						} else { ?>
                            <h1 class="course-title"><?php the_title(); ?></h1>
						<?php }
						?>

						<?php

						if ( get_the_excerpt() && has_excerpt() && ! $using_custom_heading ) { ?>
                            <p class="description">
								<?php echo wp_trim_words( get_the_excerpt(), 35 ); ?>
                            </p>
						<?php } elseif ( $using_custom_heading && get_the_excerpt() && has_excerpt() && ( $custom_title_hide_sub_title == false ) ) { ?>
                            <p class="description">
								<?php echo $custom_description; ?>
                            </p>
						<?php } else {
						} ?>
                    </div>

					<?php learn_press_get_template( 'single-course/progress.php' );
					// get course bbpress forum
					$forum_enable = get_post_meta( $course->get_id(), '_lp_bbpress_forum_enable', true );
					if ( $forum_enable == 'yes' && class_exists( 'LP_Addon_bbPress' ) && class_exists( 'bbPress' ) ) { ?>
                        <div class="forum-section">
                            <span class="label"><?php esc_html_e( 'Visit Forum: ', 'course-builder' ); ?></span>
							<?php LP_Addon_bbPress::instance()->forum_link(); ?>
                        </div>
					<?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="course-learning-summary">
	<div class="container">
		<?php do_action( 'learn-press/content-learning' ); ?>

        <?php do_action('theme_course_extra_boxes'); ?>
	</div>
</div>

