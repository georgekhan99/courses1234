<?php
include_once 'lp-template-hooks.php';
/** * Add media meta data for a course
 *
 * @param $meta_box
 */
if ( ! function_exists( 'thim_add_course_meta' ) ) {
	function thim_add_course_meta( $meta_box ) {
		$fields             = $meta_box['fields'];
		$fields[]           = array(
			'name' => esc_html__( 'Media URL', 'course-builder' ),
			'id'   => 'thim_course_media',
			'type' => 'text',
			'size' => 100,
			'desc' => esc_html__( 'Supports 3 types of video urls: Direct video link, Youtube link, Vimeo link.', 'course-builder' ),
		);
		$fields[]           = array(
			'name' => esc_html__( 'Info Button Box', 'course-builder' ),
			'id'   => 'thim_course_info_button',
			'type' => 'text',
			'size' => 100,
			'desc' => esc_html__( 'Add text info button', 'course-builder' ),
		);
		$fields[]           = array(
			'name' => esc_html__( 'Includes', 'course-builder' ),
			'id'   => 'thim_course_includes',
			'type' => 'wysiwyg',
			'desc' => esc_html__( 'Includes information of Courses', 'course-builder' ),
		);
		$meta_box['fields'] = $fields;

		return $meta_box;
	}
}
add_filter( 'learn_press_course_settings_meta_box_args', 'thim_add_course_meta' );
/** * Add media meta data for a lesson
 *
 * @param $meta_box
 */
if ( ! function_exists( 'thim_add_lesson_meta' ) ) {
	function thim_add_lesson_meta( $meta_box ) {
		$fields             = $meta_box['fields'];
		$fields[]           = array(
			'name' => esc_html__( 'Media', 'course-builder' ),
			'id'   => '_lp_lesson_video_intro',
			'type' => 'textarea',
			'desc' => esc_html__( 'Add an embed link like video, PDF, slider...', 'course-builder' ),
		);
		$meta_box['fields'] = $fields;

		return $meta_box;
	}
}
add_filter( 'learn_press_lesson_meta_box_args', 'thim_add_lesson_meta' );

/*
 *  Update additional fields user info
 * */
add_action( 'personal_options_update', 'thim_save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'thim_save_extra_user_profile_fields' );

if ( ! function_exists( 'thim_save_extra_user_profile_fields' ) ) {
	function thim_save_extra_user_profile_fields( $user_id ) {
		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return false;
		}

		if ( empty( $_POST['lp_info'] ) ) {
			return false;
		}

		update_user_meta( $user_id, 'lp_info', $_POST['lp_info'] );
	}
}

