<?php
/**
 * Template for displaying Course block 4 shortcode for Learnpress v3.
 *
 * @author  ThimPress
 * @package Course Builder/Templates
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

// extract $params to parameters
/**
 * Extract $params to parameters
 * @var $cols
 * @var $course_limit
 * @var $course_cat
 * @var $course_list
 * @var $course_featured
 */

$button_text         = 'View all courses';
$new_course_duration = get_theme_mod( 'learnpress_new_course_duration' ) ? get_theme_mod( 'learnpress_new_course_duration' ) : 3;
$new_course_duration = intval( $new_course_duration );

extract( $params );

$col_class = 12 / intval( $cols );

$course_cat_query_args = array(
	'post_type'      => LP_COURSE_CPT,
	'post_status'    => 'publish',
	'posts_per_page' => $course_limit,
	'author__not_in' => array( 0 )
);

if ( $course_cat == 'all' ) {
	$course_cat = array();
}

if ( isset( $course_cat[''] ) && is_array( $course_cat[''] ) ) {
	$course_cat = $course_cat[''];

}

if ( ( is_array( $course_cat ) && !empty( $course_cat ) ) || ( !is_array( $course_cat ) && $course_cat ) ) {
	$course_cat_query_args['tax_query'] = array(
		array(
			'taxonomy' => 'course_category',
			'field'    => 'term_id',
			'terms'    => $course_cat,
		)
	);
}

$recent_days_course = mktime( 0, 0, 0, date( "m" ), date( "d" ) - $new_course_duration, date( "Y" ) );


if ( $course_list === 'latest' ) {
	$course_cat_query_args['orderby'] = 'date';
}

if ( $course_list === 'popular' ) {
	$course_cat_query_args['post__in'] = lp_get_courses_popular();
}

// Get featured courses
if ( $course_featured != '' ) {
	$course_cat_query_args['meta_query'] = array(
		array(
			'key'   => '_lp_featured',
			'value' => 'yes',
		)
	);
}

$course_cat_query = new WP_Query( $course_cat_query_args );

$row_index = 1;
?>

<?php if ( $title || $course_cat_query->have_posts() ) { ?>
	<div class="thim-course-block-4">
		<?php if ( $title ) { ?>
			<div class="sc-title">
				<?php if ( $title ) { ?>
					<h3 class="title"><?php echo esc_html( $title ); ?></h3>
				<?php } ?>
			</div>
		<?php } ?>

		<?php if ( $course_cat_query->have_posts() ) {

			$categories = array(); ?>
			<div class="row">

				<?php while ( $course_cat_query->have_posts() ) : $course_cat_query->the_post();

					$price_class  = $free = '';
					$course_id    = get_the_ID();
					$course       = learn_press_get_course( $course_id );
					$course_price = $course->get_price_html();

					if ( $course->is_free() ) {
						$free = 'free';
					}


					$courses_tag             = get_the_terms( $course->get_id(), 'course_category' );
					if(!empty($courses_tag)){
						$custom_background_color = get_term_meta( $courses_tag[0]->term_id, 'thim_sc_bg_color', true );
					}
					if ( $custom_background_color ) {
						$custom_background_color = get_term_meta( $courses_tag[0]->term_id, 'thim_sc_bg_color', true );
					} else {
						$custom_background_color = '#60d3c6';
					}
					$is_course_in_membership = (bool) get_post_meta( $course->get_id(), '_lp_pmpro_levels', false );

					if ( $is_course_in_membership ) {
						$price_class = "in-membership";
					}

					$course_number_vote = '';

					if ( class_exists( 'LP_Addon_Course_Review' ) ) {
						if ( function_exists( 'learn_press_get_course_rate_total' ) ) {
							$course_number_vote = learn_press_get_course_rate_total( $course_id );
						}
					}

					$html_course_number_votes = $course_number_vote ? sprintf( _n( '( %1$s vote )', '( %1$s votes )', $course_number_vote, 'course-builder' ), number_format_i18n( $course_number_vote ) ) : esc_html__( '( 0 vote )', 'course-builder' );

					$course_rate = 0;
					if ( class_exists( 'LP_Addon_Course_Review' ) ) {
						if ( function_exists( 'learn_press_get_course_rate' ) ) {
							$course_rate = learn_press_get_course_rate( $course_id );
						}
					}

					$first_item_on_row = $row_index * 4 - 1 + 1;

					$courses_tag = get_the_terms( $course->get_id(), 'course_category' );

					ob_start();
					learn_press_get_template( 'single-course/price.php' );
					$html_price = ob_get_contents();
					ob_end_clean();

					if ( class_exists( 'LP_Addon_Course_Review' ) ) {
						$course_rate             = learn_press_get_course_rate( get_the_ID() );
						$html_course_number_rate = $course_rate ? sprintf( _n( '%1$s Star', '%1$s Stars', $course_rate, 'course-builder' ), number_format_i18n( $course_rate ) ) : esc_html__( '0 Star', 'course-builder' );
					}
					?>

					<div class="course-item col-sm-<?php echo $col_class; ?>"
						 data-color="<?php echo $custom_background_color; ?>">
						<div class="wrapper">
							<div class="featured-img">
								<?php echo thim_get_thumbnail( $course_id, '342x252' ); ?>
								<?php if ( $courses_tag ) { ?>
									<a class="course-category"
									   href="<?php echo get_term_link( $courses_tag[0]->term_id ) ?>"
									   style="background-color: <?php echo $custom_background_color; ?>;"
									>
										<span class="after_box"
											  style="border: 6px solid <?php echo $custom_background_color; ?>;"></span>
										<?php echo $courses_tag[0]->name; ?>
									</a>
								<?php } ?>
							</div>
							<div class="course-content">
								<h4 class="course-title">
									<a href="<?php echo esc_url( get_the_permalink() ); ?>">
										<?php echo get_the_title(); ?>
									</a>
								</h4>
								<div class="course-meta">
									<?php if ( is_plugin_active( 'learnpress-course-review/learnpress-course-review.php' ) ) { ?>
										<span class="star"><i class="ion ion-android-star"></i>
											<?php echo $html_course_number_rate; ?>
											<?php echo $html_course_number_votes; ?>
										</span>
									<?php } ?>
									<div class="price" style="color: <?php echo $custom_background_color; ?>;">
										<?php echo $html_price; ?>
									</div>
								</div>
							</div>
						</div>
					</div>

				<?php
				endwhile;
				wp_reset_postdata();
				?>
				<?php if ( $button_text ) {
					$archive_courses_url = get_post_type_archive_link( 'lp_course' ) ? get_post_type_archive_link( 'lp_course' ) : '#';
					echo '<a href="' . esc_url( $archive_courses_url ) . '" class="view-courses-button">' . esc_html( $button_text ) . '</a>';
				} ?>
			</div>
		<?php } ?>
	</div>
<?php } ?>