<?php
/**
 * Template for displaying content of landing course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/coming-soon-courses/content-single-course.php.
 *
 * @author ThimPress
 * @package LearnPress/Coming-Soon-Courses/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;
?>

<?php do_action( 'learn_press_before_content_coming_soon' ); ?>

	<figure class="thim-coming-soon-course">
			<?php
			$image_title   = get_the_title( get_post_thumbnail_id() ) ? esc_attr( get_the_title( get_post_thumbnail_id() ) ) : '';
			$image_caption = get_post( get_post_thumbnail_id() ) ? esc_attr( get_post( get_post_thumbnail_id() )->post_excerpt ) : '""';
			$image_link    = wp_get_attachment_url( get_post_thumbnail_id() );
			$image         = get_the_post_thumbnail( $post->ID, apply_filters( 'single_course_image_size', 'single_course' ), array(
				'title' => $image_title,
				'alt'   => $image_title
			) );

			echo $image = '<img src="' . esc_url( $image_link ) . '" alt="' . esc_attr( $image_title ) . '" title="' . esc_attr( $image_title ) . '" class="no-cropped"/>';

			?>
		<div class="wrap-countdown">
			<?php do_action( 'learn_press_content_coming_soon_countdown' ); ?>
		</div>
		<figcaption class="course-info">
			<h4 class="status"><?php esc_html_e( 'Coming Soon', 'course-builder' ); ?></h4>
			<?php if ( $post->post_excerpt ): ?>
				<p class="excerpt"><?php echo( $post->post_excerpt ); ?></p>
			<?php endif; ?>
		</figcaption>
	</figure>

<?php do_action( 'learn_press_content_coming_soon_message' ); ?>

<?php do_action( 'learn_press_content_coming_soon_content_tabs' ); ?>

<?php do_action( 'learn_press_content_coming_soon_meta_details' ); ?>

<?php do_action( 'learn_press_after_content_coming_soon' ); ?>