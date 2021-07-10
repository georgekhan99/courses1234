<?php
#todo check with empty string
$default_instance = array(
	'text_register' => esc_attr__( 'Register', 'course-builder' ),
	'text_login'    => esc_attr__( 'Login', 'course-builder' ),
	'text_logout'   => esc_attr__( 'Logout', 'course-builder' ),
	'shortcode'     => '[wordpress_social_login]',
	'captcha'       => false,
	'term'          => '',
    'popup'         => true,
);

$instance = array(
	'text_register' => $params['text_register'],
	'text_login'    => $params['text_login'],
	'text_logout'   => $params['text_logout'],
	'shortcode'     => $params['content'],
	'captcha'       => (bool) $params['captcha'],
	'phone'         => (bool) $params['phone'],
	'term'          => $params['term'],
    'popup'         => (bool) $params['popup'],
);

$instance = wp_parse_args( (array) $instance, $default_instance);
?>

<div class="thim-sc-login <?php echo esc_attr($params['el_class'])?>">
	<?php
	do_action( 'thim_login_widget_before' );

	the_widget( 'Thim_Login_Widget', $instance );

	do_action( 'thim_login_widget_after' );
	?>
</div>

