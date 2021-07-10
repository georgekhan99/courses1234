<?php

global $wp_query;
$theme_options_data = get_theme_mods();
if ( class_exists( 'LearnPress' ) ) {
	$profile_page_id = LP()->settings->get( 'profile_page_id', false );
	$current_page_id = $wp_query->get_queried_object_id();
	if ( $current_page_id != $profile_page_id ) {
		update_option( 'thim_login_page', get_the_ID() );
	}
}

if ( is_user_logged_in() ) {
	?>
	<div class="thim-login">
		<h4 class="subtitle"><?php esc_html_e( 'Logged', 'course-builder' ); ?></h4>
		<?php
		echo '<p class="message message-success">' . sprintf( wp_kses( __( 'You have logged in. <a href="%s">Sign Out</a>', 'course-builder' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( wp_logout_url( apply_filters( 'thim_default_logout_redirect', 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ) ) ) ) . '</p>';
		?>
	</div>
	<?php
	return;
}
?>
<?php if ( isset( $_GET['result'] ) || isset( $_GET['action'] ) ) : ?>
	<?php if ( isset( $_GET['result'] ) && $_GET['result'] == 'failed' ): ?>
		<?php echo '<p class="message message-error">' . esc_html__( 'Invalid username or password. Please try again!', 'course-builder' ) . '</p>'; ?>
	<?php endif; ?>

	<?php if ( ! empty( $_GET['action'] ) && $_GET['action'] == 'register' ) : ?>
		<?php if ( get_option( 'users_can_register' ) ) : ?>
			<?php if ( ! empty( $_GET['empty_username'] ) ) : ?>
				<?php echo '<p class="message message-error">' . esc_html__( 'Please enter a username!', 'course-builder' ) . '</p>'; ?>
			<?php endif; ?>
			<?php if ( ! empty( $_GET['empty_email'] ) ) : ?>
				<?php echo '<p class="message message-error">' . esc_html__( 'Please type your e-mail address!', 'course-builder' ) . '</p>'; ?>
			<?php endif; ?>
			<?php if ( ! empty( $_GET['username_exists'] ) ) : ?>
				<?php echo '<p class="message message-error">' . esc_html__( 'This username is already registered. Please choose another one!', 'course-builder' ) . '</p>'; ?>
			<?php endif; ?>
			<?php if ( ! empty( $_GET['email_exists'] ) ) : ?>
				<?php echo '<p class="message message-error">' . esc_html__( 'This email is already registered. Please choose another one!', 'course-builder' ) . '</p>'; ?>
			<?php endif; ?>
			<?php if ( ! empty( $_GET['invalid_email'] ) ) : ?>
				<?php echo '<p class="message message-error">' . esc_html__( 'The email address isn\'t correct. Please try again!', 'course-builder' ) . '</p>'; ?>
			<?php endif; ?>
			<?php if ( ! empty( $_GET['invalid_username'] ) ) : ?>
				<?php echo '<p class="message message-error">' . esc_html__( 'The username is invalid. Please try again!', 'course-builder' ) . '</p>'; ?>
			<?php endif; ?>
			<?php if ( ! empty( $_GET['passwords_not_matched'] ) ) : ?>
				<?php echo '<p class="message message-error">' . esc_html__( 'Passwords must matched!', 'course-builder' ) . '</p>'; ?>
			<?php endif; ?>
			<div class="thim-login">
				<h4 class="subtitle"><?php esc_html_e( 'Register', 'course-builder' ); ?></h4>
				<h2 class="title"><?php esc_html_e( 'Register to start learning', 'course-builder' ); ?></h2>

				<form name="registerform" id="registerform"
					  action="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ); ?>"
					  method="post" novalidate="novalidate">
					<p>
						<input placeholder="<?php esc_attr_e( 'Username', 'course-builder' ); ?>" type="text"
							   name="user_login" id="user_login" class="input required"/>
					</p>

					<?php if ( isset($params['first_name']) && $params['first_name']  == true ) : ?>
						<p>
							<input placeholder="<?php esc_attr_e( 'First Name', 'course-builder' ); ?>" type="text"
								   name="first_name" id="first_name" class="input required"/>
						</p>
					<?php endif; ?>

					<?php if ( isset($params['last_name']) && $params['last_name'] == true ) : ?>
						<p>
							<input placeholder="<?php esc_attr_e( 'Last Name', 'course-builder' ); ?>" type="text"
								   name="last_name" id="last_name" class="input required"/>
						</p>
					<?php endif; ?>

					<p>
						<input placeholder="<?php esc_attr_e( 'Email Address', 'course-builder' ); ?>" type="email"
							   name="user_email" id="user_email" class="input required"/>
					</p>

					<?php if ( $params['phone'] == true ) : ?>
						<p>
							<input placeholder="<?php esc_attr_e( 'Phone', 'course-builder' ); ?>" type="text"
								   name="lp_info_phone" id="lp_info_phone" class="input required"/>
						</p>
					<?php endif; ?>

					<?php if ( empty( $theme_options_data['auto_login'] ) || ( isset( $theme_options_data['auto_login'] ) && $theme_options_data['auto_login'] == '0' ) ) { ?>

						<p>
							<input placeholder="<?php esc_attr_e( 'Password', 'course-builder' ); ?>" type="password"
								   name="password" id="password" class="input required"/>
						</p>
						<p>
							<input placeholder="<?php esc_attr_e( 'Confirm Password', 'course-builder' ); ?>"
								   type="password" name="repeat_password" id="repeat_password" class="input required"/>
						</p>

					<?php } ?>


					<?php if ( ! empty( $params['captcha'] ) ) : ?>
						<p class="thim-login-captcha">
							<?php
							$value_1 = rand( 1, 9 );
							$value_2 = rand( 1, 9 );
							?>
							<input type="text" data-captcha1="<?php echo esc_attr( $value_1 ); ?>"
								   data-captcha2="<?php echo esc_attr( $value_2 ); ?>"
								   placeholder="<?php echo esc_attr( $value_1 . ' &#43; ' . $value_2 . ' &#61;' ); ?>"
								   class="captcha-result input required"/>
						</p>
					<?php endif; ?>

					<?php // add fields to register form
					do_action( 'wordpress-lms/register-fields' ); ?>

					<?php do_action( 'register_form' ); ?>

					<?php if ( ! empty( $params['term'] ) ): ?>
						<p>
							<input type="checkbox" class="term-field required" name="term" id="termFormField">
							<label
								for="termFormField"><?php printf( __( 'I accept the <a href="%s" target="%s" rel="%s">Terms of Service</a>', 'course-builder' ), esc_url( $params['term'] ), '', '' ); ?></label>
						</p>
					<?php endif; ?>

					<p>
						<?php
						$register_redirect = get_theme_mod( 'thim_register_redirect', false );
						if ( empty( $register_redirect ) ) {
							$register_redirect = add_query_arg( 'result', 'registered', thim_get_login_page_url() );
						}
						?>
						<input type="hidden" name="redirect_to"
							   value="<?php echo ! empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : $register_redirect; ?>"/>
					</p>

					<!--<p style="display: none">
						<input type="text" id="check_spam_register" value="" name="name" />
					</p>-->

					<?php do_action( 'signup_hidden_fields', 'create-another-site' ); ?>
					<p class="submit">
						<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large"
							   value="<?php esc_attr_e( 'Sign up', 'course-builder' ); ?>"/>
					</p>
				</form>
				<?php echo '<p class="link-bottom">' . esc_html__( 'Are you a member? ', 'course-builder' ) . '<a href="' . esc_url( thim_get_login_page_url() ) . '">' . esc_html__( 'Login now', 'course-builder' ) . '</a></p>'; ?>
			</div>

			<?php return; ?>
		<?php else : ?>
			<div class="thim-login">
				<h4 class="subtitle"><?php esc_html_e( 'Register', 'course-builder' ); ?></h4>
				<?php echo '<p class="message message-error">' . esc_html__( 'Your site does not allow users registration.', 'course-builder' ) . '</p>'; ?>
			</div>
			<?php return; ?>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( ! empty( $_GET['action'] ) && $_GET['action'] == 'lostpassword' ) : ?>

		<?php if ( ! empty( $_GET['empty'] ) ) : ?>
			<?php echo '<p class="message message-error">' . esc_html__( 'Please enter a username or email!', 'course-builder' ) . '</p>'; ?>
		<?php endif; ?>
		<?php if ( ! empty( $_GET['user_not_exist'] ) ) : ?>
			<?php echo '<p class="message message-error">' . esc_html__( 'The user does not exist. Please try again!', 'course-builder' ) . '</p>'; ?>
		<?php endif; ?>

		<div class="thim-login">
			<h4 class="subtitle"><?php esc_html_e( 'Lost password', 'course-builder' ); ?></h4>
			<h2 class="title"><?php esc_html_e( 'Lost your password?', 'course-builder' ); ?></h2>

			<form name="lostpasswordform" id="lostpasswordform"
				  action="<?php echo esc_url( network_site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ); ?>"
				  method="post">
				<p>
					<input placeholder="<?php esc_attr_e( 'Username or email', 'course-builder' ); ?>" type="text"
						   name="user_login" id="user_login" class="input required"/>
					<input type="hidden" name="redirect_to"
						   value="<?php echo esc_attr( add_query_arg( 'result', 'reset', thim_get_login_page_url() ) ); ?>"/>
					<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large"
						   value="<?php esc_attr_e( 'Reset password', 'course-builder' ); ?>"/>
				</p>
				<?php do_action( 'lostpassword_form' ); ?>
			</form>
			<p class="link-bottom"><?php esc_html_e( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'course-builder' ); ?></p>
		</div>
		<?php return; ?>
	<?php endif; ?>

	<?php if ( ! empty( $_GET['action'] ) && $_GET['action'] == 'rp' ) : ?>

		<?php if ( ! empty( $_GET['expired_key'] ) ) : ?>
			<?php echo '<p class="message message-error">' . esc_html__( 'The key is expired. Please try again!', 'course-builder' ) . '</p>'; ?>
		<?php endif; ?>
		<?php if ( ! empty( $_GET['invalid_key'] ) ) : ?>
			<?php echo '<p class="message message-error">' . esc_html__( 'The key is invalid. Please try again!', 'course-builder' ) . '</p>'; ?>
		<?php endif; ?>
		<?php if ( ! empty( $_GET['invalid_password'] ) ) : ?>
			<?php echo '<p class="message message-error">' . esc_html__( 'The password is invalid. Please try again!', 'course-builder' ) . '</p>'; ?>
		<?php endif; ?>

		<div class="thim-login">
			<h4 class="subtitle"><?php esc_html_e( 'Change Password', 'course-builder' ); ?></h4>
			<h2 class="title"><?php esc_html_e( 'Change password your account', 'course-builder' ); ?></h2>

			<?php
			$errors = new WP_Error();
			$user   = check_password_reset_key( $_GET['key'], $_GET['login'] );

			if ( is_wp_error( $user ) ) {
				if ( $user->get_error_code() === 'expired_key' ) {
					$errors->add( 'expiredkey', esc_html__( 'Sorry, that key has expired. Please try again.', 'course-builder' ) );
				} else {
					$errors->add( 'invalidkey', esc_html__( 'Sorry, that key does not appear to be valid.', 'course-builder' ) );
				}
			}
			?>

			<form name="resetpassform" id="resetpassform"
				  action="<?php echo site_url( 'wp-login.php?action=resetpass' ); ?>" method="post" autocomplete="off">
				<?php
				// this prevent automated script for unwanted spam
				if ( function_exists( 'wp_nonce_field' ) ) {
					wp_nonce_field( 'rs_user_reset_password_action', 'rs_user_reset_password_nonce' );
				}
				?>

				<input type="hidden" id="rp_user" name="rp_user"
					   value="<?php echo isset( $_GET['login'] ) ? esc_attr( $_GET['login'] ) : ''; ?>"/>
				<input type="hidden" id="user_key" name="user_key"
					   value="<?php echo isset( $_GET['key'] ) ? esc_attr( $_GET['key'] ) : ''; ?>"/>

				<p>
					<input placeholder="<?php esc_attr_e( 'New password *', 'course-builder' ); ?>" type="password"
						   name="pass1" id="pass1" class="input required"/>
				</p>

				<p>
					<input placeholder="<?php esc_attr_e( 'Confirm new password *', 'course-builder' ); ?>"
						   type="password" name="pass2" id="pass2" class="input required"/>
				</p>

				<?php
				/**
				 * Fires following the 'Strength indicator' meter in the user password reset form.
				 *
				 * @param WP_User $user User object of the user whose password is being reset.
				 *
				 * @since 3.9.0
				 *
				 */
				do_action( 'resetpass_form', $user );
				?>
				<div class="resetpass-submit">
					<input type="submit" name="submit" id="resetpass-button" class="button"
						   value="<?php esc_attr_e( 'Reset Password', 'course-builder' ); ?>"/>
					<div class="sk-three-bounce hidden">
						<div class="sk-child sk-bounce1"></div>
						<div class="sk-child sk-bounce2"></div>
						<div class="sk-child sk-bounce3"></div>
					</div>
				</div>

				<p class="message-notice"></p>

			</form>

			<p class="link-bottom"><?php echo wp_get_password_hint(); ?></p>
		</div>
		<?php return; ?>
	<?php endif; ?>

	<?php if ( ! empty( $_GET['result'] ) && $_GET['result'] == 'registered' ) : ?>
		<?php echo '<p class="message message-success">' . esc_html__( 'Registration is successful. Confirmation will be e-mailed to you.', 'course-builder' ) . '</p>'; ?>
		<?php return; ?>
	<?php endif; ?>

	<?php if ( ! empty( $_GET['result'] ) && $_GET['result'] == 'reset' ) : ?>
		<?php echo '<p class="message message-success">' . esc_html__( 'Check your email to get a link to create a new password.', 'course-builder' ) . '</p>'; ?>
		<?php return; ?>
	<?php endif; ?>

	<?php if ( ! empty( $_GET['result'] ) && $_GET['result'] == 'changed' ) : ?>
		<?php echo '<p class="message message-success">' . sprintf( wp_kses( __( 'Password changed. You can <a href="%s">login</a> now.', 'course-builder' ), array( 'a' => array( 'href' => array() ) ) ), thim_get_login_page_url() ) . '</p>'; ?>
		<?php return; ?>
	<?php endif; ?>

<?php endif; ?>

<div class="thim-login">
	<h4 class="subtitle"><?php esc_html_e( 'Login', 'course-builder' ); ?></h4>
	<h2 class="title"><?php esc_html_e( 'Login with your site account', 'course-builder' ); ?></h2>
	<?php
	$login_redirect = get_theme_mod( 'thim_login_redirect', false );
	if ( empty( $login_redirect ) ) {
		$login_redirect = apply_filters( 'thim_default_login_redirect', home_url() );
	}
	$redirect = ! empty( $_REQUEST['redirect_to'] ) ? esc_url( $_REQUEST['redirect_to'] ) : $login_redirect;

	$link_redirect = ! empty( $_REQUEST['redirect_to'] ) ? esc_url( $_REQUEST['redirect_to'] ) : '';
	$link_register = add_query_arg( 'redirect_to', urlencode( $link_redirect ), thim_get_register_url() );

	?>
	<form name="loginform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>"
		  method="post" novalidate="novalidate">
		<p class="login-username">
			<input required type="text" name="log"
				   placeholder="<?php esc_html_e( 'Username or email *', 'course-builder' ); ?>" id="user_login"
				   class="input required" value="" size="20"/>
		</p>
		<p class="login-password">
			<input required type="password" name="pwd"
				   placeholder="<?php esc_html_e( 'Password *', 'course-builder' ); ?>" id="user_pass"
				   class="input required" value="" size="20"/>
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
		<?php if ( ! empty( $params['captcha'] ) ) : ?>
			<p class="thim-login-captcha">
				<?php
				$value_1 = rand( 1, 9 );
				$value_2 = rand( 1, 9 );
				?>
				<input type="text" data-captcha1="<?php echo esc_attr( $value_1 ); ?>"
					   data-captcha2="<?php echo esc_attr( $value_2 ); ?>"
					   placeholder="<?php echo esc_attr( $value_1 . ' &#43; ' . $value_2 . ' &#61;' ); ?>"
					   class="captcha-result input required"/>
			</p>
		<?php endif; ?>


		<div class="wrap-fields">
			<p class="forgetmenot login-remember">
				<label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme"
											   value="forever"/> <?php esc_html_e( 'Remember Me', 'course-builder' ); ?>
				</label>
			</p>
			<?php echo '<a class="lost-pass-link" href="' . thim_get_lost_password_url() . '" title="' . esc_attr__( 'Lost Password', 'course-builder' ) . '">' . esc_html__( 'Lost your password?', 'course-builder' ) . '</a>'; ?>
		</div>

		<p class="submit login-submit">
			<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large"
				   value="<?php esc_attr_e( 'Login', 'course-builder' ); ?>"/>
			<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect ); ?>"/>
			<input type="hidden" name="testcookie" value="1"/>
		</p>

	</form>
	<?php
	$registration_enabled = get_option( 'users_can_register' );
	if ( $registration_enabled ) {
		echo '<p class="link-bottom">' . esc_html__( 'Not a member yet? ', 'course-builder' ) . ' <a href="' . esc_attr( $link_register ) . '">' . esc_html__( 'Register Now', 'course-builder' ) . '</a></p>';
	}
	?>
</div>