if ( ! function_exists( 'thim_get_user_socials' ) ) {
	function thim_get_user_socials( $user_meta ) {
		if ( ! empty( $user_meta['lp_info_facebook'] ) || ! empty( $user_meta['lp_info_twitter'] ) || ! empty( $user_meta['lp_info_skype'] ) || ! empty( $user_meta['lp_info_pinterest'] ) || ! empty( $user_meta['lp_info_google_plus'] ) || ! empty( $user_meta['lp_info_linkedin'] ) || ! empty( $user_meta['lp_info_instagram'] ) ):
			?>
			<ul class="profile-list-social breadcrumbs" itemprop="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList" id="breadcrumbs">
				<?php if ( ! empty( $user_meta['lp_info_facebook'] ) ): ?>
					<li class="item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a itemprop="item" href="<?php echo esc_url( $user_meta['lp_info_facebook'] ); ?>" title="<?php esc_attr_e( 'Facebook', 'course-builder' ) ?>"><i class="fa fa-facebook"></i></a>
					</li>
				<?php endif; ?>

				<?php if ( ! empty( $user_meta['lp_info_twitter'] ) ): ?>
					<li class="item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a itemprop="item" href="<?php echo esc_url( $user_meta['lp_info_twitter'] ); ?>" title="<?php esc_attr_e( 'Twitter', 'course-builder' ) ?>"><i class="fa fa-twitter"></i></a>
					</li>
				<?php endif; ?>

				<?php if ( ! empty( $user_meta['lp_info_skype'] ) ): ?>
					<li class="item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a itemprop="item" href="skype:<?php echo $user_meta['lp_info_skype']; ?>?call" title="<?php esc_attr_e( 'Skype', 'course-builder' ) ?>"><i class="fa fa-skype"></i></a>
					</li>
				<?php endif; ?>

				<?php if ( ! empty( $user_meta['lp_info_pinterest'] ) ): ?>
					<li class="item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a itemprop="item" href="<?php echo esc_url( $user_meta['lp_info_pinterest'] ); ?>" title="<?php esc_attr_e( 'Pinterest', 'course-builder' ) ?>"><i class="fa fa-pinterest"></i></a>
					</li>
				<?php endif; ?>

				<?php if ( ! empty( $user_meta['lp_info_google_plus'] ) ): ?>
					<li class="item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a itemprop="item" href="<?php echo esc_url( $user_meta['lp_info_google_plus'] ); ?>" title="<?php esc_attr_e( 'Google Plus', 'course-builder' ) ?>"><i class="fa fa-google-plus"></i></a>
					</li>
				<?php endif; ?>

                <?php if ( ! empty( $user_meta['lp_info_linkedin'] ) ): ?>
                    <li class="item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="<?php echo esc_url( $user_meta['lp_info_linkedin'] ); ?>" title="<?php esc_attr_e( 'Linkedin', 'course-builder' ) ?>"><i class="fa fa-linkedin"></i></a>
                    </li>
                <?php endif; ?>

                <?php if ( ! empty( $user_meta['lp_info_instagram'] ) ): ?>
                    <li class="item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="<?php echo esc_url( $user_meta['lp_info_instagram'] ); ?>" title="<?php esc_attr_e( 'Instagram', 'course-builder' ) ?>"><i class="fa fa-instagram"></i></a>
                    </li>
                <?php endif; ?>
			</ul>
		<?php
		endif;
	}
}

function thim_profile_loadmore_ajax() {
	global $post;
	$userid = $_POST['userid'];
	$user   = learn_press_get_current_user( $userid );
	$paged  = $_POST['paged'];
	$limit  = $_POST['limit'];

	$courses = $user->get( 'courses', array( 'limit' => $limit, 'paged' => $paged ) );

	if ( $courses ) {
		?>
		<?php foreach ( $courses as $post ) {
			setup_postdata( $post );
			?>

			<?php
			learn_press_get_template( 'profile/tabs/courses/loop.php', array(
				'user'      => $user,
				'course_id' => $post->ID
			) );
			?>

		<?php }
	}
	wp_reset_postdata();
	die();
}

add_action( 'wp_ajax_thim_profile_loadmore', 'thim_profile_loadmore_ajax' );
add_action( 'wp_ajax_nopriv_thim_profile_loadmore', 'thim_profile_loadmore_ajax' );

/**
 * Display co instructors
 *
 * @param $course_id
 */
if ( ! function_exists( 'thim_co_instructors' ) ) {
	function thim_co_instructors( $course_id, $author_id ) {
		if ( ! $course_id ) {
			return;
		}
		if ( thim_plugin_active( 'learnpress-co-instructor/learnpress-co-instructor.php' ) || class_exists( 'LP_Addon_Co_Instructor' ) ) {
			$instructors = get_post_meta( $course_id, '_lp_co_teacher' );
			$instructors = array_diff( $instructors, array( $author_id ) );
			if ( $instructors ) {
				foreach ( $instructors as $instructor ) {
					$major = get_the_author_meta( 'lp_info_major', $instructor );
					$link  = learn_press_user_profile_link( $instructor );
					?>
					<div class="thim-course-author instructors thim-co-instructor" itemprop="contributor" itemscope itemtype="http://schema.org/Person">
						<div class="info thim-co-instructor">
							<div class="lp-avatar">
								<a href="<?php echo esc_url( $link ); ?>" class="role">
									<?php echo get_avatar( $instructor, 147 ); ?>
								</a>
								<div class="social">
									<?php thim_get_author_social_link(); ?>
								</div>
							</div>
							<div class="content">
								<div class="author">
									<a href="<?php echo esc_url( $link ); ?>" class="name">
										<?php echo get_the_author_meta( 'display_name', $instructor ); ?>
									</a>
									<?php if ( isset( $major ) && $major ) : ?>
										<div class="role"><?php echo esc_html( $major ); ?></div>
									<?php endif; ?>
								</div>
								<div class="author-description">
									<?php echo get_the_author_meta( 'description', $instructor ); ?>
								</div>
							</div>
						</div>
					</div>
					<?php
				}
			}
		}
	}
}

