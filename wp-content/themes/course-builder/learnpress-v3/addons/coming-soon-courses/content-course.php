<?php
/**
 * Template for displaying course content within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/coming-soon-courses/content-course.php.
 *
 * @author ThimPress
 * @package LearnPress/Coming-Soon-Courses/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$message = '';
$course  = LP_Global::course();;
if ( ! $course ) {
	return;
}
$theme_options_data = get_theme_mods();
$column_product     = 4;
if ( isset( $theme_options_data['learnpress_cate_collection_column'] ) && ( $theme_options_data['learnpress_cate_collection_column'] <> '' ) && ( get_query_var( 'post_type' ) == 'lp_collection' ) ) {
	$column_product = 12 / $theme_options_data['learnpress_cate_collection_column'];
} else if ( isset( $theme_options_data['learnpress_cate_grid_column'] ) && $theme_options_data['learnpress_cate_grid_column'] <> '' && $theme_options_data['learnpress_cate_style'] == 'grid' ) {
	$column_product = 12 / $theme_options_data['learnpress_cate_grid_column'];
}
if ( ! empty( $_REQUEST['cols'] ) ) {
	$column_product = 12 / $_REQUEST['cols'];
}
$classes[] = 'col-md-' . $column_product . ' col-sm-6 col-xs-6 lpr-course coming-soon';

$width        = $height = '';
$lp_thumbnail = get_option( 'learn_press_course_thumbnail_image_size' );
if ( $lp_thumbnail ) {
	$width  = $lp_thumbnail['width'];
	$height = $lp_thumbnail['height'];
} else {
	$width  = 320;
	$height = 355;
}
$thumbnail_size = $width . 'x' . $height;

$course_id = $course->get_id();
$link      = learn_press_user_profile_link( get_the_author_meta( 'ID' ) );

if ( learn_press_is_coming_soon( $course_id ) && '' !== ( $message = get_post_meta( $course_id, '_lp_coming_soon_msg', true ) ) ) {
	$message = strip_tags( $message );
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ) ?>>
	<div class="content">
		<div class="thumbnail">
			<?php if ( has_post_thumbnail() ) : ?>
				<a href="<?php the_permalink(); ?>" class="img_thumbnail"> <?php echo thim_get_thumbnail( get_the_ID(), $thumbnail_size, 'post', false ); ?> </a>
			<?php endif; ?>
			<span class="status price"><?php esc_html_e( 'Coming Soon', 'course-builder' ); ?></span>
		</div>

		<div class="sub-content">
			<h3 class="title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
			<div class="date-comment">
				<?php echo get_the_date() . ' / '; ?>
				<?php $comment = get_comments_number();
				if ( $comment == 0 ) {
					echo esc_html__( "No Comments", 'course-builder' );
				} else {
                    echo sprintf( _n( '%d Comment', '%d Comments', $comment, 'course-builder' ), $comment);
                }
				?>
			</div>
			<div class="content-list">
				<div class="course-description">
					<?php
					do_action( 'learn_press_before_course_content' );
					the_excerpt();
					do_action( 'learn_press_after_course_content' );
					?>
				</div>

				<ul class="courses_list_info">
					<li>
						<span class="avatar">
							<a href="<?php echo esc_url( $link ); ?>">
								<?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
							</a>
						</span>
						<span class="info">
							<span class="major"><?php echo esc_html__( 'Teacher', 'course-builder' ); ?></span>
							<a href="<?php echo esc_url( $link ); ?>" class="name">
								<?php echo get_the_author(); ?>
							</a>
						</span>
					</li>
				</ul>
			</div>
		</div>
	</div>
</article>