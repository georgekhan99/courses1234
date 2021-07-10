<?php
$course        = new LP_Course( intval( $params['id_course'] ) );
if ( $course->post ):
	LP()->global['course'] = $course;
	$hide_text = '';
	if ( $params['hide_text'] == 'yes' ) {
		$hide_text = 'hide_text';
	}
	?>
    <div class="thim-sc-enroll-course  <?php echo esc_attr( $params['el_class'] . '' . $hide_text ); ?>">
		<?php if ( $params['hide_text'] != 'yes' ): ?>

            <h3 class="title-course">
                <a href="<?php the_permalink( $course->id ); ?>">
					<?php echo esc_html( $course->get_course_data()->post_title ) . ' (' . $course->get_price_html() . ')'; ?>
                </a>
            </h3>

			<?php if ( get_the_excerpt( $course->id ) ): ?>
                <div class="excerpt">
                    <p><?php echo esc_html( get_the_excerpt( $course->id ) ); ?></p>
                </div>
			<?php endif;
		endif; ?>

		<?php
		/**
		 * Template for displaying the enroll button
		 *
		 * @author  ThimPress
		 * @package LearnPress/Templates
		 * @version 2.1.6
		 */

		$lp_user = $user = learn_press_get_current_user();
		$in_cart = learn_press_is_added_to_cart( $course->id );
		// only show enroll button if user had not enrolled
		$purchase_button_text  = apply_filters( 'learn_press_purchase_button_text', esc_attr__( 'Buy this course', 'course-builder' ) );
		$enroll_button_text    = apply_filters( 'learn_press_enroll_button_text', esc_attr__( 'Enroll', 'course-builder' ) );
		$retake_button_text    = apply_filters( 'learn_press_retake_button_text', esc_attr__( 'Retake', 'course-builder' ) );
		$notice_enough_student = apply_filters( 'learn_press_course enough students_notice', esc_attr__( 'The class is full so enrollment is closed. Please contact the site admin.', 'course-builder' ) );
		?>
        <div class="learn-press-course-buttons">
			<?php do_action( 'learn_press_before_course_buttons', $course->id ); ?>
			<?php

			$course_status = $lp_user->get_course_status( $course->id );
			$can_purchase  = $lp_user->can_purchase_course( $course->id );
			$can_enroll    = $lp_user->can( 'enroll-course', $course->id );
			$can_retake    = $lp_user->can_retake_course( $course->id, true );
			//TODO using learn-press/course-buttons hook
			if ( $can_purchase ) {
				if ( $external_link = $course->get_external_link() ) {
					$external_button_text = apply_filters( 'learn_press_course_external_link_button_text', esc_attr__( 'Buy this course', 'course-builder' ) );
					do_action( 'learn_press_before_external_link_buy_course' );
					?>
                    <div class="purchase-course">
                        <a href="<?php echo esc_url( $external_link ); ?>" class="purchase-button">
							<?php echo( $external_button_text ); ?>
                        </a>
                    </div>
					<?php
				} else {
					?>
                    <form name="purchase-course" class="purchase-course" method="post" enctype="multipart/form-data">
						<?php do_action( 'learn_press_before_purchase_button' ); ?>
                        <button class="button purchase-button" data-block-content="yes">
							<?php echo( $course->is_free() ? $enroll_button_text : $purchase_button_text ); ?>
                        </button>
						<?php do_action( 'learn_press_after_purchase_button' ); ?>
                        <input type="hidden" name="purchase-course" value="<?php echo esc_attr( $course->id ); ?>" />
                        <input type="hidden" value="user can purchase course" />
                    </form>
					<?php
				}
			} elseif ( $can_enroll ) {
				#echo "show can enroll button";
			}
			if ( $external_link = $course->get_external_link() ):
				$external_button_text = apply_filters( 'learn_press_course_external_link_button_text', esc_attr__( 'Buy this course', 'course-builder' ) );
				?>
				<?php do_action( 'learn_press_before_external_link_buy_course' ); ?>
                <div class="purchase-course">
                    <a href="<?php echo esc_url( $external_link ); ?>" class="purchase-button">
						<?php echo( $external_button_text ); ?>
                    </a>
                </div>
				<?php do_action( 'learn_press_after_external_link_buy_course' ); ?>
			<?php else:
				if ( $course->is_required_enroll() ) {
					$course_status = learn_press_get_user_course_status();
					$user          = learn_press_get_current_user();
					$in_cart       = learn_press_is_added_to_cart( $course->id );
					// only show enroll button if user had not enrolled
					$purchase_button_text  = apply_filters( 'learn_press_purchase_button_text', esc_attr__( 'Buy this course', 'course-builder' ) );
					$enroll_button_text    = apply_filters( 'learn_press_enroll_button_text', esc_attr__( 'Enroll', 'course-builder' ) );
					$retake_button_text    = apply_filters( 'learn_press_retake_button_text', esc_attr__( 'Retake', 'course-builder' ) );
					$notice_enough_student = apply_filters( 'learn_press_course enough students_notice', esc_attr__( 'The class is full so enrollment is closed. Please contact the site admin.', 'course-builder' ) );

					# -------------------------------
					# Finished Course
					# -------------------------------
					if ( $user->has( 'finished-course', $course->id ) ): ?>
						<?php if ( $count = $user->can( 'retake-course', $course->id ) ): ?>
                            <button
                                    class="button-retake-course"
                                    data-course_id="<?php echo esc_attr( $course->id ); ?>"
                                    data-security="<?php echo esc_attr( wp_create_nonce( sprintf( 'learn-press-retake-course-%d-%d', $course->id, $user->id ) ) ); ?>">
								<?php echo esc_html( sprintf( __( 'Retake course (+%d)', 'course-builder' ), $count ) ); ?>
                            </button>
						<?php endif; ?>
					<?php
					# -------------------------------
					# Enrolled Course
					# -------------------------------
                    elseif ( $user->has( 'enrolled-course', $course->id ) ): ?>
						<?php
						$can_finish             = $user->can_finish_course( $course->id );
						$finish_course_security = wp_create_nonce( sprintf( 'learn-press-finish-course-' . $course->id . '-' . $user->id ) );
						?>
                        <button
                                id="learn-press-finish-course"
                                class="button button-finish-course<?php echo ! $can_finish ? ' hide-if-js' : ''; ?>"
                                data-id="<?php echo esc_attr( $course->id ); ?>"
                                data-security="<?php echo esc_attr( $finish_course_security ); ?>">
							<?php esc_html_e( 'Finish course', 'course-builder' ); ?>
                        </button>
						<?php if ( ! $can_finish ) : ?>
                            <a class="button" href="<?php the_permalink( $course->id ); ?>"><?php esc_html_e( 'View Course', 'course-builder' ); ?></a>
						<?php endif; ?>
					<?php elseif ( $user->can( 'enroll-course', $course->id ) === true ) : ?>
                        <form name="enroll-course" class="enroll-course" method="post" enctype="multipart/form-data">
							<?php do_action( 'learn_press_before_enroll_button' ); ?>

                            <input type="hidden" name="lp-ajax" value="enroll-course" />
                            <input type="hidden" name="enroll-course" value="<?php esc_attr( $course->id ); ?>" />
                            <button class="button enroll-button"
                                    data-block-content="yes"><?php echo( $enroll_button_text ); ?></button>

							<?php do_action( 'learn_press_after_enroll_button' ); ?>
                        </form>
					<?php elseif ( $user->can( 'purchase-course', $course->id ) && ! $can_purchase ) : ?>
                        <form name="purchase-course" class="purchase-course" method="post" enctype="multipart/form-data">
							<?php do_action( 'learn_press_before_purchase_button' ); ?>
                            <button class="button purchase-button" data-block-content="yes">
								<?php echo( $course->is_free() ? $enroll_button_text : $purchase_button_text ); ?>
                            </button>
							<?php do_action( 'learn_press_after_purchase_button' ); ?>
                            <input type="hidden" name="purchase-course" value="<?php echo esc_attr( $course->id ); ?>" />
                            <input type="hidden" value="user can purchase course" />
                        </form>

					<?php elseif ( $course->is_reached_limit()/* $user->can( 'enroll-course', $course->id ) === 'enough'*/ ) : ?>
                        <p class="learn-press-message"><?php echo( $notice_enough_student ); ?></p>
					<?php else: ?>
						<?php $order_status = $user->get_order_status( $course->id ); ?>
						<?php if ( in_array( $order_status, array(
							'lp-pending',
							'lp-refunded',
							'lp-cancelled',
							'lp-failed'
						) ) ) { ?>
                            <form name="purchase-course" class="purchase-course" method="post" enctype="multipart/form-data">
								<?php do_action( 'learn_press_before_purchase_button' ); ?>
                                <button class="button purchase-button" data-block-content="yes">
									<?php echo( $course->is_free() ? $enroll_button_text : $purchase_button_text ); ?>
                                </button>
								<?php do_action( 'learn_press_after_purchase_button' ); ?>
                                <input type="hidden" name="purchase-course" value="<?php echo esc_attr( $course->id ); ?>" />
                                <input type="hidden" value="user order cancelled" />

                            </form>
						<?php } elseif ( in_array( $order_status, array( 'lp-processing', 'lp-on-hold' ) ) ) { ?>
							<?php learn_press_display_message( '<p>' . apply_filters( 'learn_press_user_course_pending_message', esc_attr__( 'Your order is processing. Please wait for approval.', 'course-builder' ), $course, $user ) . '</p>' ); ?>
						<?php } elseif ( $order_status && $order_status != 'lp-completed' ) { ?>
							<?php learn_press_display_message( '<p>' . apply_filters( 'learn_press_user_can_not_purchase_course_message', esc_attr__( 'Sorry, you can not purchase this course', 'course-builder' ), $course, $user ) . '</p>' ); ?>
						<?php } ?>
					<?php endif;
				}
			endif;
			?>
			<?php do_action( 'learn_press_after_course_buttons', $course->id ); ?>
        </div>

    </div>
<?php
endif;