/**
 * About the author
 */
//add_action( 'thim_learning_end_tab_overview', 'thim_instructors_author', 60 );

if ( ! function_exists( 'thim_instructors_author' ) ) {
	function thim_instructors_author() {
		$link  = learn_press_user_profile_link( get_the_author_meta( 'ID' ) );
		$user  = new WP_User( get_the_author_meta( 'ID' ) );
		$major = get_the_author_meta( 'lp_info_major', get_the_author_meta( 'ID' ) );
		?>
		<div class="thim-course-author instructors">
			<div class="text"><?php echo esc_html__( 'Instructors', 'course-builder' ) ?></div>
			<div class="info">
				<div class="lp-avatar">
					<a href="<?php echo esc_url( $link ); ?>" class="role">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 147 ); ?>
					</a>
					<div class="social">
						<?php thim_get_author_social_link(); ?>
					</div>
				</div>
				<div class="content">
					<div class="author">
						<a href="<?php echo esc_url( $link ); ?>" class="name">
							<?php echo get_the_author_meta( 'display_name', get_the_author_meta( 'ID' ) ); ?>
						</a>
						<?php if ( isset( $major ) && $major ) : ?>
							<div class="role"><?php echo esc_html( $major ); ?></div>
						<?php endif; ?>
					</div>
					<div class="author-description">
						<?php echo get_the_author_meta( 'description', get_the_author_meta( 'ID' ) ); ?>
					</div>
				</div>
			</div>

		</div>
		<?php
		if ( thim_plugin_active( 'learnpress-co-instructor/learnpress-co-instructor.php' ) || class_exists( 'LP_Addon_Co_Instructor' ) ) {
			thim_co_instructors( get_the_ID(), get_the_author_meta( 'ID' ) );
		}

	}
}



/**
 * Remove deps for learnpress.css
 *
 * @param $styles
 */
function thim_custom_learn_press_add_default_styles( $styles ) {
	$styles->registered['learn-press-style']->deps = array();
}

add_action( 'learn_press_add_default_styles', 'thim_custom_learn_press_add_default_styles' );




add_filter( 'learn-press/update-profile-basic-information-data', function ( $update_data ) {
	$update_data['lp_info_status'] = filter_input( INPUT_POST, 'lp_info_status', FILTER_SANITIZE_STRING );

	return $update_data;
} );

/**
 * Update user profile settings via AJAX call
 */
