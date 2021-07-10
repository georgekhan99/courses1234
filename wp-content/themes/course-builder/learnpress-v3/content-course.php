<?php
/**
 * Template for displaying course content within the loop.
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$theme_options_data = get_theme_mods();
$column_product     = 4;
if ( isset( $theme_options_data['collection_single_columns'] ) && ( $theme_options_data['collection_single_columns'] <> '' ) && ( get_query_var( 'post_type' ) == 'lp_collection' ) ) {
	$column_product = 12 / $theme_options_data['collection_single_columns'];
} else if ( isset( $theme_options_data['learnpress_cate_grid_column'] ) && $theme_options_data['learnpress_cate_grid_column'] <> '' && $theme_options_data['learnpress_cate_style'] == 'grid' ) {
	$column_product = 12 / $theme_options_data['learnpress_cate_grid_column'];
}
if ( ! empty( $_REQUEST['cols'] ) ) {
	$column_product = 12 / $_REQUEST['cols'];
}
$classes[] = 'col-md-' . $column_product . ' col-12 col-sm-6 col-xs-6 lpr-course';

$width        = $height = '';
$lp_thumbnail = get_option( 'learn_press_course_thumbnail_image_size' );
if ( $lp_thumbnail && ! empty( $lp_thumbnail ) ) {
	$width  = isset( $lp_thumbnail['width'] ) ? $lp_thumbnail['width'] : $lp_thumbnail[0];
	$height = isset( $lp_thumbnail['height'] ) ? $lp_thumbnail['height'] : $lp_thumbnail[1];
} else {
	$width  = 320;
	$height = 355;
}
$thumbnail_size = $width . 'x' . $height;

$course = LP_Global::course();
if ( ! $course ) {
	return;
}
$course_id = $course->get_id();
$price     = $course->get_origin_price_html();
if ( class_exists( 'LP_Addon_Course_Review' ) ) {
	$course_number_vote       = learn_press_get_course_rate_total( $course_id );
	$html_course_number_votes = $course_number_vote ? sprintf( _n( '(%1$s vote )', ' (%1$s votes)', $course_number_vote, 'course-builder' ), number_format_i18n( $course_number_vote ) ) : esc_html__( '(0 vote)', 'course-builder' );
}
$count = $course->get_users_enrolled() ? $course->get_users_enrolled() : 0;

$extra_class = $class_wishlist = '';
if ( ! empty( $course_number_vote ) ) {
	$extra_class = 'review-course';
}
$link = learn_press_user_profile_link( get_the_author_meta( 'ID' ) );
$user = new WP_User( get_the_author_meta( 'ID' ) );

if ( thim_plugin_active( 'learnpress-wishlist/learnpress-wishlist.php' ) || class_exists( 'LP_Addon_Wishlist' ) ) {
	$class_wishlist = 'has-wishlist';
}

$is_course_in_membership = (bool) get_post_meta( $course->get_id(), '_lp_pmpro_levels', false );

if ( $is_course_in_membership ) {
	$classes[] = "lp-membership";
}

$course_current = learn_press_get_course();
$user_current   = learn_press_get_current_user();

if ( $user_current->has_purchased_course( $course_current->get_id() ) ) {
	$classes[] = 'course-purchased';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>

	<?php do_action( 'learn-press/before-courses-loop-item' ); ?>

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

            <span class="price">

                <?php
                global $post;
                $course_pri  = LP_Course::get_course( $post->ID );
                $is_required = $course_pri->is_required_enroll();

                learn_press_get_template( 'single-course/price.php' );
                ?>
            </span>

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


			<?php if ( isset( $theme_options_data['learnpress_icon_archive_display'] ) && $theme_options_data['learnpress_icon_archive_display'] == true ) { ?>
                <div class="button-when-logged <?php echo esc_attr( $class_wishlist ) ?>">

					<?php if ( $user_current->has_purchased_course( $course_current->get_id() ) ) {
						echo '<span class="purchased icon ion-android-checkmark-circle" title="' . esc_html__( 'You have purchased this course', 'course-builder' ) . '"><ion-icon name="checkbox-outline"></ion-icon></span>';
					}
					thim_course_wishlist_button( $course_id ); ?>

                </div>
			<?php } ?>

        </div>

        <div class="sub-content">
            <h3 class="title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
            <div class="date-comment">
				<?php echo '<span class="date-meta">' . get_the_date() . '</span>' . esc_html_x( ' / ', 'Divide the course creation date and number of comments', 'course-builder' );
				$comment = get_comments_number();
				echo '<span class="number-comment">';
				if ( $comment == 0 ) {
					echo esc_html__( "No Comments", 'course-builder' );
				} else {
					echo sprintf( _n( '%d Comment', '%d Comments', $comment, 'course-builder' ), $comment );
				}
				echo '</span>';
				?>
            </div>

            <div class="content-list">
                <div class="course-description">
					<?php

					the_excerpt();

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
					<?php if ( class_exists( 'LP_Addon_Course_Review' ) ): ?>
                        <li>
                            <label><?php echo esc_html__( 'Review:', 'course-builder' ); ?></label>
                            <div class="review <?php echo esc_attr( $extra_class ) ?>">
                                <div class="sc-review-stars">
									<?php $course_rate = learn_press_get_course_rate( $course_id ); ?>
									<?php learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) ); ?>
                                </div>
								<?php if ( ! empty( $html_course_number_votes ) ): ?>
                                    <span class="vote"><?php echo esc_attr( $html_course_number_votes ); ?></span>
								<?php endif; ?>
                            </div>
                        </li>
					<?php endif; ?>
                    <li>
                        <label><?php echo esc_attr__( 'Students:', 'course-builder' ); ?></label>
                        <strong class="students"><?php echo esc_html( $count ); ?><?php echo esc_html__( ' Students', 'course-builder' ); ?></strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>

	<?php do_action( 'learn-press/after-courses-loop-item' ); ?>
</article>