<?php
/**
 * Template for displaying Course block 3 shortcode for Learnpress v3.
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
extract($params);

$new_course_duration = get_theme_mod( 'learnpress_new_course_duration' ) ? get_theme_mod( 'learnpress_new_course_duration' ) : 3;
$new_course_duration = intval( $new_course_duration );

$col_class = 12 / intval($cols);

$course_cat_query_args = array(
	'post_type'      => LP_COURSE_CPT,
	'post_status'    => 'publish',
	'posts_per_page' => $course_limit,
	'author__not_in'=> array(0)
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
    <?php $title_center = ( $button_text == '' ) ? ' title-center' : '';?>
	<div class="thim-course-block-3 <?php echo esc_attr($title_center); ?>  <?php if ( $params['filter'] !== 'yes') { echo 'has-filter';}?>
	<?php if ( get_theme_mod( 'learnpress_new_course_duration' ) == '0' ) { echo 'hide-label';}?>">
		<?php if ( $title || $button_text ){ ?>

			<div class="wrapper-title">
				<?php if ( $title ) { ?>
				<h3 class="title<?php echo esc_attr($title_center); ?>"><?php echo esc_html( $title ); ?></h3>
				<?php }?>

				<?php if ( $button_text ) {
					$archive_courses_url = get_post_type_archive_link( 'lp_course' ) ? get_post_type_archive_link( 'lp_course' ) : '#';
					echo '<a href="' . esc_url( $archive_courses_url ) . '" class="view-courses-button">' . esc_html( $button_text ) . '</a>';
				} ?>
			</div>

		<?php } ?>

	<?php if ( $course_cat_query->have_posts() ) {

		$categories = array();
		$html_main_content = '<div class="row">';

        while ( $course_cat_query->have_posts() ) : $course_cat_query->the_post();

        $price_class   = $free    = '';
		$course_id                = get_the_ID();
		$course                   = learn_press_get_course( $course_id );
		$course_price             = $course->get_price_html();

		 if ( $course->is_free() ) {
		     $free = 'free';
		 }


		$is_course_in_membership = (bool) get_post_meta( $course->get_id(), '_lp_pmpro_levels', false );

        if( $is_course_in_membership ){
            $price_class = "in-membership";
        }

		$course_number_vote = '';

		if (function_exists('learn_press_get_course_rate_total')){
			$course_number_vote       = learn_press_get_course_rate_total( $course_id );
		}

		$html_course_number_votes = $course_number_vote ? sprintf( _n( '(%1$s vote)', '(%1$s votes)', $course_number_vote, 'course-builder' ), number_format_i18n( $course_number_vote ) ) : esc_html__( '(0 vote)', 'course-builder' );

		$course_rate = 0;
		if (function_exists('learn_press_get_course_rate')){
			$course_rate = learn_press_get_course_rate( $course_id );
		}

		$first_item_on_row = $row_index * 4 - 1 + 1;

		// Get data of filter course category bar
		$terms              = get_the_terms( $course_id, 'course_category' );
		$current_course_cat = array();
		if ( $terms && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$current_course_cat[ $term->name ] = $term->slug;
				$categories[ $term->slug ]         = $term->name;
			}
		}
		$class_categories = join( " ", $current_course_cat );
		// End get data of filter course category bar

		ob_start();
		learn_press_get_template( 'single-course/price.php' );
		$html_price = ob_get_contents();
		ob_end_clean();

		if (class_exists('LP_Addon_Course_Review')){
		ob_start();
		learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) );
		$html_rating = ob_get_contents();
		ob_end_clean();
		}

		$course_label = $new_course_label = '';
        $course_date      = strtotime( get_the_date() );

		$new_course_label = $course_date > $recent_days_course ? 'new-course' : '';

		if ( $course->get_sale_price() ) {
			$course_label = ' sale';
		}

		$author   = $course->get_author();
		$author_name = $author->get_data('display_name') ? $author->get_data('display_name') : $author->get_data('user_login');

		// course curd
		$curd = new LP_Course_CURD();
		$students_enrolled_real      = sizeof($curd->get_user_enrolled($course_id, -1));

		$students_enrolled_fake = get_post_meta($course_id, '_lp_students', true) ? intval(get_post_meta($course_id, '_lp_students', true)) : 0;

		$total_students = apply_filters('thim_number_students_enrolled', $students_enrolled_real + $students_enrolled_fake);

		$students_enrolled_output = sprintf(_n('%s student', '%s students', $total_students, 'course-builder'), $total_students);

		 // Get courses content html output
		$html_main_content .= '<div class="course-item col-sm-'. $col_class .' ' . esc_attr( $course_label ) . ' '. esc_attr($free) .' ' . esc_attr( $price_class ) . ' ' . esc_attr( $new_course_label ) . ' ' . esc_attr( $class_categories ).' ">';
        if ( $cols === '3' ) {
               $html_main_content .= '<div class="wrapper"><div class="featured-img">' . thim_get_thumbnail( $course_id, '480x360' );
        } else {
            $html_main_content .= '<div class="wrapper"><div class="featured-img">' . thim_get_thumbnail( $course_id, '342x299' );
        }

		$html_main_content .= '<div class="course-meta"><div class="price">' . $html_price . '</div>';

		if ( isset( $html_rating ) ){
			$html_main_content .= '<div class="course-rating">' . $html_rating . '<span>' . $html_course_number_votes . '</span></div>';
		}
		$html_main_content .= '</div></div>';

		if ( $course_date > $recent_days_course ) {
			$html_main_content .= '<span class="new-course-label">' . esc_html__( 'New', 'course-builder' ) . '</span>';
		}

        if ( $course->get_sale_price() ) {
		    $html_main_content .= '<span class="sale-course-label">' . esc_html__( 'Sale', 'course-builder' ) . '</span>';
		}

		$html_main_content .= '<h4 class="course-title"><a href="' . esc_url( get_the_permalink() ) . '">' . get_the_title() . '</a></h4>';
		$html_main_content .= '<div class="participants"><a href="' . esc_url( learn_press_user_profile_link( $author->get_id() )) . '" class="instructor">' . $author_name . '</a><span class="students">' . $students_enrolled_output . '</span></div>';
		$html_main_content .= '</div></div>';

		 endwhile;
		 wp_reset_postdata();
		$html_main_content .= '</div></div>';
		// End get courses content html output

		?>
        <?php if ( empty( $course_cat ) ) { ?>
            <?php if ($filter !== 'yes'){ ?>
            <div class="masonry-filter">
                <a class="filter is-checked" data-filter="*" href="javascript:;"><?php esc_html_e( 'All', 'course-builder' ); ?></a><?php foreach ( $categories as $cat_slug => $cat_name ) : echo '<a class="filter" href="javascript:;" data-filter=".' . $cat_slug . '">' . $cat_name . '</a>';endforeach; ?>
            </div>
            <?php } ?>
         <?php } else {
			$course_cat_id = $params['course_cat'];
			$course_cat_info = get_term($course_cat_id,'course_category');
			$test = get_cat_name($course_cat_id);
			$course_cat_name = $course_cat_info->name;
			
            ?>
            <div class="masonry-filter">
                <?php if ($filter !== 'yes'){ ?>
                    <div class="masonry-filter">
                       <span class="filter is-checked"><?php echo esc_html($course_cat_name ) ?></span>
                    </div>
                <?php } ?>
            </div>
			<?php
				}
            ?>

		<div class="masonry-items">
			<?php echo ($html_main_content); ?>
		</div>

	<?php	}
}
