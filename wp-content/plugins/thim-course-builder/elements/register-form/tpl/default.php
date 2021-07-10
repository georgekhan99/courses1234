<?php

global $wp_query;
$theme_options_data = get_theme_mods();
$profile_page_id    = LP()->settings->get( 'profile_page_id', false );
$current_page_id    = $wp_query->get_queried_object_id();

if ( $current_page_id != $profile_page_id ) {
	update_option( 'thim_login_page', get_the_ID() );
}

if ( is_user_logged_in() ) {
	?>
	<div class="thim-login">
		<?php
		echo '<p class="message message-success">' . sprintf( wp_kses( __( 'You have logged in. <a href="%s">Sign Out</a>', 'course-builder' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( wp_logout_url( apply_filters( 'thim_default_logout_redirect', 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ) ) ) ) . '</p>';
		?>
	</div>
	<?php
	return;
}
?>
<?php if ( get_option( 'users_can_register' ) ) : ?>
	<?php if ( !empty( $_GET['empty_username'] ) ) : ?>
		<?php echo '<p class="message message-error">' . esc_html__( 'Please enter a username!', 'course-builder' ) . '</p>'; ?>
	<?php endif; ?>
	<?php if ( !empty( $_GET['empty_email'] ) ) : ?>
		<?php echo '<p class="message message-error">' . esc_html__( 'Please type your e-mail address!', 'course-builder' ) . '</p>'; ?>
	<?php endif; ?>
	<?php if ( !empty( $_GET['username_exists'] ) ) : ?>
		<?php echo '<p class="message message-error">' . esc_html__( 'This username is already registered. Please choose another one!', 'course-builder' ) . '</p>'; ?>
	<?php endif; ?>
	<?php if ( !empty( $_GET['email_exists'] ) ) : ?>
		<?php echo '<p class="message message-error">' . esc_html__( 'This email is already registered. Please choose another one!', 'course-builder' ) . '</p>'; ?>
	<?php endif; ?>
	<?php if ( !empty( $_GET['invalid_email'] ) ) : ?>
		<?php echo '<p class="message message-error">' . esc_html__( 'The email address isn\'t correct. Please try again!', 'course-builder' ) . '</p>'; ?>
	<?php endif; ?>
	<?php if ( !empty( $_GET['invalid_username'] ) ) : ?>
		<?php echo '<p class="message message-error">' . esc_html__( 'The username is invalid. Please try again!', 'course-builder' ) . '</p>'; ?>
	<?php endif; ?>
	<div class="thim-login new_register_form">

		<form name="registerform" id="registerform"
			  action="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ); ?>"
			  method="post" novalidate="novalidate" class="auto_login">
			<p class="user_name">
				<input placeholder="<?php esc_attr_e( 'Your Name', 'course-builder' ); ?>" type="text"
					   name="user_login" id="user_login" class="input required"/>
			</p>

			<p class="email">
				<input placeholder="<?php esc_attr_e( 'Your Email', 'course-builder' ); ?>" type="email"
					   name="user_email" id="user_email" class="input required"/>
			</p>
			<p class="password">
				<input placeholder="<?php esc_attr_e( 'Password', 'course-builder' ); ?>" type="password"
					   name="password" id="password" class="input required"/>
			</p>
			<p class="re-password">
				<input placeholder="<?php esc_attr_e( 'Confirm Password', 'course-builder' ); ?>"
					   type="password" name="repeat_password" id="repeat_password" class="input required"/>
			</p>

			<?php
			do_action( 'wordpress-lms/register-fields' ); ?>

			<?php do_action( 'register_form' ); ?>

			<p>
				<?php
				$register_redirect = get_theme_mod( 'thim_register_redirect', false );
				if ( empty( $register_redirect ) ) {
					$register_redirect = add_query_arg( 'result', 'registered', thim_get_login_page_url() );
				}
				?>
				<input type="hidden" name="redirect_to"
					   value="<?php echo !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : $register_redirect; ?>"/>
			</p>

			<?php do_action( 'signup_hidden_fields', 'create-another-site' ); ?>
			<p class="submit">
				<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large"
					   value="<?php esc_attr_e( 'Submit', 'course-builder' ); ?>"/>
			</p>
		</form>
	</div>

	<?php return; ?>
<?php endif; ?>
