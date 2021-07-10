<?php


$list_courses     = $params['list_courses'];
$cat_courses      = isset( $params['cat_courses'] ) ? $params['cat_courses'] : '';
$featured_courses = empty( $params['featured_courses'] ) ? '' : $params['featured_courses'];
$cols = $params['cols'];
$col_class = 12 / intval($cols);

if ( $cat_courses ) {
	$tax_query_value = array(
		array(
			'taxonomy' => 'course_category',
			'field'    => 'term_id',
			'terms'    => $cat_courses,
		)
	);
} else {
	$tax_query_value = '';
}

$args_list_courses = array(
	'posts_per_page' => $cols,
	'post_type'      => 'lp_course',
	'post_status'    => 'publish',
	'tax_query'      => $tax_query_value,
);

if ( $list_courses === 'latest' ) {
	$args_list_courses['orderby'] = 'date';
}

if ( $list_courses == 'popular' ) {
	$args_list_courses['post__in'] = lp_get_courses_popular();
}

// Get popular courses
if ( $list_courses == 'popular' ) {
	$args_list_courses['post__in'] = lp_get_courses_popular();
}

// Get featured courses
if ( $featured_courses != '' ) {
	$args_list_courses['meta_query'] = array(
		array(
			'key'   => '_lp_featured',
			'value' => 'yes',
		)
	);
}

$query_list_courses = new WP_Query( $args_list_courses );
$first_post         = true;

if ( $query_list_courses->have_posts() ) : ?>
	<div class="thim-courses-megamenu row">
		<?php while ( $query_list_courses->have_posts() ): $query_list_courses->the_post(); ?>
			<?php $course_id = get_the_ID(); ?>
            <div class="course-item col-sm-<?php echo esc_attr($col_class) ?>">

                <div class="feature-img">
					<?php thim_thumbnail( $course_id, '300x300', 'post', true ) ?>
                </div>

                <div class="course-detail">
                    <h3 class="title">
                        <a href="<?php echo esc_url( get_the_permalink() ) ?>"><?php echo esc_html( get_the_title() ) ?></a>
                    </h3>

                    <div class="price"><?php learn_press_get_template( 'single-course/price.php' ); ?></div>

                </div>

            </div>
		<?php endwhile; ?>
	</div>
<?php endif; ?>
<?php wp_reset_postdata();