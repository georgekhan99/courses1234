<?php
/**
 * Template for displaying Course carousel shortcode default style for Learnpress v3.
 *
 * @author  ThimPress
 * @package Course Builder/Templates
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

/**
 * Extract $params to parameters
 * @var $list_courses
 * @var $cat_courses
 * @var $featured_courses
 * @var $course_columns
 * @var $course_dots
 * @var $course_navigation
 * @var $course_number
 */
extract( $params );

$cat_courses      = ! empty( $cat_courses ) ? strtolower( $cat_courses ) : '';
$featured_courses = empty( $featured_courses ) ? '' : $featured_courses;
$course_columns   = isset( $course_columns ) ? $course_columns : 3;
$course_nav       = isset( $course_navigation ) ? $course_navigation : true;
$course_dots      = isset( $course_dots ) ? $course_dots : true;
$course_number    = isset( $course_number ) ? $course_number : 3;
$args_8           = array( 'post_type' => 'lp_course', 'posts_per_page' => $course_number, 'post_status' => 'publish' );

switch ( $list_courses ) {
	case 'latest':
		$args_8['orderby'] = 'date';
		break;
	case 'category' :
		$args_8['tax_query'] = array(
			array(
				'taxonomy' => 'course_category',
				'field'    => 'term_id',
				'terms'    => array( $cat_courses ),
			),
		);
		break;
}
// Get popular courses
if ( $list_courses == 'popular' ) {
	global $wpdb;
	$popular_courses_query = $wpdb->prepare(
		"SELECT po.*, count(*) as number_enrolled 
					FROM {$wpdb->prefix}learnpress_user_items ui
					INNER JOIN {$wpdb->posts} po ON po.ID = ui.item_id
					WHERE ui.item_type = %s
						AND ( ui.status = %s OR ui.status = %s )
						AND po.post_status = %s
					GROUP BY ui.item_id 
					ORDER BY ui.item_id DESC
				",
		LP_COURSE_CPT,
		'enrolled',
		'finished',
		'publish'
	);
	$popular_courses       = $wpdb->get_results( $popular_courses_query );

	$temp_arr = array();
	foreach ( $popular_courses as $course ) {
		array_push( $temp_arr, $course->ID );
	}
	$args_8['post__in'] = $temp_arr;
}

// Get featured courses
if ( $featured_courses != '' ) {
	$args_8['meta_query'] = [
		[
			'key'   => '_lp_featured',
			'value' => 'yes',
		],
	];
}

$loop         = new WP_Query( $args_8 );
$lp_thumbnail     = get_option( 'learn_press_course_thumbnail_image_size' );
$lp_thumbnail_lp4 = get_option( 'learn_press_course_thumbnail_dimensions' );
if ( isset( $lp_thumbnail['width'] ) ) {
	$thumbnail_size = $lp_thumbnail['width'] . 'x' . $lp_thumbnail['height'];
} elseif ( isset( $lp_thumbnail_lp4['width'] ) ) {
	$thumbnail_size = $lp_thumbnail_lp4['width'] . 'x' . $lp_thumbnail_lp4['height'];
} else {
	$thumbnail_size = '365x405';
}

?>
<div class="thim-sc-courses-carousel <?php echo esc_attr( $params['el_class'] ); ?>">
    <div class="inner-carousel  owl-carousel owl-theme " data-cols="<?php echo esc_attr( $course_columns ); ?>"
         data-nav="<?php echo esc_attr( $course_nav ) ?>" data-dots="<?php echo esc_attr( $course_dots ) ?>">
		<?php while ( $loop->have_posts() ) : $loop->the_post() ?>
			<?php
			$course_id          = get_the_ID();
			if ( is_archive() || is_category() ) {
                $course = LP_Global::course();
            } else {
                $course             = learn_press_get_course( $course_id );
            }
			$price_sale         = $course->get_sale_price();
			$price              = $course->get_origin_price_html();
			$course_number_vote = '';

			if ( function_exists( 'learn_press_get_course_rate_total' ) ) {
				$course_number_vote = learn_press_get_course_rate_total( $course_id );
			}

			$html_course_number_votes = $course_number_vote ? sprintf( _n( '(%1$s vote )', ' (%1$s votes)', $course_number_vote, 'course-builder' ), number_format_i18n( $course_number_vote ) ) : '';
			$course_classes           = array();

			if ( function_exists( 'learn_press_is_coming_soon' ) && learn_press_is_coming_soon() ) {
				$course_classes[] = 'coming-soon';
			}

            $is_course_in_membership = (bool) get_post_meta( $course->get_id(), '_lp_pmpro_levels', false );

            if ( $is_course_in_membership ){
                $course_classes[] = "in-membership";
            }

			$extra_class = '';

			if ( $course_number_vote != 0 ) {
				$extra_class = 'review-course';
			}
			?>
            <div <?php post_class( $course_classes ) ?>>
                <div class="content">
                    <div class="thumbnail">
						<?php
                        if ($course->get_sale_price()) {
							echo '<span class="sale">' . '<span class="text-sale">' . esc_attr__( 'Sale', 'course-builder' ) . '</span>' . '</span>';
						}
						?>
						<?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>"
                               class="img_thumbnail"> <?php echo thim_get_thumbnail( get_the_ID(), $thumbnail_size, 'post', false ); ?> </a>
						<?php endif; ?>
                        <span class="price">
		                    <?php if ( function_exists( 'learn_press_is_coming_soon' ) && learn_press_is_coming_soon() ) {
			                    echo '<span class="course-price">' . esc_html__( 'Coming Soon', 'course-builder' ) . '</span>';
		                    } else {

		                    global  $post;

                            if ( is_archive() || is_category() ) {
                                $course_pri = LP_Global::course();
                                $is_required = $course_pri->is_required_enroll();

                            } else {
                                $course_pri      = LP_Course::get_course( $post->ID );
                                $is_required = $course_pri->is_required_enroll();
                            }

		                    if ( $course_pri->is_free() || ! $is_required ) : ?>
                            <span class="course-price"><?php echo esc_html__( 'Free', 'course-builder' ). '</span>';
			                    else:
				                    learn_press_get_template( 'single-course/price.php' );
			                    endif;
			                    } ?>
                        </span>
                        <div class="review <?php echo esc_attr( $extra_class ) ?>">
                            <div class="sc-review-stars">
								<?php
								if ( function_exists( 'learn_press_get_course_rate' ) ) {
									$course_rate = learn_press_get_course_rate( $course_id );
									learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) );
								}
								?>
                            </div>
							<?php if ( ( $course_number_vote ) > 0 ): ?>
                                <span class="vote"><?php echo esc_attr( $html_course_number_votes ); ?></span>
							<?php endif; ?>
                        </div>
                    </div>
                    <div class="sub-content">
                        <div class="title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </div>
                        <div class="data-comment">
							<span class="date"><?php echo get_the_date(); ?></span> /
							<span class="comment">
                                <?php $comment = get_comments_number();
                                if ( $comment == 0 ) {
	                                echo esc_html__( "No Comment", 'course-builder' );
                                } else {
                                   echo sprintf( _n( '%d Comment', '%d Comments', $comment, 'course-builder' ), $comment);
                                }
                                ?>
                            </span>
                        </div>

                    </div>
                </div>
            </div>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
    </div>
</div>