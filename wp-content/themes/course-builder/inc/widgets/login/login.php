<?php

/**
 * Adds Thim_Login_Widget widget.
 */
if ( ! class_exists( 'Thim_Login_Widget' ) ) {
	class Thim_Login_Widget extends WP_Widget {

		function __construct() {
			parent::__construct(
				'thim-login',
				esc_html__( 'Thim: Login Popup', 'course-builder' ),
				array( 'description' => esc_html__( 'Display login link', 'course-builder' ), )
			);
		}

		public function widget( $args, $instance ) {
			$theme_options_data = get_theme_mods();
			$default_instance   = array(
				'text_register' => esc_attr__( 'Register', 'course-builder' ),
				'text_login'    => esc_attr__( 'Login', 'course-builder' ),
				'text_logout'   => esc_attr__( 'Logout', 'course-builder' ),
				'link'          => get_permalink( get_page_by_path( 'account' ) ),
				'shortcode'     => '[wordpress_social_login]',
				'term'          => '',
				'popup'         => true,
				'captcha'       => false,
				'phone'         => false,
				'first_name'    => false,
				'last_name'     => false,
			);


			$instance = wp_parse_args( (array) $instance, $default_instance );

			echo ent2ncr( $args['before_widget'] );

			$html = '';
			if ( is_user_logged_in() ) {
				$user              = wp_get_current_user();
				$user_profile_edit = get_edit_user_link( $user->ID );
				$user_avatar       = get_avatar( $user->ID, 45 );

				if ( ! class_exists( 'LearnPress' ) ) {
					$html .= '<a href="' . esc_url( $user_profile_edit ) . '" class="user-name"><span class="author">' . $user->display_name . '</span>' . ( $user_avatar ) . '</a>';
					$html .= '<ul class="user-info">';
				} else {
					$profile       = LP_Profile::instance();
					$allowed_roles = array( 'editor', 'administrator', 'author', 'instructor' );

					if ( array_intersect( $allowed_roles, $user->roles ) ) {
						$html .= '<a href="' . esc_url( $user_profile_edit ) . '" class="user-name"><span class="author">' . $user->display_name . '</span>' . ( $user_avatar ) . '</a>';
					} else {
						$html .= '<a href="' . esc_url( $profile->get_tab_link( 'settings', true ) ) . '" class="user-name"><span class="author">' . $user->display_name . '</span>' . ( $user_avatar ) . '</a>';
					}

					$html .= '<ul class="user-info">';

					$items = get_theme_mod( 'profile_menu_items' ); // Get items from customize

					$menu_items_output = '';

					$profile_page = learn_press_get_page_link( 'profile' );
					$current_user = wp_get_current_user();


					$user = learn_press_get_current_user();


					if ( is_array( $items ) && count( $items ) > 0 ) {
						$lp_setting    = LP()->settings;
						$view_endpoint = $lp_setting->get( 'learn_press_profile_endpoints' );

						$view_endpoint_basic_information = isset( $view_endpoint['settings-basic-information'] ) ? $view_endpoint['settings-basic-information'] : '';
						$view_endpoint_orders            = isset( $view_endpoint['profile-orders'] ) ? $view_endpoint['profile-orders'] : '';
						$view_endpoint_settings          = isset( $view_endpoint['profile-settings'] ) ? $view_endpoint['profile-settings'] : '';


						for ( $index = 0; $index < count( $items ); $index ++ ) {

							switch ( $items[$index] ) {
								case 'courses':
									if ( 0 == $current_user->ID ) {
										$menu_items_output .= '<li class="menu-item menu-item-courses"><a href="' . esc_url( $profile->get_tab_link( 'courses', true ) ) . '">' . esc_html__( 'My Courses', 'course-builder' ) . '</a></li>';

									} else {
										$menu_items_output .= '<li class="menu-item menu-item-courses"><a href="' . esc_url( $profile_page . wp_get_current_user()->user_login ) . '">' . esc_html__( 'My Courses', 'course-builder' ) . '</a></li>';

									}

									break;
								case 'orders':
									if ( 0 == $current_user->ID ) {
										$menu_items_output .= '<li class="menu-item menu-item-orders"><a href="' . esc_url( $profile->get_tab_link( 'orders', true ) ) . '">' . esc_html__( 'My Orders', 'course-builder' ) . '</a></li>';

									} else {
										if ( ! empty( $view_endpoint_orders ) ) {
											$menu_items_output .= '<li class="menu-item menu-item-orders"><a href="' . esc_url( $profile_page . wp_get_current_user()->user_login ) . '/' . $view_endpoint_orders . '">' . esc_html__( 'My Orders', 'course-builder' ) . '</a></li>';
										} else {
											$menu_items_output .= '<li class="menu-item menu-item-orders"><a href="' . esc_url( $profile_page . wp_get_current_user()->user_login ) . '/orders' . '">' . esc_html__( 'My Orders', 'course-builder' ) . '</a></li>';
										}

									}
									break;
								case 'become_a_teacher':
									$menu_items_output .= '<li class="menu-item menu-item-become-a-teacher"><a href="' . learn_press_get_page_link( 'become_a_teacher' ) . '">' . esc_html__( 'Become An Instructor', 'course-builder' ) . '</a></li>';

									break;
								case 'certificates':
									if ( ! class_exists( 'LP_Addon_Certificates' ) ) {
										break;
									}
									if ( 0 == $current_user->ID ) {
										$menu_items_output .= '<li class="menu-item menu-item-certificates"><a href="' . esc_url( $profile->get_tab_link( 'certificates', true ) ) . '">' . esc_html__( 'My Certificates', 'course-builder' ) . '</a></li>';
									} else {
										$menu_items_output .= '<li class="menu-item menu-item-certificates"><a href="' . esc_url( $profile_page . wp_get_current_user()->user_login ) . '/certificates' . '">' . esc_html__( 'My Certificates', 'course-builder' ) . '</a></li>';
									}
									break;
								case 'settings':
									if ( 0 == $current_user->ID ) {
										$menu_items_output .= '<li class="menu-item menu-item-settings"><a href="' . esc_url( $profile->get_tab_link( 'settings', true ) ) . '">' . esc_html__( 'Edit Profile 123456', 'course-builder' ) . '</a></li>';
									} else {
										if ( ! empty( $view_endpoint_settings ) ) {
											if ( ! empty( $view_endpoint_basic_information ) ) {
												$menu_items_output .= '<li class="menu-item menu-item-settings"><a href="' . esc_url( $profile_page . wp_get_current_user()->user_login ) . '/' . $view_endpoint_settings . '/' . $view_endpoint_basic_information . '">' . esc_html__( 'Edit Profile', 'course-builder' ) . '</a></li>';
											} else {
												$menu_items_output .= '<li class="menu-item menu-item-settings"><a href="' . esc_url( $profile_page . wp_get_current_user()->user_login ) . '/' . $view_endpoint_settings . '/basic-information' . '">' . esc_html__( 'Edit Profile', 'course-builder' ) . '</a></li>';
											}
										} else {
											$menu_items_output .= '<li class="menu-item menu-item-settings"><a href="' . esc_url( $profile_page . wp_get_current_user()->user_login ) . '/settings' . '">' . esc_html__( 'Edit Profile', 'course-builder' ) . '</a></li>';
										}
									}
									break;
								default:
									break;
							}
						}
					}

					$menu_items_output = apply_filters( 'thim_menu_profile_items_extend', $menu_items_output );

					$html .= $menu_items_output;
					$html .= '<li class="menu-item menu-item-log-out">' . '<a href="' . wp_logout_url( home_url() ) . '">' . esc_html( $instance['text_logout'] ) . '</a></li>';
					$html .= '</ul>';
				}
			} else {
				//                $popup = get_theme_mod( 'login_popup', true );
				$has_auto_login = get_theme_mod( 'auto_login', false );

				$current_page_id = get_queried_object_id();

				$login_redirect_option = get_theme_mod( 'thim_login_redirect' );

				// Set link via priority
				if ( ! empty( $_REQUEST['redirect_to'] ) ) {
					$login_redirect_url = $_REQUEST['redirect_to'];
				} else {
					if ( ! empty( $login_redirect_option ) ) {
						$login_redirect_url = $login_redirect_option;
					} else {
						$login_redirect_url = get_permalink( $current_page_id );
					}
					if ( is_singular( 'lp_course' ) ) {
						if ( get_theme_mod( 'auto_login' ) == false ) {
							if ( thim_is_new_learnpress( '4.0.0-beta-0' ) ) {
								$login_redirect_url = get_permalink( $current_page_id );
							} else {
								$login_redirect_url = add_query_arg( array( 'enroll-course' => $current_page_id ), $login_redirect_url );
							}
						}
					}
				}


				$register_redirect_option = get_theme_mod( 'thim_register_redirect' );

				// Set link via priority
				if ( ! empty( $_REQUEST['redirect_to'] ) ) {
					$register_redirect_url = $_REQUEST['redirect_to'];
				} else {
					if ( ! empty( $register_redirect_option ) ) {
						$register_redirect_url = $register_redirect_option;
					} else {
						$register_redirect_url = get_permalink( $current_page_id );
					}
					if ( is_singular( 'lp_course' ) ) {
						if ( get_theme_mod( 'auto_login' ) == false ) {
							if ( thim_is_new_learnpress( '4.0.0-beta-0' ) ) {
								$register_redirect_url = get_permalink( $current_page_id );
							} else {
								$register_redirect_url = add_query_arg( array( 'enroll-course' => $current_page_id ), $register_redirect_url );
							}
						}
					}
				}

				$login_url    = $login_redirect_url;
				$register_url = $register_redirect_url;

				$popup      = isset( $instance['popup'] ) ? $instance['popup'] : true;
				$phone      = isset( $instance['phone'] ) ? $instance['phone'] : false;
				$first_name = isset( $instance['first_name'] ) ? $instance['first_name'] : false;
				$last_name  = isset( $instance['last_name'] ) ? $instance['last_name'] : false;
				$captcha    = isset( $instance['captcha'] ) ? $instance['captcha'] : false;

				if ( $popup == false ) {
					$login_url    = thim_get_login_page_url();
					$register_url = thim_get_register_url();
				}

				if ( ! $login_url && $instance['link'] ) {
					$login_url = $instance['link'];
				}


				$register_html = get_option( 'users_can_register' ) ? '<a class="register" href="' . esc_url( $register_url ) . '">' . esc_html( $instance['text_register'] ) . '</a><span class="slash">' . esc_html__( '/', 'course-builder' ) . '</span>' : '';

				if ( $popup || ( is_singular( 'lp_course' ) && $popup == false && get_theme_mod( 'lp_login_popup' ) == true ) || ( is_singular( 'tp_event' ) && $popup == false && get_theme_mod( 'event_login_popup' ) == true ) ) {
					$html .= '<div class="thim-link-login thim-login-popup">' . $register_html . '<a href="' . esc_url( $login_url ) . '" class="login">' . esc_html( $instance['text_login'] ) . '</a></div>';

					ob_start();
					?>
					<div id="thim-popup-login">
						<div class="thim-login-container">
							<div class="login-html">
								<?php $bg_img_src = get_theme_mod( 'bg_img_login_popup' ) ? get_theme_mod( 'bg_img_login_popup' ) : '' ?>
								<div class="login-banner" <?php if ( $bg_img_src ) {
									echo ' style="background-image: url(' . $bg_img_src . ')"';
								}; ?>>
									<div class="login-banner-wrap">
										<?php
										$text_default      = sprintf( '<h2>Hello!</h2><h3>We are happy to see you again!</h3>' );
										$widget_login_text = get_theme_mod( 'text_widget_login', $text_default );
										echo wp_kses(
											$widget_login_text, array(
											'a'      => array( 'href' => array() ),
											'br'     => array(),
											'h2'     => array(),
											'h3'     => array(),
											'strong' => array(),
											'li'     => array(),
											'ol'     => array(),
											'i'      => array(),
											'sub'    => array(),
											'sup'    => array()
										)
										);
										?>
										<!--										<h3 class="title">-->
										<?php //esc_html_e( 'Hello!', 'course-builder' ); ?><!--</h3>-->
										<!--										<h4 class="sub-title">-->
										<?php //esc_html_e( 'We are happy to see you again!', 'course-builder' ); ?><!--</h4>-->
									</div>
								</div>

								<?php if ( get_option( 'users_can_register' ) ): ?>
									<?php
									//                                    if ( get_theme_mod( 'login_popup', true ) ) {
									//                                        $link_register = '#';
									//                                    } else {
									//                                        $link_register =  esc_url( thim_get_register_url() );
									//                                    }
									$link_register = esc_url( thim_get_register_url() );
									?>
									<div class="link-to-form">
										<p class="content-register wrapper">
											<?php printf( __( 'Not a member yet? <a href="%s" class="register-link">Register Now</a>', 'course-builder' ), '#' ); ?>
										</p>

										<p class="content-login wrapper">
											<?php printf( __( 'Already a member? <a href="%s" class="login-link">Login Now</a>', 'course-builder' ), '#' ); ?>
										</p>
									</div>
								<?php endif; ?>

								<div class="login-form">
									<!-- Sign in form -->
									<div class="sign-in-htm">
										<h3 class="title"><?php esc_html_e( 'Login to your account', 'course-builder' ); ?></h3>

										<form name="loginform" id="popupLoginForm"
											  action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>"
											  method="post">
											<p class="login-username">
												<input type="text" name="user_login" id="popupLoginUser"
													   class="input required"
													   value="" size="20"
													   placeholder="<?php esc_attr_e( 'Username or Email...', 'course-builder' ); ?>">
											</p>
											<p class="login-password">
												<input type="password" name="user_password" id="popupLoginPassword"
													   class="input required" value="" size="20"
													   placeholder="<?php esc_attr_e( 'Password...', 'course-builder' ) ?>">
												<span id="show_pass"><i class="fa fa-eye"></i></span>
											</p>

											<?php
											/**
											 * Fires following the 'Password' field in the login form.
											 *
											 * @since 2.1.0
											 */
											do_action( 'login_form' );

											?>
											<?php if ( $captcha ) : ?>
												<p class="thim-login-captcha">
													<?php
													$value_1 = rand( 1, 9 );
													$value_2 = rand( 1, 9 );
													?>
													<input type="text"
														   data-captcha1="<?php echo esc_attr( $value_1 ); ?>"
														   data-captcha2="<?php echo esc_attr( $value_2 ); ?>"
														   placeholder="<?php echo esc_attr( $value_1 . ' &#43; ' . $value_2 . ' &#61;' ); ?>"
														   class="captcha-result required"/>
												</p>
											<?php endif; ?>

											<div class="login-extra-options">
												<p class="login-remember">
													<input name="rememberme" type="checkbox" id="popupRememberme"
														   checked/>
													<label for="popupRememberme"><span
															class="icon-check"></span><?php esc_html_e( 'Remember Me', 'course-builder' ); ?>
													</label>
												</p>
												<?php echo '<a class="lost-pass-link" href="' . thim_get_lost_password_url() . '" title="' . esc_attr__( 'Lost Password', 'course-builder' ) . '">' . esc_html__( 'Lost your password?', 'course-builder' ) . '</a>'; ?>
											</div>
											<p class="login-submit">
												<input type="submit" name="wp-submit" id="popupLoginSubmit"
													   class="button button-primary button-large"
													   value="<?php esc_attr_e( 'Login', 'course-builder' ); ?>">
												<input type="hidden" name="redirect_to"
													   value="<?php echo esc_attr( $login_redirect_url ); ?>">
											</p>

											<div class="popup-message"></div>
										</form>
									</div>

									<!-- End Sign in form -->

									<!-- Login or Register social-->
									<?php if ( ! empty( $instance['shortcode'] ) ): ?>
										<div class="shortcode">
											<?php echo do_shortcode( $instance['shortcode'] ); ?>
										</div>
									<?php endif; ?>
									<!-- End Login or Register social -->
								</div>

								<div class="register-form">
									<!-- Sign up form -->
									<div class="sign-in-htm">
										<h3 class="title"><?php esc_html_e( 'Register to start learning', 'course-builder' ); ?></h3>

										<form name="loginform"
											  class="<?php if ( get_theme_mod( 'auto_login' ) == false ) {
												  echo 'auto_login';
											  } else {
												  echo 'not_auto_login';
											  } ?>" id="popupRegisterForm"
											  action="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ); ?>"
											  method="post">
											<?php wp_nonce_field( 'ajax_register_nonce', 'register_security' ); ?>
											<p>
												<input id="popupRegisterName"
													   placeholder="<?php esc_attr_e( 'Username', 'course-builder' ); ?>"
													   type="text" name="user_login" class="input required"/>
											</p>

											<?php if ( $first_name == true ) { ?>
												<p>
													<input id="popupRegisterFirstName"
														   placeholder="<?php esc_attr_e( 'First Name', 'course-builder' ); ?>"
														   type="text" name="first_name" class="input required"/>
												</p>
											<?php } ?>

											<?php if ( $last_name == true ) { ?>
												<p>
													<input id="popupRegisterLastName"
														   placeholder="<?php esc_attr_e( 'Last Name', 'course-builder' ); ?>"
														   type="text" name="last_name" class="input required"/>
												</p>
											<?php } ?>

											<p>
												<input id="popupRegisterEmail"
													   placeholder="<?php esc_attr_e( 'Email Address', 'course-builder' ); ?>"
													   type="email" name="user_email" class="input required"/>
											</p>
											<?php if ( $phone == true ) { ?>
												<p>
													<input id="lp_info_phone"
														   placeholder="<?php esc_attr_e( 'Phone', 'course-builder' ); ?>"
														   type="tel" name="lp_info_phone" class="input required"/>
												</p>
											<?php } ?>

											<?php if ( $has_auto_login == false ) { ?>

												<p>
													<input id="popupRegisterPassword"
														   placeholder="<?php esc_attr_e( 'Password', 'course-builder' ); ?>"
														   type="password" name="password" class="input required"/>
												</p>

												<p>
													<input id="popupRegisterCPassword"
														   placeholder="<?php esc_attr_e( 'Confirm Password', 'course-builder' ); ?>"
														   type="password" name="repeat_password"
														   class="input required"/>
												</p>

											<?php } ?>

											<?php if ( $captcha ) : ?>
												<p class="thim-login-captcha">
													<?php
													$value_1 = rand( 1, 9 );
													$value_2 = rand( 1, 9 );
													?>
													<input type="text"
														   data-captcha1="<?php echo esc_attr( $value_1 ); ?>"
														   data-captcha2="<?php echo esc_attr( $value_2 ); ?>"
														   placeholder="<?php echo esc_attr( $value_1 . ' &#43; ' . $value_2 . ' &#61;' ); ?>"
														   class="captcha-result required"/>
												</p>
											<?php endif; ?>

											<?php
											// add fields to register form
											do_action( 'wordpress-lms/register-fields' ); ?>

											<?php do_action( 'register_form' ); ?>

											<?php if ( ! empty( $instance['term'] ) ): ?>
												<p>
													<input type="checkbox" class="term-field required" name="term"
														   id="termFormField">
													<label
														for="termFormField"><?php printf( __( 'I accept the <a href="%s" target="%s" rel="%s">Terms of Service</a>', 'course-builder' ), esc_url( $instance['term'] ), '', '' ); ?></label>
												</p>
											<?php endif; ?>


											<p class="login-submit">
												<input type="submit" name="wp-submit" id="popupRegisterSubmit"
													   class="button button-primary button-large"
													   value="<?php esc_attr_e( 'Sign Up', 'course-builder' ); ?>">
												<input type="hidden" name="redirect_to"
													   value="<?php echo esc_attr( $register_redirect_url ); ?>">

											</p>

											<div class="popup-message"></div>
										</form>
									</div>
									<!-- End Sign up form -->

									<!-- Login or Register social-->
									<?php if ( ! empty( $instance['shortcode'] ) ): ?>
										<div class="shortcode">
											<?php echo do_shortcode( $instance['shortcode'] ); ?>
										</div>
									<?php endif; ?>
									<!-- End Login or Register social -->
								</div>

								<span class="close-popup"><i class="fa fa-times" aria-hidden="true"></i></span>

							</div>
							<?php thim_loading_icon(); ?>
						</div>
					</div>
					<?php
					$output = ob_get_contents();
					ob_end_clean();

					$html .= $output;
				} else {

					$html .= '<div class="thim-link-login">' . $register_html . '<a href="' . esc_url( $login_url ) . '" class="login">' . esc_html( $instance['text_login'] ) . '</a></div>';
				}
			}

			echo ent2ncr( $html );

			echo ent2ncr( $args['after_widget'] );
		}

		public function form( $instance ) {
			$default_instance = array(
				'text_register' => esc_attr__( 'Register', 'course-builder' ),
				'text_login'    => esc_attr__( 'Login', 'course-builder' ),
				'text_logout'   => esc_attr__( 'Logout', 'course-builder' ),
				'link'          => get_permalink( get_page_by_path( 'account' ) ),
				'shortcode'     => '[wordpress_social_login]',
				'term'          => '',
				'popup'         => true,
				'captcha'       => false,
				'phone'         => false,
				'first_name'    => false,
				'last_name'     => false,
			);

			$instance = wp_parse_args( (array) $instance, $default_instance );

			$text_register = strip_tags( $instance['text_register'] );
			$text_login    = strip_tags( $instance['text_login'] );
			$text_logout   = strip_tags( $instance['text_logout'] );
			$term          = strip_tags( $instance['term'] );
			$phone         = (bool) $instance['phone'];
			$first_name    = (bool) $instance['first_name'];
			$last_name     = (bool) $instance['last_name'];
			$captcha       = (bool) $instance['captcha'];
			$popup         = (bool) $instance['popup'];
			?>
			<p>
				<label
					for="<?php echo esc_attr( $this->get_field_id( 'text_register' ) ); ?>"><?php esc_attr_e( '* Register Text:', 'course-builder' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text_register' ) ); ?>"
					   name="<?php echo esc_attr( $this->get_field_name( 'text_register' ) ); ?>" type="text"
					   value="<?php echo esc_attr( $text_register ); ?>">
			</p>

			<p>
				<label
					for="<?php echo esc_attr( $this->get_field_id( 'text_login' ) ); ?>"><?php esc_attr_e( '* Login Text:', 'course-builder' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text_login' ) ); ?>"
					   name="<?php echo esc_attr( $this->get_field_name( 'text_login' ) ); ?>" type="text"
					   value="<?php echo esc_attr( $text_login ); ?>">
			</p>

			<p>
				<label
					for="<?php echo esc_attr( $this->get_field_id( 'text_logout' ) ); ?>"><?php esc_attr_e( '* Logout Text:', 'course-builder' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text_logout' ) ); ?>"
					   name="<?php echo esc_attr( $this->get_field_name( 'text_logout' ) ); ?>" type="text"
					   value="<?php echo esc_attr( $text_logout ); ?>">
			</p>

			<p>
				<label
					for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_attr_e( 'Account Page URL:', 'course-builder' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"
					   name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="url"
					   value="<?php echo esc_url( $instance['link'] ); ?>">
			</p>

			<p>
				<label
					for="<?php echo esc_attr( $this->get_field_id( 'shortcode' ) ); ?>"><?php esc_attr_e( 'Social Login Shortcode:', 'course-builder' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'shortcode' ) ); ?>"
					   name="<?php echo esc_attr( $this->get_field_name( 'shortcode' ) ); ?>" type="text"
					   value="<?php echo( $instance['shortcode'] ); ?>">
			</p>

			<p>
				<label
					for="<?php echo esc_attr( $this->get_field_id( 'term' ) ); ?>"><?php esc_attr_e( 'Term Link:', 'course-builder' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'term' ) ); ?>"
					   name="<?php echo esc_attr( $this->get_field_name( 'term' ) ); ?>" type="text"
					   value="<?php echo( $instance['term'] ); ?>">
			</p>

			<p>
				<input class="checkbox" type="checkbox"<?php checked( $captcha ); ?>
					   id="<?php echo esc_attr( $this->get_field_id( 'captcha' ) ); ?>"
					   name="<?php echo esc_attr( $this->get_field_name( 'captcha' ) ); ?>"/>
				<label
					for="<?php echo esc_attr( $this->get_field_id( 'captcha' ) ); ?>"><?php esc_html_e( 'Enable Captcha', 'course-builder' ); ?></label>
			</p>

			<p>
				<input class="checkbox" type="checkbox"<?php checked( $popup ); ?>
					   id="<?php echo esc_attr( $this->get_field_id( 'popup' ) ); ?>"
					   name="<?php echo esc_attr( $this->get_field_name( 'popup' ) ); ?>"/>
				<label
					for="<?php echo esc_attr( $this->get_field_id( 'popup' ) ); ?>"><?php esc_html_e( 'Enable Login Popup', 'course-builder' ); ?></label>
			</p>

			<p>
				<input class="checkbox" type="checkbox"<?php checked( $phone ); ?>
					   id="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>"
					   name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ); ?>"/>
				<label
					for="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>"><?php esc_html_e( 'Enable Phone', 'course-builder' ); ?></label>
			</p>

			<p>
				<input class="checkbox" type="checkbox"<?php checked( $first_name ); ?>
					   id="<?php echo esc_attr( $this->get_field_id( 'first_name' ) ); ?>"
					   name="<?php echo esc_attr( $this->get_field_name( 'first_name' ) ); ?>"/>
				<label
					for="<?php echo esc_attr( $this->get_field_id( 'first_name' ) ); ?>"><?php esc_html_e( 'Enable First Name', 'course-builder' ); ?></label>
			</p>

			<p>
				<input class="checkbox" type="checkbox"<?php checked( $last_name ); ?>
					   id="<?php echo esc_attr( $this->get_field_id( 'last_name' ) ); ?>"
					   name="<?php echo esc_attr( $this->get_field_name( 'last_name' ) ); ?>"/>
				<label
					for="<?php echo esc_attr( $this->get_field_id( 'last_name' ) ); ?>"><?php esc_html_e( 'Enable Last Name', 'course-builder' ); ?></label>
			</p>
			<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['text_register'] = ( ! empty( $new_instance['text_register'] ) ) ? strip_tags( $new_instance['text_register'] ) : $old_instance['text_register'];
			$instance['text_login']    = ( ! empty( $new_instance['text_login'] ) ) ? strip_tags( $new_instance['text_login'] ) : $old_instance['text_login'];
			$instance['text_logout']   = ( ! empty( $new_instance['text_logout'] ) ) ? strip_tags( $new_instance['text_logout'] ) : $old_instance['text_logout'];
			$instance['link']          = ( ! empty( $new_instance['link'] ) ) ? $new_instance['link'] : '';
			$instance['shortcode']     = ( ! empty( $new_instance['shortcode'] ) ) ? $new_instance['shortcode'] : '';
			$instance['term']          = ( ! empty( $new_instance['term'] ) ) ? $new_instance['term'] : '';
			$instance['captcha']       = isset( $new_instance['captcha'] ) ? (bool) $new_instance['captcha'] : false;
			$instance['popup']         = isset( $new_instance['popup'] ) ? (bool) $new_instance['popup'] : false;
			$instance['phone']         = isset( $new_instance['phone'] ) ? (bool) $new_instance['phone'] : false;
			$instance['first_name']    = isset( $new_instance['first_name'] ) ? (bool) $new_instance['first_name'] : false;
			$instance['last_name']     = isset( $new_instance['last_name'] ) ? (bool) $new_instance['last_name'] : false;

			if ( ! empty( $new_instance['nav_menu'] ) ) {
				$instance['nav_menu'] = (int) $new_instance['nav_menu'];
			}

			return $instance;
		}

	}
}

function thim_register_login_widget() {
	register_widget( 'Thim_Login_Widget' );
}

add_action( 'widgets_init', 'thim_register_login_widget' );
