<?php
global $wpdb;

$limit  = empty( $params["limit"] ) ? '20' : $params["limit"];

if($params['instructor_style'] == 'all_instructor') {
	$query = $wpdb->prepare( "
	SELECT *
	FROM {$wpdb->usermeta}
	WHERE meta_value LIKE %s
", '%lp_teacher%' );
} else {
	$query = $wpdb->prepare( "
	SELECT COUNT( u.ID ) as courses, u . *
	FROM {$wpdb->users} u
	INNER JOIN {$wpdb->postmeta} c ON u.ID = c.meta_value
	WHERE c.meta_key =  %s
	GROUP BY u.ID
	ORDER BY courses DESC
", '_lp_co_teacher' );
}

$instructor = $wpdb->get_results( $query );

$count_instructors = count($instructor);
$max_page = intval($count_instructors / $limit);
if(($count_instructors % $limit) != 0 ) {
	$max_page = $max_page + 1;
}
?>
<div class="thim-instructors <?php echo esc_attr( $params["el_class"] ); ?>" data-params='<?php echo json_encode( $params ); ?>' id="<?php echo uniqid( 'thim_' ); ?>" data-max-page='<?php echo esc_attr($max_page); ?>' data-page='<?php echo esc_attr($params['page']); ?>'>
	<div class="wrapper-instruction <?php echo esc_attr( $params["instructor_style"] ); ?>">
		<?php
		if($params['instructor_style'] == 'all_instructor') {
			thim_get_template( 'item2', $args, $params['sc-name'] . '/tpl/' );
		} elseif($params['instructor_style'] == 'home_courses_instructor') {
			thim_get_template( 'item3', $args, $params['sc-name'] . '/tpl/' );
		}  elseif($params['instructor_style'] == 'home1_courses_instructor') {
			thim_get_template( 'item4', $args, $params['sc-name'] . '/tpl/' );
		} else {
			thim_get_template( 'item', $args, $params['sc-name'] . '/tpl/' );
		} ?>
	</div>
</div>