function thim_update_user_profile_settings() {
	if ( ! empty( $_POST['save-profile-addition-information-nonce'] ) ) {
		if ( wp_verify_nonce( $_POST['save-profile-addition-information-nonce'], 'save-profile-addition-information' ) ) {
			$user_id     = get_current_user_id();
			$update_data = array(
				'ID'                  => $user_id,
				'lp_info_skype'       => filter_input( INPUT_POST, 'lp_info_skype', FILTER_SANITIZE_STRING ),
				'lp_info_phone'       => filter_input( INPUT_POST, 'lp_info_phone', FILTER_SANITIZE_STRING ),
				'lp_info_facebook'    => filter_input( INPUT_POST, 'lp_info_facebook', FILTER_SANITIZE_STRING ),
				'lp_info_twitter'     => filter_input( INPUT_POST, 'lp_info_twitter', FILTER_SANITIZE_STRING ),
				'lp_info_pinterest'   => filter_input( INPUT_POST, 'lp_info_pinterest', FILTER_SANITIZE_STRING ),
				'lp_info_google_plus' => filter_input( INPUT_POST, 'lp_info_google_plus', FILTER_SANITIZE_STRING ),
				'lp_info_linkedin'    => filter_input( INPUT_POST, 'lp_info_linkedin', FILTER_SANITIZE_STRING ),
				'lp_info_instagram'   => filter_input( INPUT_POST, 'lp_info_instagram', FILTER_SANITIZE_STRING ),
			);
			$res         = wp_update_user( $update_data );

			return;
		}
	}

	if ( empty( $_REQUEST['thim-update-user-profile'] ) ) {
		return;
	}

	if ( 'yes' !== $_REQUEST['thim-update-user-profile'] ) {
		return;
	}

	// Prevent redirection
	add_filter( 'learn-press/profile-updated-redirect', '__return_false' );
	$profile  = LP_Profile::instance();
	$postdata = $_POST;
	$nonce    = '';

	// Find the nonce
	foreach ( $postdata as $prop => $val ) {
		if ( preg_match( '~^save-profile-~', $prop ) ) {
			$nonce = $val;
			break;
		}
	}

	if ( ! $nonce ) {
		return;
	}

	// Save
	$profile->save( $nonce );

	die();
}

add_action( 'init', 'thim_update_user_profile_settings' );

if ( ! function_exists( 'thim_update_lp_info_major' ) ) {
	function thim_update_lp_info_major( $data ) {
		$data['lp_info_phone'] = filter_input( INPUT_POST, 'lp_info_phone', FILTER_SANITIZE_STRING );
		$data['lp_info_major'] = filter_input( INPUT_POST, 'lp_info_major', FILTER_SANITIZE_STRING );
		$data['lp_info_facebook'] = filter_input( INPUT_POST, 'lp_info_facebook', FILTER_SANITIZE_STRING );
		$data['lp_info_google_plus'] = filter_input( INPUT_POST, 'lp_info_google_plus', FILTER_SANITIZE_STRING );
		$data['lp_info_google_plus'] = filter_input( INPUT_POST, 'lp_info_google_plus', FILTER_SANITIZE_STRING );
		$data['lp_info_twitter'] = filter_input( INPUT_POST, 'lp_info_twitter', FILTER_SANITIZE_STRING );
		$data['lp_info_pinterest'] = filter_input( INPUT_POST, 'lp_info_pinterest', FILTER_SANITIZE_STRING );
		$data['lp_info_linkedin'] = filter_input( INPUT_POST, 'lp_info_linkedin', FILTER_SANITIZE_STRING );
		$data['lp_info_instagram'] = filter_input( INPUT_POST, 'lp_info_instagram', FILTER_SANITIZE_STRING );

		return $data;
	}
}
add_filter( 'learn-press/update-profile-basic-information-data', 'thim_update_lp_info_major' );

/**
 * Update user profile settings via AJAX call
 */
function thim_update_user_profile_settings_xxx() {

	if ( empty( $_REQUEST['thim-update-user-profile'] ) ) {
		return;
	}

	if ( 'yes' !== $_REQUEST['thim-update-user-profile'] ) {
		return;
	}

	// Prevent redirection
	add_filter( 'learn-press/profile-updated-redirect', '__return_false' );

	$profile  = LP_Profile::instance();
	$postdata = $_POST;
	$nonce    = '';

	// Find the nonce
	foreach ( $postdata as $prop => $val ) {
		if ( preg_match( '~^save-profile-~', $prop ) ) {
			$nonce = $val;
			break;
		}
	}

	if ( ! $nonce ) {
		return;
	}

	// Save
	$profile->save( $nonce );
	die();
}

