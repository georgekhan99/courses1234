<?php

include_once( THIM_CB_PATH . 'inc/plugins/learnpress-tabs/learnpress-tabs.php' );

if ( ! function_exists( 'lp_get_courses_popular' ) ) {
	function lp_get_courses_popular() {
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
		$popular_courses       = $wpdb->get_results(
			$popular_courses_query
		);

		$temp_arr = array();
		foreach ( $popular_courses as $course ) {
			array_push( $temp_arr, $course->ID );
		}

		return $temp_arr;
	}
}

if ( ! function_exists( 'thim_get_all_courses_instructors' ) ) {
    function thim_get_all_courses_instructors() {
        $teacher       = array();
        $users_by_role = get_users( array( 'role' => 'lp_teacher' ) );
        if ( $users_by_role ) {
            foreach ( $users_by_role as $user ) {
                $teacher[] = $user->ID;
            }
        }
        $result = array();
        if ( $teacher ) {
            foreach ( $teacher as $id ) {
                $courses        = learn_press_get_course_of_user_instructor( array( 'user_id' => $id ) );
                $count_students = $count_rate = 0;
                foreach ( $courses["rows"] as $key => $course ) {
                    //$user_count = $course->get_users_enrolled() ? $course->get_users_enrolled() : 0;
                    $curd            = new LP_Course_CURD();
                    $number_students = $curd->get_user_enrolled( $course->ID );
                    $count_students  = count( $number_students ) ? $count_students + count( $number_students ) : $count_students;
                    if ( thim_plugin_active( 'learnpress-course-review/learnpress-course-review.php' ) ) {
                        $rate = learn_press_get_course_rate_total( $course->ID );
                    } else {
                        $rate = 0;
                    }

                    $count_rate = $rate ? $rate + $count_rate : $count_rate;
                }
                $result[] = array(
                    'user_id'    => $id,
                    'students'   => $count_students,
                    'count_rate' => $count_rate
                );
            }
        }

        return $result;
    }
}