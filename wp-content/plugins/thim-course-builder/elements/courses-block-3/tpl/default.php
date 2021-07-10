<?php

$title        = $params['title'];
$button_text  = $params['button_text'];
$course_cat   = $params['course_cat'];
$hidden_filter = $params['filter'];
$course_limit = $params['course_limit'];
$course_list = $params['course_list'];
$course_featured = $params['course_featured'];
$cols = $params['cols'];

$new_course_duration = get_theme_mod( 'learnpress_new_course_duration' ) ? get_theme_mod( 'learnpress_new_course_duration' ) : 2;
$new_course_duration = intval( $new_course_duration );
$recent_days_course  = mktime( 0, 0, 0, date( "m" ), date( "d" ) - $new_course_duration, date( "Y" ) );

$col_class = 12 / intval($cols);

$course_cat_query_args = array(
	'post_type'      => 'lp_course',
	'post_status'    => 'publish',
	'posts_per_page' => $course_limit,
);

if ( $course_cat ) {
	$course_cat_query_args['tax_query'] = array(
		array(
			'taxonomy' => 'course_category',
			'field'    => 'term_id',
			'terms'    => $course_cat,
		)
	);
}

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

if ( $title || $course_cat_query->have_posts() ) {
				 $title_center = ( $button_text == '' ) ? ' title-center' : '';

	?>
	<div class="thim-course-block-3 <?php echo esc_attr($title_center); ?>">
		<?php if ( $title || $button_text ): ?>

			<div class="wrapper-title">
				<?php if ( $title ) : ?>
				<h3 class="title<?php echo esc_attr($title_center); ?>"><?php echo esc_html( $title ); ?></h3>
				<?php endif; ?>

				<?php
				if ( $button_text ) {
					$archive_courses_url = get_post_type_archive_link( 'lp_course' ) ? get_post_type_archive_link( 'lp_course' ) : '#';
					echo '<a href="' . esc_url( $archive_courses_url ) . '" class="view-courses-button">' . esc_html( $button_text ) . '</a>';
				}
				?>
			</div>

		<?php endif; ?>

	<?php if ( $course_cat_query->have_posts() ) {

		$categories = array();
		$html_main_content = '<div class="row">';

		$course_date = strtotime( get_the_date() );
        while ( $course_cat_query->have_posts() ) : $course_cat_query->the_post();

		$course_id                = get_the_ID();
		$course                   = new LP_Course( $course_id );
		$course_price             = $course->get_price_html();

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

		/*
		 * Get data of filter course category bar
		 * */
		$terms              = get_the_terms( $course_id, 'course_category' );
		$current_course_cat = array();
		if ( $terms && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$current_course_cat[ $term->name ] = $term->slug;
				$categories[ $term->slug ]         = $term->name;
			}
		}
		$class_categories = join( " ", $current_course_cat );
		/*
		 * End get data of filter course category bar
		 * */

		ob_start();
		learn_press_course_price();
		$html_price = ob_get_contents();
		ob_end_clean();

		if (class_exists('LP_Addon_Course_Review')){
		ob_start();
		learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) );
		$html_rating = ob_get_contents();
		ob_end_clean();
		}

		$course_label = '';
		if ( $course_date > $recent_days_course ) {
			$course_label = ' new-course';
		}
		if ( $course->get_sale_price() !== '' ) {
			$course_label .= ' sale';
		}

		$user_data   = get_userdata( $course->post->post_author );
		$author_name = '';
		if ( $user_data ) {
			if ( ! empty( $user_data->display_name ) ) {
				$author_name = $user_data->display_name;
			} else {
				$author_name = $user_data->user_login;
			}
		}

		$students_enrolled_real      =_learn_press_count_users_enrolled_courses(array($course_id)); // return array
		$students_enrolled_real = is_array($students_enrolled_real) ? intval($students_enrolled_real[$course_id]) : 0;

		$students_enrolled_fake = get_post_meta($course_id, '_lp_students', true) ? intval(get_post_meta($course_id, '_lp_students', true)) : 0;

		$total_students = apply_filters('thim_number_students_enrolled', $students_enrolled_real + $students_enrolled_fake);

		$students_enrolled_output = sprintf(_n('%s student', '%s students', $total_students, 'course-builder'), $total_students);

		/*
		 * Get courses content html output
		 * */

		$html_main_content .= '<div class="course-item col-sm-'. $col_class .'' . esc_attr( $course_label ) . ' ' . esc_attr( $class_categories ).'">';

		$html_main_content .= '<div class="wrapper"><div class="featured-img">' . thim_get_thumbnail( $course_id, '342x299' );
		$html_main_content .= '<div class="course-meta"><div class="price">' . $html_price . '</div>';
		if ( isset( $html_rating ) ){
			$html_main_content .= '<div class="course-rating">' . $html_rating . '<span>' . $html_course_number_votes . '</span></div>';
		}
		$html_main_content .= '</div></div>';

		if ( $course_date > $recent_days_course ) {
			$html_main_content .= '<span class="new-course-label">' . esc_html__( 'New', 'course-builder' ) . '</span>';
		}
		if ( $course->get_sale_price() !== '' ) {
			$html_main_content .= '<span class="sale-course-label">' . esc_html__( 'Sale', 'course-builder' ) . '</span>';
		}

		$html_main_content .= '<h4 class="course-title"><a href="' . esc_url( get_the_permalink() ) . '">' . get_the_title() . '</a></h4>';
		$html_main_content .= '<div class="participants"><a href="' . esc_url( learn_press_user_profile_link( $course->post->post_author ) ) . '" class="instructor">' . $author_name . '</a><span class="students">' . $students_enrolled_output . '</span></div>';
		$html_main_content .= '</div></div>';

		 endwhile;
		 wp_reset_postdata();
		$html_main_content .= '</div></div>';

		/*
		 * End get courses content html output
		 * */
		?>

		<!--	Display outside front-end   -->
		<?php if ($hidden_filter !== 'yes'): ?>
		<div class="masonry-filter">
			<a class="filter is-checked" data-filter="*" href="javascript:;"><?php esc_html_e( 'All', 'course-builder' ); ?></a><?php foreach ( $categories as $cat_slug => $cat_name ) : echo '<a class="filter" href="javascript:;" data-filter=".' . $cat_slug . '">' . $cat_name . '</a>';endforeach; ?>
		</div>
		<?php endif; ?>

		<div class="masonry-items">
			<?php echo ($html_main_content); ?>
		</div>
		<!--	End display outside front-end   -->

	<?php
	}
}