add_action( 'init', 'thim_update_user_profile_settings_xxx' );





if ( ! function_exists( 'thim_content_item_edit_link' ) ) {
	function thim_content_item_edit_link() {
		$course      = LP_Global::course();
		if ( ! $course ) {
			return;
		}
		$course_item = LP_Global::course_item();
		$user        = LP_Global::user();
		if ( $user->can_edit_item( $course_item->get_id(), $course->get_id() ) ): ?>
            <p class="edit-course-item-link">
                <a href="<?php echo get_edit_post_link( $course_item->get_id() ); ?>"><i
                            class="fa fa-pencil-square-o"></i> <?php esc_html_e( 'Edit item', 'course-builder' ); ?>
                </a>
            </p>
		<?php endif;
	}
}
add_action( 'learn-press/after-course-item-content', 'thim_content_item_edit_link', 3 );



/**
 * Change tabs profile
 */
if ( ! function_exists( 'thim_change_tabs_course_profile' ) ) {
	function thim_change_tabs_course_profile( $defaults ) {
		unset($defaults['dashboard']);

		$defaults['courses']['priority']       = 3;
		$defaults['orders']['priority']        = 13;
		$defaults['order-details']['priority'] = 14;
		$defaults['settings']['priority']      = 100;

		return $defaults;
	}
}
add_filter( 'learn-press/profile-tabs', 'thim_change_tabs_course_profile', 1000 );

function thim_custom_collection_per_page( $query ) {

    $number = get_theme_mod('collection_per_page') ? get_theme_mod('collection_per_page') : 9;

    if ( is_post_type_archive( 'lp_collection' ) ) {
        $query->set( 'posts_per_page',$number );
        return;
    }
}
add_action( 'pre_get_posts', 'thim_custom_collection_per_page', 1000 );

function thim_custom_continue_shopping_redirect_url ( $url ) {
    $url = get_post_type_archive_link( 'lp_course' ); // Add your link here
    return $url;
}
add_filter('woocommerce_continue_shopping_redirect', 'thim_custom_continue_shopping_redirect_url');

/*
 * Add real students enrolled meta for orderby attribute in the query
 * */
add_action( 'init', 'thim_add_real_student_enrolled_meta' );

if ( ! function_exists( 'thim_add_real_student_enrolled_meta' ) ) {
    function thim_add_real_student_enrolled_meta( $lp ) {
        if ( isset( $_POST['course_orderby'] ) && 'most-members' == $_POST['course_orderby'] ) {
            $arg = array(
                'post_type'           => 'lp_course',
                'post_status'         => 'publish',
                'posts_per_page'      => - 1,
                'ignore_sticky_posts' => true
            );

            $course_query = new WP_Query( $arg );

            if ( $course_query->have_posts() ) {
                while ( $course_query->have_posts() ) {
                    $course_query->the_post();

                    $course = learn_press_get_course( get_the_ID() );

                    update_post_meta( get_the_ID(), 'thim_real_student_enrolled', $course->get_users_enrolled() );
                }

                wp_reset_postdata();
            }
        }
    }
}


/*
 * Change query get courses
 * */
add_action( 'pre_get_posts', 'thim_course_order_query', 15 );

