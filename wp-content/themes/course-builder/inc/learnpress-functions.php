<?php
// wishlist button
if ( ! function_exists( 'thim_course_wishlist_button' ) ) {
	function thim_course_wishlist_button( $course_id = null ) {
		if ( ! thim_plugin_active( 'learnpress-wishlist/learnpress-wishlist.php' ) && ! class_exists( 'LP_Addon_Wishlist' ) ) {
			return;
		}
		LP_Addon_Wishlist::instance()->wishlist_button( $course_id );

	}
}

/**
 * Get course, lesson, ... duration in hours
 *
 * @param $id
 *
 * @param $post_type
 *
 * @return string
 */

if ( ! function_exists( 'thim_duration_time_calculator' ) ) {
	function thim_duration_time_calculator( $id, $post_type = 'lp_course' ) {
		if ( $post_type == 'lp_course' || $post_type == 'lp_quiz' ) {
			$course_duration_meta = get_post_meta( $id, '_lp_duration', true );
			$course_duration_arr  = array_pad( explode( ' ', $course_duration_meta, 2 ), 2, 'minute' );

			list( $number, $time ) = $course_duration_arr;

			switch ( $time ) {
				case 'week':
					$course_duration_text = sprintf( _n( "%s week", "%s weeks", $number, 'course-builder' ), $number );
					break;
				case 'day':
					$course_duration_text = sprintf( _n( "%s day", "%s days", $number, 'course-builder' ), $number );
					break;
				case 'hour':
					$course_duration_text = sprintf( _n( "%s hour", "%s hours", $number, 'course-builder' ), $number );
					break;
				default:
					$course_duration_text = sprintf( _n( "%s minute", "%s minutes", $number, 'course-builder' ), $number );
			}

			return $course_duration_text;

		} else {
			$duration = get_post_meta( $id, '_lp_duration', true );

			if ( ! $duration ) {
				return '';
			}
			$duration = ( strtotime( $duration ) - time() ) / 60;
			$hour     = floor( $duration / 60 );

			if ( ! $duration ) {
				return '';
			}
			if ( $hour == 0 ) {
				$hour = '';
			} else {
				$hour = $hour . esc_html__( 'h', 'course-builder' ) . esc_html__( ':', 'course-builder' );
			}
			$minute = $duration % 60;
			$minute = $minute . esc_html__( 'm', 'course-builder' );

			return $hour . $minute;
		}
	}
}
// add format icon for item lession

add_action( 'learn-press/begin-section-loop-item', 'thim_add_format_icon' );
if ( ! function_exists( 'thim_add_format_icon' ) ) {
	function thim_add_format_icon( $item ) {
		$format = get_post_format( $item->get_id() );
		if ( get_post_type( $item->get_id() ) == 'lp_quiz' ) {
			echo '<span class="course-format-icon"><i class="fa fa-puzzle-piece"></i></span>';
		} elseif ( $format == 'video' ) {
			echo '<span class="course-format-icon"><i class="fa fa-play"></i></span>';
		} elseif ( $format == 'audio' ) {
			echo '<span class="course-format-icon"><i class="fa fa-music"></i></span>';
		} elseif ( $format == 'image' ) {
			echo '<span class="course-format-icon"><i class="fa fa-picture-o"></i></span>';
		} elseif ( $format == 'aside' ) {
			echo '<span class="course-format-icon"><i class="fa fa-file-archive"></i></span>';
		} elseif ( $format == 'quote' ) {
			echo '<span class="course-format-icon"><i class="fa fa-quote-left"></i></span>';
		} elseif ( $format == 'link' ) {
			echo '<span class="course-format-icon"><i class="fa fa-link"></i></span>';
		} else {
			echo '<span class="course-format-icon"><i class="fa fa-file-archive"></i></span>';
		}
	}
}

// Show Related Courses

