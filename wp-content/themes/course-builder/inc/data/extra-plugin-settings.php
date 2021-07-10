<?php

/**
 * Import settings
 */
function thim_import_extra_plugin_settings( $settings ) {
	$settings[] = 'learn_press_generate_course_thumbnail';
	$settings[] = 'learn_press_single_course_image_size';
	$settings[] = 'learn_press_course_thumbnail_image_size';
	$settings[] = 'learn_press_course_thumbnail_dimensions';
	$settings[] = 'wpb_js_templates';

	// Social Login
	$settings[] = 'wsl_settings_Facebook_enabled';
	$settings[] = 'wsl_settings_Facebook_app_id';
	$settings[] = 'wsl_settings_Facebook_app_secret';

	$settings[] = 'wsl_settings_Google_enabled';
	$settings[] = 'wsl_settings_Google_app_id';
	$settings[] = 'wsl_settings_Google_app_secret';

	$settings[] = 'wsl_settings_social_icon_set';
	$settings[] = 'wsl_settings_widget_display';

	return $settings;
}

add_filter( 'thim_importer_basic_settings', 'thim_import_extra_plugin_settings' );