if ( ! function_exists( 'thim_course_order_query' ) ) {
    function thim_course_order_query( $query ) {
        if ( ! $query->is_main_query() ) {
            return;
        }

        if ( ! is_post_type_archive( 'lp_course' ) && ! is_tax( 'course_category' ) ) {
            return;
        }

        // Sort
        if ( isset( $_POST['course_orderby'] ) ) {
            switch ( $_POST['course_orderby'] ) {
                case 'alphabetical':
                    $query->set( 'orderby', 'title' );
                    $query->set( 'order', 'ASC' );

                    break;
                case 'most-members':
                    $query->set( 'orderby', 'meta_value_num' );
                    $query->set( 'meta_key', 'thim_real_student_enrolled' );
                    $query->set( 'order', 'DESC' );

                    break;
                default:
                    $query->set( 'orderby', 'date' );
                    $query->set( 'order', 'DESC' );
            }
        }

        // Pagination
        if ( isset( $_POST['course_paged'] ) ) {
            $query->set( 'paged', $_POST['course_paged'] );
        }

        // Filter by categories
        if ( isset( $_POST['course_cate_filter'] ) && is_array( $_POST['course_cate_filter'] ) ) {
            $query->set( 'tax_query', array(
                array(
                    'taxonomy' => 'course_category',
                    'field'    => 'term_id',
                    'terms'    => $_POST['course_cate_filter'],
                )
            ) );
        }

        // Filter by instructor
        if ( isset( $_POST['course_instructor_filter'] ) && is_array( $_POST['course_instructor_filter'] ) ) {
            $query->set( 'author__in', $_POST['course_instructor_filter'] );
        }

        // Filter by price
        // TODO query courses has sale price
        if ( isset( $_POST['course_price_filter'] ) ) {
            switch ( $_POST['course_price_filter'] ) {
                case 'free':
                    $query->set( 'meta_query', array(
                        array(
                            'key'     => '_lp_price',
                            'compare' => 'NOT EXISTS'
                        )
                    ) );
                    break;
                case 'paid':
                    $query->set( 'meta_query', array(
                        array(
                            'key'     => '_lp_price',
                            'compare' => 'EXISTS'
                        )
                    ) );
                    break;
                case 'all':
                    break;

                default:

            }
        }
    }
}

