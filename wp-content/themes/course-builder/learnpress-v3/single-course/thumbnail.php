<?php
/**
 * Template for displaying thumbnail of single course.
 *
 * @author   ThimPress
 * @package  CourseBuilder/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $post;
$course = learn_press_get_course();
$user   = LP_Global::user();

$video_embed      = $course->get_video_embed();
$video_intro      = get_post_meta( get_the_ID(), 'thim_course_media', true );
$thim_course_page = get_option( 'learn_press_single_course_image_size' );
$width            = ! empty ( $thim_course_page['width'] ) ? $thim_course_page['width'] : 1022;
$height           = ! empty ( $thim_course_page['height'] ) ? $thim_course_page['height'] : 608;
?>

<?php if ( $video_embed ) { ?>
    <div class="course-video"><?php echo esc_attr( $video_embed ); ?></div>
<?php } ?>

<?php if ( ! has_post_thumbnail() || $video_embed ) {
	return;
} ?>

<div class="course-thumbnail">
	<?php
	$image_title   = get_the_title( get_post_thumbnail_id() ) ? esc_attr( get_the_title( get_post_thumbnail_id() ) ) : '';
	$image_caption = get_post( get_post_thumbnail_id() ) ? esc_attr( get_post( get_post_thumbnail_id() )->post_excerpt ) : '""';
	$image_link    = wp_get_attachment_image_src( get_post_thumbnail_id(), array( $width, $height ) );

	$image = '<img src="' . esc_url( $image_link[0] ) . '" alt="' . esc_attr( $image_title ) . '" title="' . esc_attr( $image_title ) . '" />';
 	if ( learn_press_is_learning_course() ) {
		thim_thumbnail( $course->get_id(), '647x399', 'post', false );
	} else {
		echo( $image );
	} ?>
	<?php if ( $video_intro ) {
		wp_enqueue_script( 'magnific-popup' );
		?>
        <a href="<?php echo esc_url( $video_intro ); ?>" class="play-button video-thumbnail">
            <span class="video-thumbnail hvr-push"></span>
        </a>
	<?php } ?>
    <div class="time">
        <div class="date-start"><?php echo get_the_date( 'd' ); ?></div>
        <div class="month-start"><?php echo get_the_date( 'M' ); ?></div>
    </div>
</div>
