<?php

global $current_user;

$levels       = lp_pmpro_get_all_levels();
$list_courses = lp_pmpro_list_courses( $levels );

asort( $list_courses );

?>
<?php do_action( 'learn_press_pmpro_before_levels' ); ?>
	<div id="shaon-pricing-table-plus" class="gray">
		<div class="minimal">
			<?php
			if ( ! empty( $list_courses ) ) { ?>
				<div class="highlight plan list-interval">
					<div class="detail"><h3>
							<span class="icon"><i class="fa fa-book"></i></span><span class="title">1</span><span class="interval">2</span>
						</h3><h4><span class="amount">3</span></h4></div>
					<div class="features">
						<ul>
							<li class="reply-title"><?php esc_html_e( 'Number of courses', 'course-builder' ); ?></li>
							<?php
							foreach ( $list_courses as $key => $course_item ) {
								$class_course = '';
								if ( isset( $_GET['course_id'] ) && ! empty( $_GET['course_id'] ) ) {
									$course_id = $_GET['course_id'];
									if ( absint( $course_id ) === $course_item['id'] ) {
										$class_course = apply_filters( 'learn-press-pmpro-levels-page-current-course', 'learn-press-course-current', $course_item, $course_id );

									}
								}
								echo apply_filters( 'learn_pres_pmpro_course_header_level', '<li class="list-main item-td">' . wp_kses_post( $course_item["link"] ) . '</li>', $course_item["link"], $course_item, $key );
							}
							?>
						</ul>
					</div>
					<div class="select">
						<div>
							<a href="" class="pt-button"><span>a</span></a>
						</div>
					</div>
				</div>
				<?php
			}
			?>

			<?php
			$class_count = ' has-' . count( $levels );
			$i = 0;
			foreach ( $levels as $index => $level ):
				$current_level = false;
				$i++;
				if ( isset( $current_user->membership_level->ID ) ) {
					if ( $current_user->membership_level->ID == $level->id ) {
						$current_level = true;
					}
				}
				$featured = '';
				if ( $i == 2 ) {
					$featured = 'featured';
				}

				?>
				<div class="highlight plan <?php echo( $class_count . ' p' . $index . ' ' . $featured ); ?>">
					<div class="detail">
						<h4><span class="amount"><?php if ( pmpro_isLevelFree( $level ) ): ?><?php esc_html_e( 'Free', 'course-builder' ); ?><?php else: ?>
									<?php
									global $pmpro_currency, $pmpro_currency_symbol, $pmpro_currencies;

									$price = $level->initial_payment;
									//start with the price formatted with two decimals
									$formatted = number_format( (double) $price, 0 );

									//settings stored in array?
									if ( ! empty( $pmpro_currencies[ $pmpro_currency ] ) && is_array( $pmpro_currencies[ $pmpro_currency ] ) ) {
										//format number do decimals, with decimal_separator and thousands_separator
										$formatted = number_format( $price,
											( isset( $pmpro_currencies[ $pmpro_currency ]['decimals'] ) ? (int) $pmpro_currencies[ $pmpro_currency ]['decimals'] : 2 ),
											( isset( $pmpro_currencies[ $pmpro_currency ]['decimal_separator'] ) ? $pmpro_currencies[ $pmpro_currency ]['decimal_separator'] : '.' ),
											( isset( $pmpro_currencies[ $pmpro_currency ]['thousands_separator'] ) ? $pmpro_currencies[ $pmpro_currency ]['thousands_separator'] : ',' )
										);

										//which side is the symbol on?
										if ( ! empty( $pmpro_currencies[ $pmpro_currency ]['position'] ) && $pmpro_currencies[ $pmpro_currency ]['position'] == 'left' ) {
											$formatted = $pmpro_currency_symbol . $formatted;
										} else {
											$formatted = $formatted . $pmpro_currency_symbol;
										}
									} else {
										$formatted = $pmpro_currency_symbol . $formatted;
									}    //default to symbol on the left

									//filter
									$cost_text = apply_filters( 'pmpro_format_price', $formatted, $price, $pmpro_currency, $pmpro_currency_symbol );

									echo ent2ncr( $cost_text ); ?>
								<?php endif; ?></span>
						</h4>
						<h3>
							<span class="title"><?php echo esc_html( $level->name ); ?></span>
							<?php
							if ( ! empty( $level->description ) ) {
								echo '<span class="interval">' . $level->description . '</span>';
							}
							?>
						</h3>
					</div>
					<div class="features">
						<ul>
							<?php
							$the_query = lp_pmpro_query_course_by_level( $level->id );
							$count     = count( $the_query->posts );
							echo '<li class="list-item item-td"><span class="item-mobile">' . esc_html__( "Number of courses", "course-builder" ). ':</span> ' . esc_html( $count ) . '</li>';


							if ( ! empty( $list_courses ) ) {
								foreach ( $list_courses as $key => $course_item ) {
									$class_course = '';
									if ( isset( $_GET['course_id'] ) && ! empty( $_GET['course_id'] ) ) {
										$course_id = $_GET['course_id'];
										if ( absint( $course_id ) === $course_item['id'] ) {
											$class_course = apply_filters( 'learn-press-pmpro-levels-page-current-course', 'learn-press-course-current', $course_item, $course_id );

										}
									}
									?>
										<?php
										if ( in_array( $level->id, $course_item['level'] ) ) {
											echo '<li class="item-row ' . esc_attr( $class_course ) .'">';
											echo apply_filters( 'learn_pres_pmpro_course_header_level', '<span class="item-mobile">' . wp_kses_post( $course_item["link"] ) . ': </span>', $course_item["link"], $course_item, $key );
											echo apply_filters( 'learn_press_pmpro_course_is_level', '<i class="fa fa-check" aria-hidden="true"></i>', $level, $index, $course_item, $key );
											echo '</li>';
										} else {
											echo '<li class="item-row hidden-mobile' . esc_attr( $class_course ) .'">';
											echo apply_filters( 'learn_press_pmpro_course_is_not_level', '<i class="fa fa-close" aria-hidden="true"></i>', $level, $index, $course_item, $key );
											echo '</li>';
										}

										?>
									</li>
									<?php
								}
							}
							?>
						</ul>
					</div>
					<div class="select">
						<div>
							<?php if ( empty( $current_user->membership_level->ID ) || ! $current_level ) { ?>
								<a class="pt-button pmpro_btn pmpro_btn-select" href="<?php echo pmpro_url( 'checkout', '?level=' . $level->id, 'https' ) ?>"><span><?php esc_html_e( 'GET STARTED', 'course-builder' ); ?></span></a>
							<?php } elseif ( $current_level ) { ?>
								<?php
								if ( pmpro_isLevelExpiringSoon( $current_user->membership_level ) && $current_user->membership_level->allow_signups ) {
									?>
									<a class="pt-button pmpro_btn pmpro_btn-select"
									   href="<?php echo pmpro_url( 'checkout', '?level=' . $level->id, 'https' ) ?>"><span><?php esc_html_e( 'Renew', 'course-builder' ); ?></span></a>
									<?php
								} else {
									?>
									<a class="pt-button pmpro_btn disabled" href="<?php echo pmpro_url( 'account' ) ?>"><span><?php esc_html_e( 'Your Level', 'course-builder' ); ?></span></a>
									<?php
								}
								?>

							<?php } ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div style="clear:both"></div>
	</div>
<?php do_action( 'learn_press_pmpro_after_levels' ); ?>