if ( ! function_exists( 'thim_display_course_filter' ) ) {
    function thim_display_course_filter() {
        if ( ! get_theme_mod( 'thim_display_course_filter', false ) ) {
            return;
        }

        // Only display in the courses and course category pages
        if ( ! learn_press_is_courses() && ! learn_press_is_course_category() ) {
            return;
        }

        $total_course = wp_count_posts( 'lp_course' );

        if ( ! $total_course->publish ) {
            return;
        }
        ?>
        <aside class="widget thim-course-filter-wrapper">
            <h4 class="widget-title"><?php echo esc_html__('Course Filter',''); ?></h4>
            <div class="thim-course-filter-container">
                <form action="" name="thim-course-filter" method="POST" class="thim-course-filter">
                    <?php
                    // Filter courses by categories
                    if ( get_theme_mod( 'thim_filter_by_cate', false ) ) {
                        // Check total terms and empty terms
                        if ( ! wp_count_terms( 'course_category' ) ) {
                            return;
                        }

                        $course_term = get_terms( apply_filters( 'thim_display_cate_filter', array( 'taxonomy' => 'course_category' ) ) );
                        if ( is_wp_error( $course_term ) ) {
                            return;
                        }

                        $current_term_object = get_queried_object();
                        $current_term_id     = $current_term_object && 'course_category' === $current_term_object->taxonomy ? $current_term_object->term_id : '';
                        ?>

                        <h6 class="filter-title"><?php echo esc_html_x( 'By Categories', 'Course filter widget', 'course-builder' ); ?></h6>

                        <ul class="list-cate-filter">
                            <?php
                            foreach ( $course_term as $term ) {
                                $input_id = $term->slug . '_' . $term->term_id;
                                ?>
                                <li class="term-item">
                                    <?php if ( checked( $current_term_id, $term->term_id, false ) ): ?>
                                        <input type="checkbox" name="course-cate-filter" id="<?php esc_attr_e( $input_id ); ?>" class="filtered" value="<?php esc_attr_e( $term->term_id ); ?>" checked>
                                    <?php else: ?>
                                        <input type="checkbox" name="course-cate-filter" id="<?php esc_attr_e( $input_id ); ?>" value="<?php esc_attr_e( $term->term_id ); ?>">
                                    <?php endif; ?>
                                    <label for="<?php esc_attr_e( $input_id ) ?>">
                                        <?php esc_html_e( $term->name ); ?>
                                        <span><?php printf( esc_html__( '(%s)', 'course-builder' ), $term->count ); ?></span>
                                    </label>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                    }

                    // Filter courses by instructors
                    if ( get_theme_mod( 'thim_filter_by_instructor', false ) ) {
                        // TODO can create custom query to optimize speed
                        $course_query = new WP_Query( array(
                            'post_type'      => 'lp_course',
                            'posts_per_page' => - 1,
                        ) );
                        ?>
                        <h6 class="filter-title"><?php echo esc_html_x( 'By Instructors', 'Course filter widget', 'course-builder' ); ?></h6>
                        <?php
                        if ( $course_query->have_posts() ) {
                            global $post;
                            $list_instructor = array();
                            ?>
                            <ul class="list-instructor-filter">
                                <?php
                                while ( $course_query->have_posts() ) {
                                    $course_query->the_post();

                                    $instructor_id = $post->post_author;

                                    if ( ! array_key_exists( $instructor_id, $list_instructor ) ) {
                                        $list_instructor[ $instructor_id ] = 1;
                                    } else {
                                        $list_instructor[ $instructor_id ] += 1;
                                    }
                                }
                                wp_reset_postdata();

                                foreach ( $list_instructor as $instructor_id => $total ) {
                                    ?>
                                    <li class="instructor-item">
                                        <input type="checkbox" name="course-instructor-filter" id="instructor-id_<?php esc_attr_e( $instructor_id ) ?>" value="<?php esc_attr_e( $instructor_id ); ?>">
                                        <label for="instructor-id_<?php esc_attr_e( $instructor_id ) ?>">
                                            <?php echo get_the_author_meta( 'display_name', $instructor_id ) ?>
                                            <span><?php printf( esc_html__( '(%s)', 'course-builder' ), $total ); ?></span>
                                        </label>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <?php
                        }
                    }

                    // Filter by price
                    if ( get_theme_mod( 'thim_filter_by_price' ) ) {
                        $paid_course_query = new WP_Query( array(
                            'post_type'      => 'lp_course',
                            'posts_per_page' => - 1,
                            'meta_key'       => '_lp_price',
                            'meta_compare'   => 'EXISTS'
                        ) );

                        $number_paid_course = $paid_course_query->post_count;
                        $number_free_course = $total_course->publish - $number_paid_course;
                        ?>
                        <h6 class="filter-title"><?php echo esc_html_x( 'By Price', 'Course filter widget', 'course-builder' ); ?></h6>

                        <ul class="list-price-filter">
                            <li class="price-item">
                                <input type="radio" id="price-filter_all" name="course-price-filter" value="all" checked>
                                <label for="price-filter_all">
                                    <?php esc_html_e( 'All', 'course-builder' ); ?>
                                    <span><?php printf( esc_html__( '(%s)', 'course-builder' ), $total_course->publish ); ?></span>
                                </label>
                            </li>
                            <li class="price-item">
                                <input type="radio" id="price-filter_free" name="course-price-filter" value="free">
                                <label for="price-filter_free">
                                    <?php esc_html_e( 'Free', 'course-builder' ); ?>
                                    <span><?php printf( esc_html__( '(%s)', 'course-builder' ), $number_free_course ); ?></span>
                                </label>
                            </li>
                            <li class="price-item">
                                <input type="radio" id="price-filter_paid" name="course-price-filter" value="paid">
                                <label for="price-filter_paid">
                                    <?php esc_html_e( 'Paid', 'course-builder' ); ?>
                                    <span><?php printf( esc_html__( '(%s)', 'course-builder' ), $number_paid_course ); ?></span>
                                </label>
                            </li>
                        </ul>
                        <?php
                    }
                    ?>

                    <div class="filter-submit">
                        <button type="submit"><?php esc_html_e( 'Filter Results', 'course-builder' ) ?></button>
                    </div>
                </form>
            </div>
        </aside>
        <?php
    }
}

add_action( 'thim_before_sidebar_course', 'thim_display_course_filter' );