function thim_get_related_courses( $limit ) {
	if ( ! $limit ) {
		$limit = 3;
	}
	$course_id = get_the_ID();

	$tag_ids = array();
	$tags    = get_the_terms( $course_id, 'course_tag' );

	if ( $tags ) {
		foreach ( $tags as $individual_tag ) {
			$tag_ids[] = $individual_tag->slug;
		}
	}

	$args = array(
		'posts_per_page'      => $limit,
		'paged'               => 1,
		'ignore_sticky_posts' => 1,
		'post__not_in'        => array( $course_id ),
		'post_type'           => 'lp_course'
	);

	if ( $tag_ids ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'course_tag',
				'field'    => 'slug',
				'terms'    => $tag_ids
			)
		);
	}
	$related = array();
	if ( $posts = new WP_Query( $args ) ) {
		global $post;
		while ( $posts->have_posts() ) {
			$posts->the_post();
			$related[] = $post;
		}
	}
	wp_reset_query();

	return $related;
}
if ( ! function_exists( 'thim_related_courses' ) ) {

	function thim_related_courses() {
		$related_courses = thim_get_related_courses( 6 );
		if ( $related_courses ) {
			?>
			<div class="thim-related-course">
				<h3 class="related-title"><?php esc_html_e( 'Related Courses', 'course-builder' ); ?></h3>

				<div class="courses-carousel archive-courses course-grid owl-carousel owl-theme" data-cols="3">
					<?php foreach ( $related_courses as $course_item ) : ?>
						<?php
                        $classes = "";
						$course      = LP_Course::get_course( $course_item->ID );
						$is_required = $course->is_required_enroll();
						$course_id   = $course_item->ID;
						if ( class_exists( 'LP_Addon_Course_Review' ) ) {
							$course_rate              = learn_press_get_course_rate( $course_id );
							$course_number_vote       = learn_press_get_course_rate_total( $course_id );
							$html_course_number_votes = $course_number_vote ? sprintf( _n( '(%1$s vote )', ' (%1$s votes)', $course_number_vote, 'course-builder' ), number_format_i18n( $course_number_vote ) ) : esc_html__( '(0 vote)', 'course-builder' );
						}

                        $is_course_in_membership = (bool) get_post_meta( $course->get_id(), '_lp_pmpro_levels', false );

                        if( $is_course_in_membership ){
                            $classes = "in-membership";
                        }

						?>
						<div class="inner-course <?php echo esc_attr($classes) ?>">
							<?php do_action( 'learn_press_before_course_header' ); ?>

							<div class="wrapper-course-thumbnail">
								<?php if ( has_post_thumbnail( $course_id ) ) : ?>
									<a href="<?php the_permalink( $course_id ); ?>"
									   class="img_thumbnail"><?php thim_thumbnail( $course_id, '277x310', 'post', false ); ?></a>
								<?php endif; ?>
								<div class="course-price">
									<?php

										$origin_price = $course->get_origin_price_html();
										$sale_price   = $course->get_sale_price();
                                        $price        = $course->get_price();
                                        $price        = learn_press_format_price( $price, true );
										$sale_price   = isset( $sale_price ) ? $sale_price : '';
										?>
										<?php if ( $course->is_free() || ! $is_required ) { ?>
											<div class="value free-course" itemprop="price"
											     content="<?php esc_attr_e( 'Free', 'course-builder' ); ?>">
												<?php esc_html_e( 'Free', 'course-builder' ); ?>
											</div>
										<?php } else {

											if ( $sale_price !== false ) {
												echo '<span class="course-origin-price">' . $origin_price . '</span>';
											}
											echo '<span class="price">' . esc_html( $price ) . '</span>';
										}
									 ?>
								</div>
								<?php if ( isset( $course_rate ) ): ?>
									<div class="course-rating">
										<?php learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) ); ?>
									</div>
								<?php endif; ?>

							</div>
							<div class="item-list-center">
								<div class="course-title">
									<h2 class="title">
										<a href="<?php echo esc_url( get_the_permalink( $course_item->ID ) ); ?>"> <?php echo get_the_title( $course_item->ID ); ?></a>
									</h2>
								</div>
								<?php
								$count = $course->get_users_enrolled( 'append' ) ? $course->get_users_enrolled( 'append' ) : 0;
								?>
								<span class="date-comment">

                                    <span class="date"><?php echo get_the_date() . ' / '; ?></span>

									<span class="comment"><?php $comment = get_comments_number();
                                        if ( $comment == 0 ) {
                                            echo esc_html__( "No Comments", 'course-builder' );
                                        } else {
                                            echo sprintf( _n( '%d Comment', '%d Comments', $comment, 'course-builder' ), $comment);
                                        }
                                        ?></span>
								</span>
                                <div class="author">
                                    <?php
                                    $course      = get_post( $course_item->ID );
                                    $user_data   = get_userdata( $course->post_author );

                                    $author_name = '';
                                    if ( $user_data ) {
                                        if( !empty( $user_data->display_name ) ) {
                                            $author_name = $user_data->display_name;
                                        }else{
                                            $author_name = $user_data->user_login;
                                        }
                                    }
                                    echo $author_name;
                                    ?>

                                </div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<?php
		}
	}
}

// add class in single course
function thim_learnpress_body_classes( $classes ) {

	if ( is_singular( 'lp_course' ) ) {
		$layouts = get_theme_mod( 'learnpress_single_course_style', 1 );
		$layouts = isset( $_GET['layout'] ) ? $_GET['layout'] : $layouts;

		$classes[] = 'thim-lp-layout-' . $layouts;

		if ( learn_press_is_learning_course() ) {
			$classes[] = 'lp-learning';
		} else {
			$classes[] = 'lp-landing';
		}
	}

	if ( learn_press_is_profile() ) {
		$classes[] = 'lp-profile';
	}

	return $classes;
}

add_filter( 'body_class', 'thim_learnpress_body_classes' );



if ( ! function_exists( 'learn_press_course_price' ) ) {
	/**
	 * Display course price.
	 */
	function learn_press_course_price() {
		$user   = LP_Global::user();
		$course = LP_Global::course();

		if ( $user && $user->has_enrolled_course( $course->get_id() ) ) {
			return;
		}

		learn_press_get_template( 'single-course/price.php' );
	}
}
if ( ! function_exists( 'learn_press_course_button' ) ) {
	/**
	 * Display course retake button
	 */
	function learn_press_course_button() {
		learn_press_get_template( 'single-course/buttons.php' );
	}
}

// Check is landing page
if ( ! function_exists( 'thim_is_learning' ) ) {
	/**
	 * true if is learning page, false if is landing page.
	 * @return bool
	 */
	function thim_is_learning() {
		if ( learn_press_is_learning_course() ) {
			return true;
		} else {
			return false;
		}
	}
}
// Course review

if(!function_exists('thim_course_rate')){
	function thim_course_rate() {
		echo '<div class="landing-review">';
			learn_press_course_review_template( 'course-rate.php' );
			learn_press_course_review_template( 'course-review.php' );
		echo '</div>';
	}
}