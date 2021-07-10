<?php

/**
 * Template for displaying the list of course content is in wishlist.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/wishlist/wishlist-content.php.
 *
 * @author  ThimPress
 * @package LearnPress/Wishlist/Templates
 * @version 3.0.1
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

global $post;
?>

<!--<li id="learn-press-tab-wishlist-course-<?php /*echo $post->ID; */ ?>" class="course" data-context="tab-wishlist">

	<?php /*do_action( 'learn_press_before_profile_tab_wishlist_loop_course' ); */ ?>
	<a href="<?php /*the_permalink(); */ ?>" class="course-title">
		<?php /*do_action( 'learn_press_wishlist_loop_item_title' ); */ ?>
	</a>
	<?php /*do_action( 'learn_press_after_profile_tab_wishlist_loop_course' ); */ ?>

	<?php /*LP_Addon_Wishlist::instance()->wishlist_button( $post->ID ); */ ?>
</li>-->

<?php
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
$classes[] = 'col-md-' . $column_product . ' col-sm-6 col-xs-6 lpr-course';

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

$course_id = get_the_ID();
$course    = learn_press_get_course( $course_id );
$price     = $course->get_origin_price_html();
if ( class_exists( 'LP_Addon_Course_Review' ) ) {
	$course_number_vote       = learn_press_get_course_rate_total( $course_id );
	$html_course_number_votes = $course_number_vote ? sprintf( _n( '(%1$s vote )', ' (%1$s votes)', $course_number_vote, 'course-builder' ), number_format_i18n( $course_number_vote ) ) : esc_html__( '(0 vote)', 'course-builder' );
}
$count = $course->get_users_enrolled() ? $course->get_users_enrolled() : 0;

$extra_class = '';
if ( ! empty( $course_number_vote ) ) {
	$extra_class = 'review-course';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>

	<?php do_action( 'learn_press_before_profile_tab_wishlist_loop_course' ); ?>

	<div class="content">

		<div class="thumbnail">
			<?php if ( $course->has_sale_price() ) { ?>
				<span class="sale">
                    <span class="text-sale"><?php esc_html_e( 'Sale', 'course-builder' ); ?></span>
                </span>
			<?php } ?>

			<?php if ( has_post_thumbnail() ) : ?>
				<a href="<?php the_permalink(); ?>" class="img_thumbnail">
					<?php echo thim_get_thumbnail( $course_id, $thumbnail_size, 'post', false ); ?>
				</a>
			<?php endif; ?>

			<?php if ( $price >= 0 ): ?>
				<span class="price"><?php learn_press_course_price(); ?></span>
			<?php endif; ?>

			<?php if ( class_exists( 'LP_Addon_Course_Review' ) ): ?>
				<div class="review <?php echo esc_attr( $extra_class ) ?>">
					<div class="sc-review-stars">
						<?php $course_rate = learn_press_get_course_rate( $course_id ); ?>
						<?php learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) ); ?>
					</div>
					<?php if ( ! empty( $html_course_number_votes ) ): ?>
						<span class="vote"><?php echo esc_attr( $html_course_number_votes ); ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="sub-content">
			<h3 class="title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
			<div class="date-comment">
				<?php echo get_the_date() . ' / ';
				$comment = get_comments_number();
				if ( $comment == 0 ) {
					echo esc_html__( "No Comments", 'course-builder' );
				} else {
                    echo sprintf( _n( '%d Comment', '%d Comments', $comment, 'course-builder' ), $comment);
                } ?>
			</div>

			<div class="content-list">
				<div class="course-description">
					<?php the_excerpt(); ?>
				</div>
			</div>
		</div>
	</div>

	<?php do_action( 'learn_press_after_profile_tab_wishlist_loop_course' ); ?>

	<?php LP_Addon_Wishlist::instance()->wishlist_button( $post->ID ); ?>

</article>