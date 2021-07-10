<?php

//include_once( THIM_CB_PATH . 'inc/plugins/vc-templates-import-export.php' );

/**
 * @param $css_animation
 *
 * @return string
 */

function thim_getCSSAnimation( $css_animation ) {
	$output = '';
	if ( $css_animation != '' ) {
		wp_enqueue_script( 'waypoints' );
		$output = ' wpb_animate_when_almost_visible wpb_' . $css_animation;
	}

	return $output;
}

function thim_extend_js_composer() {
	$thim_row_bg_overlay_attributes = array(
		'type'       => 'colorpicker',
		'heading'    => "Overlay Color",
		'param_name' => 'overlay_color',
		'value'      => '',
		'group'      => 'Advance Options',
	);
	vc_add_param( 'vc_row', $thim_row_bg_overlay_attributes );


	$thim_add_params_attributes = array(
		array(
			'type'       => 'dropdown',
			'heading'    => "Advance",
			'param_name' => 'overlay_advance',
			'value'      => array( "No", "Yes" ),
			'group'      => 'Advance Options',
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => "Background Color",
			'param_name' => 'overlay_advance_bg',
			'group'      => 'Advance Options',
			'dependency' => array(
				'element' => 'overlay_advance',
				'value'   => array( 'Yes' ),
			),
		),
		array(
			'type'       => 'attach_image',
			'heading'    => "Image",
			'param_name' => 'overlay_advance_image',
			'group'      => 'Advance Options',
			'dependency' => array(
				'element' => 'overlay_advance',
				'value'   => array( 'Yes' ),
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => "Position",
			'param_name' => 'overlay_advance_position',
			'value'      => array(
				'Bottom - Right' => 'br',
				'Bottom - Left'  => 'bl',
				'Top - Right'    => 'tr',
				'Top - Left'     => 'tl',
				'Over-Top'       => 't',
			),
			'group'      => 'Advance Options',
			'dependency' => array(
				'element' => 'overlay_advance',
				'value'   => array( 'Yes' ),
			),
		),

		array(
			'type'       => 'dropdown',
			'heading'    => "Size",
			'param_name' => 'overlay_advance_size',
			'value'      => array(
				'Default' => 'size-default',
				'Small'   => 'size-small',
			),
			'group'      => 'Advance Options',
			'dependency' => array(
				'element' => 'overlay_advance',
				'value'   => array( 'Yes' ),
			),
		),
	);
	vc_add_params( 'vc_row', $thim_add_params_attributes );
}

add_action( 'vc_before_init', 'thim_extend_js_composer' );

/**
 * @param array $params
 * @param string $position
 */
function thim_display_widget_area( $params = array(), $position = '' ) {

	if ( $position === $params['widget_area'] && $params['widget_area'] != '' && $position != '' ) {
		if ( $params['widget_area_id'] ) {
			if ( is_active_sidebar( $params['widget_area_id'] ) ) {
				$html = '<div class="thim-sidebar-area">';

				ob_start();
				WPBMap::addAllMappedShortcodes();
				dynamic_sidebar( $params['widget_area_id'] );
				$html .= ob_get_contents();
				ob_end_clean();

				$html .= '</div>';
				echo ent2ncr( $html );
			}
		}
	}

}


/**
 * Get template.
 *
 * Search for the template and include the file.
 *
 * @param string $template_name Template to load.
 * @param array $args Args passed for the template file.
 * @param string $string $template_path    Path to templates.
 * @param string $default_path Default path to template files.
 *
 * @since 1.0.0
 *
 * @see   wcpt_locate_template()
 *
 */
if ( ! function_exists( 'thim_get_template' ) ) {
	function thim_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {
		if ( is_array( $args ) && isset( $args ) ) :
			extract( $args );
		endif;

		$template_name = $template_name . '.php';
		$posts         = isset( $args['posts'] ) ? $args['posts'] : array();
		$params        = isset( $args['params'] ) ? $args['params'] : array();

		$template_file = thim_locate_template( $template_name, $tempate_path, $default_path );

		if ( ! file_exists( $template_file ) ) :
			_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );

			return;
		endif;

		include $template_file;
	}
}

/**
 * Locate template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/woocommerce-plugin-templates/$template_name
 * 2. /themes/theme/$template_name
 * 3. /plugins/woocommerce-plugin-templates/templates/$template_name.
 *
 * @param string $template_name Template to load.
 * @param string $string $template_path    Path to templates.
 * @param string $default_path Default path to template files.
 *
 * @return    string                            Path to the template file.
 * @since 1.0.0
 *
 */
if ( ! function_exists( 'thim_locate_template' ) ) {
	function thim_locate_template( $template_name, $template_path = '', $default_path = '' ) {
		// Set variable to search in woocommerce-plugin-templates folder of theme.
		if ( ! $template_path ) :
			$template_path = 'templates/';
		endif;

		// Set default plugin templates path.
		if ( ! $default_path ) :
			$default_path = THIM_CB_PATH . 'elements/' . $template_path; // Path to the template folder
		endif;

		// Search template file in theme folder.
		$template = locate_template( array(
			'thim-course-builder/elements/' . $template_path . $template_name,
			$template_name
		) );

		// Get plugins template file.
		if ( ! $template ) :
			$template = $default_path . $template_name;
		endif;
		// get template file in child theme
		$child_template  = trailingslashit( get_stylesheet_directory() )  . 'thim-course-builder/'  . str_replace("tpl/","",$template_path) .  str_replace("lp3/","",$template_name);

		if (  file_exists( $child_template ) ):
			$template = $child_template;
		endif;

		return apply_filters( 'thim_locate_template', $template, $template_name, $template_path, $default_path );
	}
}

if ( ! function_exists( 'thim_modify_icon_param' ) ) {
	function thim_modify_icon_param() {
		if ( class_exists( 'Vc_Manager' ) ) {
			$settings_icon_type = array(
				__( 'font_ionicons', 'course-builder' ) => 'font_ionicons'
			);
			vc_map_update( 'icon_type-', $settings_icon_type ); // Note: 'vc_message' was used as a base for "Message box" element
		}
	}
}

add_action( 'plugins_loaded', 'thim_modify_icon_param' );

add_filter( 'vc_iconpicker-type-ionicons', 'thim_vc_iconpicker_type_ionicons' );

/**
 * Openicons icons from fontello.com
 *
 * @param $icons - taken from filter - vc_map param field settings['source']
 *               provided icons (default empty array). If array categorized it will
 *               auto-enable category dropdown
 *
 * @return array - of icons for iconpicker, can be categorized, or not.
 * @since 4.4
 */

add_action( 'vc_base_register_front_css', 'thim_vc_iconpicker_base_register_css' );
add_action( 'vc_base_register_admin_css', 'thim_vc_iconpicker_base_register_css' );
function thim_vc_iconpicker_base_register_css() {
	wp_register_style( 'font_ionicons', THIM_CB_URL . '/assets/fonts/ionicons.min.css' );
}

add_action( 'vc_backend_editor_enqueue_js_css', 'thim_vc_iconpicker_editor_jscss' );
add_action( 'vc_frontend_editor_enqueue_js_css', 'thim_vc_iconpicker_editor_jscss' );
function thim_vc_iconpicker_editor_jscss() {
	wp_enqueue_style( 'font_ionicons' );
}

add_action( 'vc_enqueue_font_icon_element', 'thim_enqueue_font_iconssolid' );
function thim_enqueue_font_iconssolid( $font ) {
	switch ( $font ) {
		case 'font_ionicons':
			wp_enqueue_style( 'font_ionicons' );
	}
}

function thim_vc_iconpicker_type_ionicons( $icons ) {
	$font_ionicons = array(
		array( 'ion-alert' => 'Alert' ),
		array( 'ion-alert-circled' => 'Alert Circled' ),
		array( 'ion-android-add' => 'Android Add' ),
		array( 'ion-android-add-circle' => 'Android Add Circle' ),
		array( 'ion-android-alarm-clock' => 'Android Alarm Clock' ),
		array( 'ion-android-alert' => 'Android Alert' ),
		array( 'ion-android-apps' => 'Android Apps' ),
		array( 'ion-android-archive' => 'Android Archive' ),
		array( 'ion-android-arrow-back' => 'Android Arrow Back' ),
		array( 'ion-android-arrow-down' => 'Android Arrow Down' ),
		array( 'ion-android-arrow-dropdown' => 'Android Arrow Dropdown' ),
		array( 'ion-android-arrow-dropdown-circle' => 'Android Arrow Dropdown Circle' ),
		array( 'ion-android-arrow-dropleft' => 'Android Arrow Dropleft' ),
		array( 'ion-android-arrow-dropleft-circle' => 'Android Arrow Dropleft Circle' ),
		array( 'ion-android-arrow-dropright' => 'Android Arrow Dropright' ),
		array( 'ion-android-arrow-dropright-circle' => 'Android Arrow Dropright Circle' ),
		array( 'ion-android-arrow-dropup' => 'Android Arrow Dropup' ),
		array( 'ion-android-arrow-dropup-circle' => 'Android Arrow Dropup Circle' ),
		array( 'ion-android-arrow-forward' => 'Android Arrow Forward' ),
		array( 'ion-android-arrow-up' => 'Android Arrow Up' ),
		array( 'ion-android-attach' => 'Android Attach' ),
		array( 'ion-android-bar' => 'Android Bar' ),
		array( 'ion-android-bicycle' => 'Android Bicycle' ),
		array( 'ion-android-boat' => 'Android Boat' ),
		array( 'ion-android-bookmark' => 'Android Bookmark' ),
		array( 'ion-android-bulb' => 'Android Bulb' ),
		array( 'ion-android-bus' => 'Android Bus' ),
		array( 'ion-android-calendar' => 'Android Calendar' ),
		array( 'ion-android-call' => 'Android Call' ),
		array( 'ion-android-camera' => 'Android Camera' ),
		array( 'ion-android-cancel' => 'Android Cancel' ),
		array( 'ion-android-car' => 'Android Car' ),
		array( 'ion-android-cart' => 'Android Cart' ),
		array( 'ion-android-chat' => 'Android Chat' ),
		array( 'ion-android-checkbox' => 'Android Checkbox' ),
		array( 'ion-android-checkbox-blank' => 'Android Checkbox Blank' ),
		array( 'ion-android-checkbox-outline' => 'Android Checkbox Outline' ),
		array( 'ion-android-checkbox-outline-blank' => 'Android Checkbox Outline Blank' ),
		array( 'ion-android-checkmark-circle' => 'Android Checkmark Circle' ),
		array( 'ion-android-clipboard' => 'Android Clipboard' ),
		array( 'ion-android-close' => 'Android Close' ),
		array( 'ion-android-cloud' => 'Android Cloud' ),
		array( 'ion-android-cloud-circle' => 'Android Cloud Circle' ),
		array( 'ion-android-cloud-done' => 'Android Cloud Done' ),
		array( 'ion-android-cloud-outline' => 'Android Cloud Outline' ),
		array( 'ion-android-color-palette' => 'Android Color Palette' ),
		array( 'ion-android-compass' => 'Android Compass' ),
		array( 'ion-android-contact' => 'Android Contact' ),
		array( 'ion-android-contacts' => 'Android Contacts' ),
		array( 'ion-android-contract' => 'Android Contract' ),
		array( 'ion-android-create' => 'Android Create' ),
		array( 'ion-android-delete' => 'Android Delete' ),
		array( 'ion-android-desktop' => 'Android Desktop' ),
		array( 'ion-android-document' => 'Android Document' ),
		array( 'ion-android-done' => 'Android Done' ),
		array( 'ion-android-done-all' => 'Android Done All' ),
		array( 'ion-android-download' => 'Android Download' ),
		array( 'ion-android-drafts' => 'Android Drafts' ),
		array( 'ion-android-exit' => 'Android Exit' ),
		array( 'ion-android-expand' => 'Android Expand' ),
		array( 'ion-android-favorite' => 'Android Favorite' ),
		array( 'ion-android-favorite-outline' => 'Android Favorite Outline' ),
		array( 'ion-android-film' => 'Android Film' ),
		array( 'ion-android-folder' => 'Android Folder' ),
		array( 'ion-android-folder-open' => 'Android Folder Open' ),
		array( 'ion-android-funnel' => 'Android Funnel' ),
		array( 'ion-android-globe' => 'Android Globe' ),
		array( 'ion-android-hand' => 'Android Hand' ),
		array( 'ion-android-hangout' => 'Android Hangout' ),
		array( 'ion-android-happy' => 'Android Happy' ),
		array( 'ion-android-home' => 'Android Home' ),
		array( 'ion-android-image' => 'Android Image' ),
		array( 'ion-android-laptop' => 'Android Laptop' ),
		array( 'ion-android-list' => 'Android List' ),
		array( 'ion-android-locate' => 'Android Locate' ),
		array( 'ion-android-lock' => 'Android Lock' ),
		array( 'ion-android-mail' => 'Android Mail' ),
		array( 'ion-android-map' => 'Android Map' ),
		array( 'ion-android-menu' => 'Android Menu' ),
		array( 'ion-android-microphone' => 'Android Microphone' ),
		array( 'ion-android-microphone-off' => 'Android Microphone Off' ),
		array( 'ion-android-more-horizontal' => 'Android More Horizontal' ),
		array( 'ion-android-more-vertical' => 'Android More Vertical' ),
		array( 'ion-android-navigate' => 'Android Navigate' ),
		array( 'ion-android-notifications' => 'Android Notifications' ),
		array( 'ion-android-notifications-none' => 'Android Notifications None' ),
		array( 'ion-android-notifications-off' => 'Android Notifications Off' ),
		array( 'ion-android-open' => 'Android Open' ),
		array( 'ion-android-options' => 'Android Options' ),
		array( 'ion-android-people' => 'Android People' ),
		array( 'ion-android-person' => 'Android Person' ),
		array( 'ion-android-person-add' => 'Android Person Add' ),
		array( 'ion-android-phone-landscape' => 'Android Phone Landscape' ),
		array( 'ion-android-phone-portrait' => 'Android Phone Portrait' ),
		array( 'ion-android-pin' => 'Android Pin' ),
		array( 'ion-android-plane' => 'Android Plane' ),
		array( 'ion-android-playstore' => 'Android Playstore' ),
		array( 'ion-android-print' => 'Android Print' ),
		array( 'ion-android-radio-button-off' => 'Android Radio Button Off' ),
		array( 'ion-android-radio-button-on' => 'Android Radio Button On' ),
		array( 'ion-android-refresh' => 'Android Refresh' ),
		array( 'ion-android-remove' => 'Android Remove' ),
		array( 'ion-android-remove-circle' => 'Android Remove Circle' ),
		array( 'ion-android-restaurant' => 'Android Restaurant' ),
		array( 'ion-android-sad' => 'Android Sad' ),
		array( 'ion-android-search' => 'Android Search' ),
		array( 'ion-android-send' => 'Android Send' ),
		array( 'ion-android-settings' => 'Android Settings' ),
		array( 'ion-android-share' => 'Android Share' ),
		array( 'ion-android-share-alt' => 'Android Share Alt' ),
		array( 'ion-android-star' => 'Android Star' ),
		array( 'ion-android-star-half' => 'Android Star Half' ),
		array( 'ion-android-star-outline' => 'Android Star Outline' ),
		array( 'ion-android-stopwatch' => 'Android Stopwatch' ),
		array( 'ion-android-subway' => 'Android Subway' ),
		array( 'ion-android-sunny' => 'Android Sunny' ),
		array( 'ion-android-sync' => 'Android Sync' ),
		array( 'ion-android-textsms' => 'Android Textsms' ),
		array( 'ion-android-time' => 'Android Time' ),
		array( 'ion-android-train' => 'Android Train' ),
		array( 'ion-android-unlock' => 'Android Unlock' ),
		array( 'ion-android-upload' => 'Android Upload' ),
		array( 'ion-android-volume-down' => 'Android Volume Down' ),
		array( 'ion-android-volume-mute' => 'Android Volume Mute' ),
		array( 'ion-android-volume-off' => 'Android Volume Off' ),
		array( 'ion-android-volume-up' => 'Android Volume Up' ),
		array( 'ion-android-walk' => 'Android Walk' ),
		array( 'ion-android-warning' => 'Android Warning' ),
		array( 'ion-android-watch' => 'Android Watch' ),
		array( 'ion-android-wifi' => 'Android Wifi' ),
		array( 'ion-aperture' => 'Aperture' ),
		array( 'ion-archive' => 'Archive' ),
		array( 'ion-arrow-down-a' => 'Arrow Down A' ),
		array( 'ion-arrow-down-b' => 'Arrow Down B' ),
		array( 'ion-arrow-down-c' => 'Arrow Down C' ),
		array( 'ion-arrow-expand' => 'Arrow Expand' ),
		array( 'ion-arrow-graph-down-left' => 'Arrow Graph Down Left' ),
		array( 'ion-arrow-graph-down-right' => 'Arrow Graph Down Right' ),
		array( 'ion-arrow-graph-up-left' => 'Arrow Graph Up Left' ),
		array( 'ion-arrow-graph-up-right' => 'Arrow Graph Up Right' ),
		array( 'ion-arrow-left-a' => 'Arrow Left A' ),
		array( 'ion-arrow-left-b' => 'Arrow Left B' ),
		array( 'ion-arrow-left-c' => 'Arrow Left C' ),
		array( 'ion-arrow-move' => 'Arrow Move' ),
		array( 'ion-arrow-resize' => 'Arrow Resize' ),
		array( 'ion-arrow-return-left' => 'Arrow Return Left' ),
		array( 'ion-arrow-return-right' => 'Arrow Return Right' ),
		array( 'ion-arrow-right-a' => 'Arrow Right A' ),
		array( 'ion-arrow-right-b' => 'Arrow Right B' ),
		array( 'ion-arrow-right-c' => 'Arrow Right C' ),
		array( 'ion-arrow-shrink' => 'Arrow Shrink' ),
		array( 'ion-arrow-swap' => 'Arrow Swap' ),
		array( 'ion-arrow-up-a' => 'Arrow Up A' ),
		array( 'ion-arrow-up-b' => 'Arrow Up B' ),
		array( 'ion-arrow-up-c' => 'Arrow Up C' ),
		array( 'ion-asterisk' => 'Asterisk' ),
		array( 'ion-at' => 'At' ),
		array( 'ion-backspace' => 'Backspace' ),
		array( 'ion-backspace-outline' => 'Backspace Outline' ),
		array( 'ion-bag' => 'Bag' ),
		array( 'ion-battery-charging' => 'Battery Charging' ),
		array( 'ion-battery-empty' => 'Battery Empty' ),
		array( 'ion-battery-full' => 'Battery Full' ),
		array( 'ion-battery-half' => 'Battery Half' ),
		array( 'ion-battery-low' => 'Battery Low' ),
		array( 'ion-beaker' => 'Beaker' ),
		array( 'ion-beer' => 'Beer' ),
		array( 'ion-bluetooth' => 'Bluetooth' ),
		array( 'ion-bonfire' => 'Bonfire' ),
		array( 'ion-bookmark' => 'Bookmark' ),
		array( 'ion-bowtie' => 'Bowtie' ),
		array( 'ion-briefcase' => 'Briefcase' ),
		array( 'ion-bug' => 'Bug' ),
		array( 'ion-calculator' => 'Calculator' ),
		array( 'ion-calendar' => 'Calendar' ),
		array( 'ion-camera' => 'Camera' ),
		array( 'ion-card' => 'Card' ),
		array( 'ion-cash' => 'Cash' ),
		array( 'ion-chatbox' => 'Chatbox' ),
		array( 'ion-chatbox-working' => 'Chatbox Working' ),
		array( 'ion-chatboxes' => 'Chatboxes' ),
		array( 'ion-chatbubble' => 'Chatbubble' ),
		array( 'ion-chatbubble-working' => 'Chatbubble Working' ),
		array( 'ion-chatbubbles' => 'Chatbubbles' ),
		array( 'ion-checkmark' => 'Checkmark' ),
		array( 'ion-checkmark-circled' => 'Checkmark Circled' ),
		array( 'ion-checkmark-round' => 'Checkmark Round' ),
		array( 'ion-chevron-down' => 'Chevron Down' ),
		array( 'ion-chevron-left' => 'Chevron Left' ),
		array( 'ion-chevron-right' => 'Chevron Right' ),
		array( 'ion-chevron-up' => 'Chevron Up' ),
		array( 'ion-clipboard' => 'Clipboard' ),
		array( 'ion-clock' => 'Clock' ),
		array( 'ion-close' => 'Close' ),
		array( 'ion-close-circled' => 'Close Circled' ),
		array( 'ion-close-round' => 'Close Round' ),
		array( 'ion-closed-captioning' => 'Closed Captioning' ),
		array( 'ion-cloud' => 'Cloud' ),
		array( 'ion-code' => 'Code' ),
		array( 'ion-code-download' => 'Code Download' ),
		array( 'ion-code-working' => 'Code Working' ),
		array( 'ion-coffee' => 'Coffee' ),
		array( 'ion-compass' => 'Compass' ),
		array( 'ion-compose' => 'Compose' ),
		array( 'ion-connection-bars' => 'Connectbars' ),
		array( 'ion-contrast' => 'Contrast' ),
		array( 'ion-crop' => 'Crop' ),
		array( 'ion-cube' => 'Cube' ),
		array( 'ion-disc' => 'Disc' ),
		array( 'ion-document' => 'Document' ),
		array( 'ion-document-text' => 'Document Text' ),
		array( 'ion-drag' => 'Drag' ),
		array( 'ion-earth' => 'Earth' ),
		array( 'ion-easel' => 'Easel' ),
		array( 'ion-edit' => 'Edit' ),
		array( 'ion-egg' => 'Egg' ),
		array( 'ion-eject' => 'Eject' ),
		array( 'ion-email' => 'Email' ),
		array( 'ion-email-unread' => 'Email Unread' ),
		array( 'ion-erlenmeyer-flask' => 'Erlenmeyer Flask' ),
		array( 'ion-erlenmeyer-flask-bubbles' => 'Erlenmeyer Flask Bubbles' ),
		array( 'ion-eye' => 'Eye' ),
		array( 'ion-eye-disabled' => 'Eye Disabled' ),
		array( 'ion-female' => 'Female' ),
		array( 'ion-filing' => 'Filing' ),
		array( 'ion-film-marker' => 'Film Marker' ),
		array( 'ion-fireball' => 'Fireball' ),
		array( 'ion-flag' => 'Flag' ),
		array( 'ion-flame' => 'Flame' ),
		array( 'ion-flash' => 'Flash' ),
		array( 'ion-flash-off' => 'Flash Off' ),
		array( 'ion-folder' => 'Folder' ),
		array( 'ion-fork' => 'Fork' ),
		array( 'ion-fork-repo' => 'Fork Repo' ),
		array( 'ion-forward' => 'Forward' ),
		array( 'ion-funnel' => 'Funnel' ),
		array( 'ion-gear-a' => 'Gear A' ),
		array( 'ion-gear-b' => 'Gear B' ),
		array( 'ion-grid' => 'Grid' ),
		array( 'ion-hammer' => 'Hammer' ),
		array( 'ion-happy' => 'Happy' ),
		array( 'ion-happy-outline' => 'Happy Outline' ),
		array( 'ion-headphone' => 'Headphone' ),
		array( 'ion-heart' => 'Heart' ),
		array( 'ion-heart-broken' => 'Heart Broken' ),
		array( 'ion-help' => 'Help' ),
		array( 'ion-help-buoy' => 'Help Buoy' ),
		array( 'ion-help-circled' => 'Help Circled' ),
		array( 'ion-home' => 'Home' ),
		array( 'ion-icecream' => 'Icecream' ),
		array( 'ion-image' => 'Image' ),
		array( 'ion-images' => 'Images' ),
		array( 'ion-information' => 'Information' ),
		array( 'ion-information-circled' => 'Informatcircled' ),
		array( 'ion-ionic' => 'Ionic' ),
		array( 'ion-ios-alarm' => 'Ios Alarm' ),
		array( 'ion-ios-alarm-outline' => 'Ios Alarm Outline' ),
		array( 'ion-ios-albums' => 'Ios Albums' ),
		array( 'ion-ios-albums-outline' => 'Ios Albums Outline' ),
		array( 'ion-ios-americanfootball' => 'Ios Americanfootball' ),
		array( 'ion-ios-americanfootball-outline' => 'Ios Americanfootball Outline' ),
		array( 'ion-ios-analytics' => 'Ios Analytics' ),
		array( 'ion-ios-analytics-outline' => 'Ios Analytics Outline' ),
		array( 'ion-ios-arrow-back' => 'Ios Arrow Back' ),
		array( 'ion-ios-arrow-down' => 'Ios Arrow Down' ),
		array( 'ion-ios-arrow-forward' => 'Ios Arrow Forward' ),
		array( 'ion-ios-arrow-left' => 'Ios Arrow Left' ),
		array( 'ion-ios-arrow-right' => 'Ios Arrow Right' ),
		array( 'ion-ios-arrow-thin-down' => 'Ios Arrow Thin Down' ),
		array( 'ion-ios-arrow-thin-left' => 'Ios Arrow Thin Left' ),
		array( 'ion-ios-arrow-thin-right' => 'Ios Arrow Thin Right' ),
		array( 'ion-ios-arrow-thin-up' => 'Ios Arrow Thin Up' ),
		array( 'ion-ios-arrow-up' => 'Ios Arrow Up' ),
		array( 'ion-ios-at' => 'Ios At' ),
		array( 'ion-ios-at-outline' => 'Ios At Outline' ),
		array( 'ion-ios-barcode' => 'Ios Barcode' ),
		array( 'ion-ios-barcode-outline' => 'Ios Barcode Outline' ),
		array( 'ion-ios-baseball' => 'Ios Baseball' ),
		array( 'ion-ios-baseball-outline' => 'Ios Baseball Outline' ),
		array( 'ion-ios-basketball' => 'Ios Basketball' ),
		array( 'ion-ios-basketball-outline' => 'Ios Basketball Outline' ),
		array( 'ion-ios-bell' => 'Ios Bell' ),
		array( 'ion-ios-bell-outline' => 'Ios Bell Outline' ),
		array( 'ion-ios-body' => 'Ios Body' ),
		array( 'ion-ios-body-outline' => 'Ios Body Outline' ),
		array( 'ion-ios-bolt' => 'Ios Bolt' ),
		array( 'ion-ios-bolt-outline' => 'Ios Bolt Outline' ),
		array( 'ion-ios-book' => 'Ios Book' ),
		array( 'ion-ios-book-outline' => 'Ios Book Outline' ),
		array( 'ion-ios-bookmarks' => 'Ios Bookmarks' ),
		array( 'ion-ios-bookmarks-outline' => 'Ios Bookmarks Outline' ),
		array( 'ion-ios-box' => 'Ios Box' ),
		array( 'ion-ios-box-outline' => 'Ios Box Outline' ),
		array( 'ion-ios-briefcase' => 'Ios Briefcase' ),
		array( 'ion-ios-briefcase-outline' => 'Ios Briefcase Outline' ),
		array( 'ion-ios-browsers' => 'Ios Browsers' ),
		array( 'ion-ios-browsers-outline' => 'Ios Browsers Outline' ),
		array( 'ion-ios-calculator' => 'Ios Calculator' ),
		array( 'ion-ios-calculator-outline' => 'Ios Calculator Outline' ),
		array( 'ion-ios-calendar' => 'Ios Calendar' ),
		array( 'ion-ios-calendar-outline' => 'Ios Calendar Outline' ),
		array( 'ion-ios-camera' => 'Ios Camera' ),
		array( 'ion-ios-camera-outline' => 'Ios Camera Outline' ),
		array( 'ion-ios-cart' => 'Ios Cart' ),
		array( 'ion-ios-cart-outline' => 'Ios Cart Outline' ),
		array( 'ion-ios-chatboxes' => 'Ios Chatboxes' ),
		array( 'ion-ios-chatboxes-outline' => 'Ios Chatboxes Outline' ),
		array( 'ion-ios-chatbubble' => 'Ios Chatbubble' ),
		array( 'ion-ios-chatbubble-outline' => 'Ios Chatbubble Outline' ),
		array( 'ion-ios-checkmark' => 'Ios Checkmark' ),
		array( 'ion-ios-checkmark-empty' => 'Ios Checkmark Empty' ),
		array( 'ion-ios-checkmark-outline' => 'Ios Checkmark Outline' ),
		array( 'ion-ios-circle-filled' => 'Ios Circle Filled' ),
		array( 'ion-ios-circle-outline' => 'Ios Circle Outline' ),
		array( 'ion-ios-clock' => 'Ios Clock' ),
		array( 'ion-ios-clock-outline' => 'Ios Clock Outline' ),
		array( 'ion-ios-close' => 'Ios Close' ),
		array( 'ion-ios-close-empty' => 'Ios Close Empty' ),
		array( 'ion-ios-close-outline' => 'Ios Close Outline' ),
		array( 'ion-ios-cloud' => 'Ios Cloud' ),
		array( 'ion-ios-cloud-download' => 'Ios Cloud Download' ),
		array( 'ion-ios-cloud-download-outline' => 'Ios Cloud Download Outline' ),
		array( 'ion-ios-cloud-outline' => 'Ios Cloud Outline' ),
		array( 'ion-ios-cloud-upload' => 'Ios Cloud Upload' ),
		array( 'ion-ios-cloud-upload-outline' => 'Ios Cloud Upload Outline' ),
		array( 'ion-ios-cloudy' => 'Ios Cloudy' ),
		array( 'ion-ios-cloudy-night' => 'Ios Cloudy Night' ),
		array( 'ion-ios-cloudy-night-outline' => 'Ios Cloudy Night Outline' ),
		array( 'ion-ios-cloudy-outline' => 'Ios Cloudy Outline' ),
		array( 'ion-ios-cog' => 'Ios Cog' ),
		array( 'ion-ios-cog-outline' => 'Ios Cog Outline' ),
		array( 'ion-ios-color-filter' => 'Ios Color Filter' ),
		array( 'ion-ios-color-filter-outline' => 'Ios Color Filter Outline' ),
		array( 'ion-ios-color-wand' => 'Ios Color Wand' ),
		array( 'ion-ios-color-wand-outline' => 'Ios Color Wand Outline' ),
		array( 'ion-ios-compose' => 'Ios Compose' ),
		array( 'ion-ios-compose-outline' => 'Ios Compose Outline' ),
		array( 'ion-ios-contact' => 'Ios Contact' ),
		array( 'ion-ios-contact-outline' => 'Ios Contact Outline' ),
		array( 'ion-ios-copy' => 'Ios Copy' ),
		array( 'ion-ios-copy-outline' => 'Ios Copy Outline' ),
		array( 'ion-ios-crop' => 'Ios Crop' ),
		array( 'ion-ios-crop-strong' => 'Ios Crop Strong' ),
		array( 'ion-ios-download' => 'Ios Download' ),
		array( 'ion-ios-download-outline' => 'Ios Download Outline' ),
		array( 'ion-ios-drag' => 'Ios Drag' ),
		array( 'ion-ios-email' => 'Ios Email' ),
		array( 'ion-ios-email-outline' => 'Ios Email Outline' ),
		array( 'ion-ios-eye' => 'Ios Eye' ),
		array( 'ion-ios-eye-outline' => 'Ios Eye Outline' ),
		array( 'ion-ios-fastforward' => 'Ios Fastforward' ),
		array( 'ion-ios-fastforward-outline' => 'Ios Fastforward Outline' ),
		array( 'ion-ios-filing' => 'Ios Filing' ),
		array( 'ion-ios-filing-outline' => 'Ios Filing Outline' ),
		array( 'ion-ios-film' => 'Ios Film' ),
		array( 'ion-ios-film-outline' => 'Ios Film Outline' ),
		array( 'ion-ios-flag' => 'Ios Flag' ),
		array( 'ion-ios-flag-outline' => 'Ios Flag Outline' ),
		array( 'ion-ios-flame' => 'Ios Flame' ),
		array( 'ion-ios-flame-outline' => 'Ios Flame Outline' ),
		array( 'ion-ios-flask' => 'Ios Flask' ),
		array( 'ion-ios-flask-outline' => 'Ios Flask Outline' ),
		array( 'ion-ios-flower' => 'Ios Flower' ),
		array( 'ion-ios-flower-outline' => 'Ios Flower Outline' ),
		array( 'ion-ios-folder' => 'Ios Folder' ),
		array( 'ion-ios-folder-outline' => 'Ios Folder Outline' ),
		array( 'ion-ios-football' => 'Ios Football' ),
		array( 'ion-ios-football-outline' => 'Ios Football Outline' ),
		array( 'ion-ios-game-controller-a' => 'Ios Game Controller A' ),
		array( 'ion-ios-game-controller-a-outline' => 'Ios Game Controller A Outline' ),
		array( 'ion-ios-game-controller-b' => 'Ios Game Controller B' ),
		array( 'ion-ios-game-controller-b-outline' => 'Ios Game Controller B Outline' ),
		array( 'ion-ios-gear' => 'Ios Gear' ),
		array( 'ion-ios-gear-outline' => 'Ios Gear Outline' ),
		array( 'ion-ios-glasses' => 'Ios Glasses' ),
		array( 'ion-ios-glasses-outline' => 'Ios Glasses Outline' ),
		array( 'ion-ios-grid-view' => 'Ios Grid View' ),
		array( 'ion-ios-grid-view-outline' => 'Ios Grid View Outline' ),
		array( 'ion-ios-heart' => 'Ios Heart' ),
		array( 'ion-ios-heart-outline' => 'Ios Heart Outline' ),
		array( 'ion-ios-help' => 'Ios Help' ),
		array( 'ion-ios-help-empty' => 'Ios Help Empty' ),
		array( 'ion-ios-help-outline' => 'Ios Help Outline' ),
		array( 'ion-ios-home' => 'Ios Home' ),
		array( 'ion-ios-home-outline' => 'Ios Home Outline' ),
		array( 'ion-ios-infinite' => 'Ios Infinite' ),
		array( 'ion-ios-infinite-outline' => 'Ios Infinite Outline' ),
		array( 'ion-ios-information' => 'Ios Information' ),
		array( 'ion-ios-information-empty' => 'Ios Informatempty' ),
		array( 'ion-ios-information-outline' => 'Ios Informatoutline' ),
		array( 'ion-ios-ionic-outline' => 'Ios Ionic Outline' ),
		array( 'ion-ios-keypad' => 'Ios Keypad' ),
		array( 'ion-ios-keypad-outline' => 'Ios Keypad Outline' ),
		array( 'ion-ios-lightbulb' => 'Ios Lightbulb' ),
		array( 'ion-ios-lightbulb-outline' => 'Ios Lightbulb Outline' ),
		array( 'ion-ios-list' => 'Ios List' ),
		array( 'ion-ios-list-outline' => 'Ios List Outline' ),
		array( 'ion-ios-location' => 'Ios Location' ),
		array( 'ion-ios-location-outline' => 'Ios Locatoutline' ),
		array( 'ion-ios-locked' => 'Ios Locked' ),
		array( 'ion-ios-locked-outline' => 'Ios Locked Outline' ),
		array( 'ion-ios-loop' => 'Ios Loop' ),
		array( 'ion-ios-loop-strong' => 'Ios Loop Strong' ),
		array( 'ion-ios-medical' => 'Ios Medical' ),
		array( 'ion-ios-medical-outline' => 'Ios Medical Outline' ),
		array( 'ion-ios-medkit' => 'Ios Medkit' ),
		array( 'ion-ios-medkit-outline' => 'Ios Medkit Outline' ),
		array( 'ion-ios-mic' => 'Ios Mic' ),
		array( 'ion-ios-mic-off' => 'Ios Mic Off' ),
		array( 'ion-ios-mic-outline' => 'Ios Mic Outline' ),
		array( 'ion-ios-minus' => 'Ios Minus' ),
		array( 'ion-ios-minus-empty' => 'Ios Minus Empty' ),
		array( 'ion-ios-minus-outline' => 'Ios Minus Outline' ),
		array( 'ion-ios-monitor' => 'Ios Monitor' ),
		array( 'ion-ios-monitor-outline' => 'Ios Monitor Outline' ),
		array( 'ion-ios-moon' => 'Ios Moon' ),
		array( 'ion-ios-moon-outline' => 'Ios Moon Outline' ),
		array( 'ion-ios-more' => 'Ios More' ),
		array( 'ion-ios-more-outline' => 'Ios More Outline' ),
		array( 'ion-ios-musical-note' => 'Ios Musical Note' ),
		array( 'ion-ios-musical-notes' => 'Ios Musical Notes' ),
		array( 'ion-ios-navigate' => 'Ios Navigate' ),
		array( 'ion-ios-navigate-outline' => 'Ios Navigate Outline' ),
		array( 'ion-ios-nutrition' => 'Ios Nutrition' ),
		array( 'ion-ios-nutrition-outline' => 'Ios Nutritoutline' ),
		array( 'ion-ios-paper' => 'Ios Paper' ),
		array( 'ion-ios-paper-outline' => 'Ios Paper Outline' ),
		array( 'ion-ios-paperplane' => 'Ios Paperplane' ),
		array( 'ion-ios-paperplane-outline' => 'Ios Paperplane Outline' ),
		array( 'ion-ios-partlysunny' => 'Ios Partlysunny' ),
		array( 'ion-ios-partlysunny-outline' => 'Ios Partlysunny Outline' ),
		array( 'ion-ios-pause' => 'Ios Pause' ),
		array( 'ion-ios-pause-outline' => 'Ios Pause Outline' ),
		array( 'ion-ios-paw' => 'Ios Paw' ),
		array( 'ion-ios-paw-outline' => 'Ios Paw Outline' ),
		array( 'ion-ios-people' => 'Ios People' ),
		array( 'ion-ios-people-outline' => 'Ios People Outline' ),
		array( 'ion-ios-person' => 'Ios Person' ),
		array( 'ion-ios-person-outline' => 'Ios Person Outline' ),
		array( 'ion-ios-personadd' => 'Ios Personadd' ),
		array( 'ion-ios-personadd-outline' => 'Ios Personadd Outline' ),
		array( 'ion-ios-photos' => 'Ios Photos' ),
		array( 'ion-ios-photos-outline' => 'Ios Photos Outline' ),
		array( 'ion-ios-pie' => 'Ios Pie' ),
		array( 'ion-ios-pie-outline' => 'Ios Pie Outline' ),
		array( 'ion-ios-pint' => 'Ios Pint' ),
		array( 'ion-ios-pint-outline' => 'Ios Pint Outline' ),
		array( 'ion-ios-play' => 'Ios Play' ),
		array( 'ion-ios-play-outline' => 'Ios Play Outline' ),
		array( 'ion-ios-plus' => 'Ios Plus' ),
		array( 'ion-ios-plus-empty' => 'Ios Plus Empty' ),
		array( 'ion-ios-plus-outline' => 'Ios Plus Outline' ),
		array( 'ion-ios-pricetag' => 'Ios Pricetag' ),
		array( 'ion-ios-pricetag-outline' => 'Ios Pricetag Outline' ),
		array( 'ion-ios-pricetags' => 'Ios Pricetags' ),
		array( 'ion-ios-pricetags-outline' => 'Ios Pricetags Outline' ),
		array( 'ion-ios-printer' => 'Ios Printer' ),
		array( 'ion-ios-printer-outline' => 'Ios Printer Outline' ),
		array( 'ion-ios-pulse' => 'Ios Pulse' ),
		array( 'ion-ios-pulse-strong' => 'Ios Pulse Strong' ),
		array( 'ion-ios-rainy' => 'Ios Rainy' ),
		array( 'ion-ios-rainy-outline' => 'Ios Rainy Outline' ),
		array( 'ion-ios-recording' => 'Ios Recording' ),
		array( 'ion-ios-recording-outline' => 'Ios Recording Outline' ),
		array( 'ion-ios-redo' => 'Ios Redo' ),
		array( 'ion-ios-redo-outline' => 'Ios Redo Outline' ),
		array( 'ion-ios-refresh' => 'Ios Refresh' ),
		array( 'ion-ios-refresh-empty' => 'Ios Refresh Empty' ),
		array( 'ion-ios-refresh-outline' => 'Ios Refresh Outline' ),
		array( 'ion-ios-reload' => 'Ios Reload' ),
		array( 'ion-ios-reverse-camera' => 'Ios Reverse Camera' ),
		array( 'ion-ios-reverse-camera-outline' => 'Ios Reverse Camera Outline' ),
		array( 'ion-ios-rewind' => 'Ios Rewind' ),
		array( 'ion-ios-rewind-outline' => 'Ios Rewind Outline' ),
		array( 'ion-ios-rose' => 'Ios Rose' ),
		array( 'ion-ios-rose-outline' => 'Ios Rose Outline' ),
		array( 'ion-ios-search' => 'Ios Search' ),
		array( 'ion-ios-search-strong' => 'Ios Search Strong' ),
		array( 'ion-ios-settings' => 'Ios Settings' ),
		array( 'ion-ios-settings-strong' => 'Ios Settings Strong' ),
		array( 'ion-ios-shuffle' => 'Ios Shuffle' ),
		array( 'ion-ios-shuffle-strong' => 'Ios Shuffle Strong' ),
		array( 'ion-ios-skipbackward' => 'Ios Skipbackward' ),
		array( 'ion-ios-skipbackward-outline' => 'Ios Skipbackward Outline' ),
		array( 'ion-ios-skipforward' => 'Ios Skipforward' ),
		array( 'ion-ios-skipforward-outline' => 'Ios Skipforward Outline' ),
		array( 'ion-ios-snowy' => 'Ios Snowy' ),
		array( 'ion-ios-speedometer' => 'Ios Speedometer' ),
		array( 'ion-ios-speedometer-outline' => 'Ios Speedometer Outline' ),
		array( 'ion-ios-star' => 'Ios Star' ),
		array( 'ion-ios-star-half' => 'Ios Star Half' ),
		array( 'ion-ios-star-outline' => 'Ios Star Outline' ),
		array( 'ion-ios-stopwatch' => 'Ios Stopwatch' ),
		array( 'ion-ios-stopwatch-outline' => 'Ios Stopwatch Outline' ),
		array( 'ion-ios-sunny' => 'Ios Sunny' ),
		array( 'ion-ios-sunny-outline' => 'Ios Sunny Outline' ),
		array( 'ion-ios-telephone' => 'Ios Telephone' ),
		array( 'ion-ios-telephone-outline' => 'Ios Telephone Outline' ),
		array( 'ion-ios-tennisball' => 'Ios Tennisball' ),
		array( 'ion-ios-tennisball-outline' => 'Ios Tennisball Outline' ),
		array( 'ion-ios-thunderstorm' => 'Ios Thunderstorm' ),
		array( 'ion-ios-thunderstorm-outline' => 'Ios Thunderstorm Outline' ),
		array( 'ion-ios-time' => 'Ios Time' ),
		array( 'ion-ios-time-outline' => 'Ios Time Outline' ),
		array( 'ion-ios-timer' => 'Ios Timer' ),
		array( 'ion-ios-timer-outline' => 'Ios Timer Outline' ),
		array( 'ion-ios-toggle' => 'Ios Toggle' ),
		array( 'ion-ios-toggle-outline' => 'Ios Toggle Outline' ),
		array( 'ion-ios-trash' => 'Ios Trash' ),
		array( 'ion-ios-trash-outline' => 'Ios Trash Outline' ),
		array( 'ion-ios-undo' => 'Ios Undo' ),
		array( 'ion-ios-undo-outline' => 'Ios Undo Outline' ),
		array( 'ion-ios-unlocked' => 'Ios Unlocked' ),
		array( 'ion-ios-unlocked-outline' => 'Ios Unlocked Outline' ),
		array( 'ion-ios-upload' => 'Ios Upload' ),
		array( 'ion-ios-upload-outline' => 'Ios Upload Outline' ),
		array( 'ion-ios-videocam' => 'Ios Videocam' ),
		array( 'ion-ios-videocam-outline' => 'Ios Videocam Outline' ),
		array( 'ion-ios-volume-high' => 'Ios Volume High' ),
		array( 'ion-ios-volume-low' => 'Ios Volume Low' ),
		array( 'ion-ios-wineglass' => 'Ios Wineglass' ),
		array( 'ion-ios-wineglass-outline' => 'Ios Wineglass Outline' ),
		array( 'ion-ios-world' => 'Ios World' ),
		array( 'ion-ios-world-outline' => 'Ios World Outline' ),
		array( 'ion-ipad' => 'Ipad' ),
		array( 'ion-iphone' => 'Iphone' ),
		array( 'ion-ipod' => 'Ipod' ),
		array( 'ion-jet' => 'Jet' ),
		array( 'ion-key' => 'Key' ),
		array( 'ion-knife' => 'Knife' ),
		array( 'ion-laptop' => 'Laptop' ),
		array( 'ion-leaf' => 'Leaf' ),
		array( 'ion-levels' => 'Levels' ),
		array( 'ion-lightbulb' => 'Lightbulb' ),
		array( 'ion-link' => 'Link' ),
		array( 'ion-load-a' => 'Load A' ),
		array( 'ion-load-b' => 'Load B' ),
		array( 'ion-load-c' => 'Load C' ),
		array( 'ion-load-d' => 'Load D' ),
		array( 'ion-location' => 'Location' ),
		array( 'ion-lock-combination' => 'Lock Combination' ),
		array( 'ion-locked' => 'Locked' ),
		array( 'ion-log-in' => 'Log In' ),
		array( 'ion-log-out' => 'Log Out' ),
		array( 'ion-loop' => 'Loop' ),
		array( 'ion-magnet' => 'Magnet' ),
		array( 'ion-male' => 'Male' ),
		array( 'ion-man' => 'Man' ),
		array( 'ion-map' => 'Map' ),
		array( 'ion-medkit' => 'Medkit' ),
		array( 'ion-merge' => 'Merge' ),
		array( 'ion-mic-a' => 'Mic A' ),
		array( 'ion-mic-b' => 'Mic B' ),
		array( 'ion-mic-c' => 'Mic C' ),
		array( 'ion-minus' => 'Minus' ),
		array( 'ion-minus-circled' => 'Minus Circled' ),
		array( 'ion-minus-round' => 'Minus Round' ),
		array( 'ion-model-s' => 'Model S' ),
		array( 'ion-monitor' => 'Monitor' ),
		array( 'ion-more' => 'More' ),
		array( 'ion-mouse' => 'Mouse' ),
		array( 'ion-music-note' => 'Music Note' ),
		array( 'ion-navicon' => 'Navicon' ),
		array( 'ion-navicon-round' => 'Navicon Round' ),
		array( 'ion-navigate' => 'Navigate' ),
		array( 'ion-network' => 'Network' ),
		array( 'ion-no-smoking' => 'No Smoking' ),
		array( 'ion-nuclear' => 'Nuclear' ),
		array( 'ion-outlet' => 'Outlet' ),
		array( 'ion-paintbrush' => 'Paintbrush' ),
		array( 'ion-paintbucket' => 'Paintbucket' ),
		array( 'ion-paper-airplane' => 'Paper Airplane' ),
		array( 'ion-paperclip' => 'Paperclip' ),
		array( 'ion-pause' => 'Pause' ),
		array( 'ion-person' => 'Person' ),
		array( 'ion-person-add' => 'Person Add' ),
		array( 'ion-person-stalker' => 'Person Stalker' ),
		array( 'ion-pie-graph' => 'Pie Graph' ),
		array( 'ion-pin' => 'Pin' ),
		array( 'ion-pinpoint' => 'Pinpoint' ),
		array( 'ion-pizza' => 'Pizza' ),
		array( 'ion-plane' => 'Plane' ),
		array( 'ion-planet' => 'Planet' ),
		array( 'ion-play' => 'Play' ),
		array( 'ion-playstation' => 'Playstation' ),
		array( 'ion-plus' => 'Plus' ),
		array( 'ion-plus-circled' => 'Plus Circled' ),
		array( 'ion-plus-round' => 'Plus Round' ),
		array( 'ion-podium' => 'Podium' ),
		array( 'ion-pound' => 'Pound' ),
		array( 'ion-power' => 'Power' ),
		array( 'ion-pricetag' => 'Pricetag' ),
		array( 'ion-pricetags' => 'Pricetags' ),
		array( 'ion-printer' => 'Printer' ),
		array( 'ion-pull-request' => 'Pull Request' ),
		array( 'ion-qr-scanner' => 'Qr Scanner' ),
		array( 'ion-quote' => 'Quote' ),
		array( 'ion-radio-waves' => 'Radio Waves' ),
		array( 'ion-record' => 'Record' ),
		array( 'ion-refresh' => 'Refresh' ),
		array( 'ion-reply' => 'Reply' ),
		array( 'ion-reply-all' => 'Reply All' ),
		array( 'ion-ribbon-a' => 'Ribbon A' ),
		array( 'ion-ribbon-b' => 'Ribbon B' ),
		array( 'ion-sad' => 'Sad' ),
		array( 'ion-sad-outline' => 'Sad Outline' ),
		array( 'ion-scissors' => 'Scissors' ),
		array( 'ion-search' => 'Search' ),
		array( 'ion-settings' => 'Settings' ),
		array( 'ion-share' => 'Share' ),
		array( 'ion-shuffle' => 'Shuffle' ),
		array( 'ion-skip-backward' => 'Skip Backward' ),
		array( 'ion-skip-forward' => 'Skip Forward' ),
		array( 'ion-social-android' => 'Social Android' ),
		array( 'ion-social-android-outline' => 'Social Android Outline' ),
		array( 'ion-social-angular' => 'Social Angular' ),
		array( 'ion-social-angular-outline' => 'Social Angular Outline' ),
		array( 'ion-social-apple' => 'Social Apple' ),
		array( 'ion-social-apple-outline' => 'Social Apple Outline' ),
		array( 'ion-social-bitcoin' => 'Social Bitcoin' ),
		array( 'ion-social-bitcoin-outline' => 'Social Bitcoin Outline' ),
		array( 'ion-social-buffer' => 'Social Buffer' ),
		array( 'ion-social-buffer-outline' => 'Social Buffer Outline' ),
		array( 'ion-social-chrome' => 'Social Chrome' ),
		array( 'ion-social-chrome-outline' => 'Social Chrome Outline' ),
		array( 'ion-social-codepen' => 'Social Codepen' ),
		array( 'ion-social-codepen-outline' => 'Social Codepen Outline' ),
		array( 'ion-social-css3' => 'Social Css3' ),
		array( 'ion-social-css3-outline' => 'Social Css3 Outline' ),
		array( 'ion-social-designernews' => 'Social Designernews' ),
		array( 'ion-social-designernews-outline' => 'Social Designernews Outline' ),
		array( 'ion-social-dribbble' => 'Social Dribbble' ),
		array( 'ion-social-dribbble-outline' => 'Social Dribbble Outline' ),
		array( 'ion-social-dropbox' => 'Social Dropbox' ),
		array( 'ion-social-dropbox-outline' => 'Social Dropbox Outline' ),
		array( 'ion-social-euro' => 'Social Euro' ),
		array( 'ion-social-euro-outline' => 'Social Euro Outline' ),
		array( 'ion-social-facebook' => 'Social Facebook' ),
		array( 'ion-social-facebook-outline' => 'Social Facebook Outline' ),
		array( 'ion-social-foursquare' => 'Social Foursquare' ),
		array( 'ion-social-foursquare-outline' => 'Social Foursquare Outline' ),
		array( 'ion-social-freebsd-devil' => 'Social Freebsd Devil' ),
		array( 'ion-social-github' => 'Social Github' ),
		array( 'ion-social-github-outline' => 'Social Github Outline' ),
		array( 'ion-social-google' => 'Social Google' ),
		array( 'ion-social-google-outline' => 'Social Google Outline' ),
		array( 'ion-social-googleplus' => 'Social Googleplus' ),
		array( 'ion-social-googleplus-outline' => 'Social Googleplus Outline' ),
		array( 'ion-social-hackernews' => 'Social Hackernews' ),
		array( 'ion-social-hackernews-outline' => 'Social Hackernews Outline' ),
		array( 'ion-social-html5' => 'Social Html5' ),
		array( 'ion-social-html5-outline' => 'Social Html5 Outline' ),
		array( 'ion-social-instagram' => 'Social Instagram' ),
		array( 'ion-social-instagram-outline' => 'Social Instagram Outline' ),
		array( 'ion-social-javascript' => 'Social Javascript' ),
		array( 'ion-social-javascript-outline' => 'Social Javascript Outline' ),
		array( 'ion-social-linkedin' => 'Social Linkedin' ),
		array( 'ion-social-linkedin-outline' => 'Social Linkedin Outline' ),
		array( 'ion-social-markdown' => 'Social Markdown' ),
		array( 'ion-social-nodejs' => 'Social Nodejs' ),
		array( 'ion-social-octocat' => 'Social Octocat' ),
		array( 'ion-social-pinterest' => 'Social Pinterest' ),
		array( 'ion-social-pinterest-outline' => 'Social Pinterest Outline' ),
		array( 'ion-social-python' => 'Social Python' ),
		array( 'ion-social-reddit' => 'Social Reddit' ),
		array( 'ion-social-reddit-outline' => 'Social Reddit Outline' ),
		array( 'ion-social-rss' => 'Social Rss' ),
		array( 'ion-social-rss-outline' => 'Social Rss Outline' ),
		array( 'ion-social-sass' => 'Social Sass' ),
		array( 'ion-social-skype' => 'Social Skype' ),
		array( 'ion-social-skype-outline' => 'Social Skype Outline' ),
		array( 'ion-social-snapchat' => 'Social Snapchat' ),
		array( 'ion-social-snapchat-outline' => 'Social Snapchat Outline' ),
		array( 'ion-social-tumblr' => 'Social Tumblr' ),
		array( 'ion-social-tumblr-outline' => 'Social Tumblr Outline' ),
		array( 'ion-social-tux' => 'Social Tux' ),
		array( 'ion-social-twitch' => 'Social Twitch' ),
		array( 'ion-social-twitch-outline' => 'Social Twitch Outline' ),
		array( 'ion-social-twitter' => 'Social Twitter' ),
		array( 'ion-social-twitter-outline' => 'Social Twitter Outline' ),
		array( 'ion-social-usd' => 'Social Usd' ),
		array( 'ion-social-usd-outline' => 'Social Usd Outline' ),
		array( 'ion-social-vimeo' => 'Social Vimeo' ),
		array( 'ion-social-vimeo-outline' => 'Social Vimeo Outline' ),
		array( 'ion-social-whatsapp' => 'Social Whatsapp' ),
		array( 'ion-social-whatsapp-outline' => 'Social Whatsapp Outline' ),
		array( 'ion-social-windows' => 'Social Windows' ),
		array( 'ion-social-windows-outline' => 'Social Windows Outline' ),
		array( 'ion-social-wordpress' => 'Social Wordpress' ),
		array( 'ion-social-wordpress-outline' => 'Social Wordpress Outline' ),
		array( 'ion-social-yahoo' => 'Social Yahoo' ),
		array( 'ion-social-yahoo-outline' => 'Social Yahoo Outline' ),
		array( 'ion-social-yen' => 'Social Yen' ),
		array( 'ion-social-yen-outline' => 'Social Yen Outline' ),
		array( 'ion-social-youtube' => 'Social Youtube' ),
		array( 'ion-social-youtube-outline' => 'Social Youtube Outline' ),
		array( 'ion-soup-can' => 'Soup Can' ),
		array( 'ion-soup-can-outline' => 'Soup Can Outline' ),
		array( 'ion-speakerphone' => 'Speakerphone' ),
		array( 'ion-speedometer' => 'Speedometer' ),
		array( 'ion-spoon' => 'Spoon' ),
		array( 'ion-star' => 'Star' ),
		array( 'ion-stats-bars' => 'Stats Bars' ),
		array( 'ion-steam' => 'Steam' ),
		array( 'ion-stop' => 'Stop' ),
		array( 'ion-thermometer' => 'Thermometer' ),
		array( 'ion-thumbsdown' => 'Thumbsdown' ),
		array( 'ion-thumbsup' => 'Thumbsup' ),
		array( 'ion-toggle' => 'Toggle' ),
		array( 'ion-toggle-filled' => 'Toggle Filled' ),
		array( 'ion-transgender' => 'Transgender' ),
		array( 'ion-trash-a' => 'Trash A' ),
		array( 'ion-trash-b' => 'Trash B' ),
		array( 'ion-trophy' => 'Trophy' ),
		array( 'ion-tshirt' => 'Tshirt' ),
		array( 'ion-tshirt-outline' => 'Tshirt Outline' ),
		array( 'ion-umbrella' => 'Umbrella' ),
		array( 'ion-university' => 'University' ),
		array( 'ion-unlocked' => 'Unlocked' ),
		array( 'ion-upload' => 'Upload' ),
		array( 'ion-usb' => 'Usb' ),
		array( 'ion-videocamera' => 'Videocamera' ),
		array( 'ion-volume-high' => 'Volume High' ),
		array( 'ion-volume-low' => 'Volume Low' ),
		array( 'ion-volume-medium' => 'Volume Medium' ),
		array( 'ion-volume-mute' => 'Volume Mute' ),
		array( 'ion-wand' => 'Wand' ),
		array( 'ion-waterdrop' => 'Waterdrop' ),
		array( 'ion-wifi' => 'Wifi' ),
		array( 'ion-wineglass' => 'Wineglass' ),
		array( 'ion-woman' => 'Woman' ),
		array( 'ion-wrench' => 'Wrench' ),
		array( 'ion-xbox' => 'Xbox' ),
	);

	return array_merge( $icons, $font_ionicons );
}


/**
 * Show userid in profile edit
 */
add_action( 'show_user_profile', 'thim_extra_profile_show_userid' );
add_action( 'edit_user_profile', 'thim_extra_profile_show_userid' );

function thim_extra_profile_show_userid( $user ) {
	?>
    <table class="form-table">
        <tr>
            <th>
                <label><?php esc_html_e( 'User ID', 'course-builder' ); ?></label>
            </th>
            <td>

                <input type="text" value="<?php echo esc_attr( $user->ID ) ?>" disabled="disabled" class="regular-text">
                <span class="description"><?php esc_html_e( 'ID cannot be changed.', 'course-builder' ); ?></span>
            </td>
        </tr>
    </table>
	<?php
}

function thim_sc_get_course_categories( $cats = false ) {
	global $wpdb;
	$query = $wpdb->get_results( $wpdb->prepare(
		" SELECT      t1.term_id, t2.name
				  FROM        $wpdb->term_taxonomy AS t1
				  INNER JOIN $wpdb->terms AS t2 ON t1.term_id = t2.term_id
				  WHERE t1.taxonomy = %s
				  AND t1.count > %d
				  ",
		'course_category', 0
	) );

	if ( ! $cats ) {
		$cats = array();
	}
	if ( ! empty( $query ) ) {
		foreach ( $query as $key => $value ) {
			$cats[ $value->name ] = $value->term_id;
		}
	}

	return $cats;
}

add_action( 'wp_ajax_nopriv_thim_course_search', 'thim_cb_element_course_search_callback' );
add_action( 'wp_ajax_thim_course_search', 'thim_cb_element_course_search_callback' );
function thim_cb_element_course_search_callback() {
	$keyword = $_REQUEST['keyword'];
	$newdata = array();
	if ( $keyword ) {
		$keyword   = strtoupper( $keyword );
		$arr_query = array(
			'post_type'           => 'lp_course',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			's'                   => $keyword
		);
		$search    = new WP_Query( $arr_query );
		foreach ( $search->posts as $post ) {
			$newdata[] = array(
				'id'    => $post->ID,
				'title' => $post->post_title,
				'guid'  => get_permalink( $post->ID ),
			);
		}

		if ( ! count( $search->posts ) ) {
			$newdata[] = array(
				'id'    => '',
				'title' => esc_attr__( 'No course found', 'course-builder' ),
				'guid'  => '#',
			);
		}
	}
	wp_send_json_success( $newdata );
	wp_die();
}


add_action( 'thim_social_share_video', 'thim_element_social_share_video' );
function thim_element_social_share_video() {
	echo '<span class="label">' . esc_html__( 'Share', 'course-builder' ) . '</span>';
	echo '<ul>';
	global $post;
	$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
	echo '<li><a class="link facebook" title="' . esc_html__( 'Facebook', 'course-builder' ) . '" href="http://www.facebook.com/sharer/sharer.php?u=' . urlencode( get_permalink() ) . '&amp;media=' . ( ! empty( $src[0] ) ? $src[0] : '' ) . '&description=' . esc_attr( urlencode( get_the_title() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>';
	echo '<li><a class="link twitter" title="' . esc_html__( 'Twitter', 'course-builder' ) . '" href="https://twitter.com/intent/tweet?url=' . urlencode( get_permalink() ) . '&amp;text=' . esc_attr( urlencode( get_the_title() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>';
	echo '<li><a class="link google" title="' . esc_html__( 'Google', 'course-builder' ) . '" href="https://plus.google.com/share?url=' . esc_url( urlencode( get_permalink() ) ) . '&amp;media=' . ( ! empty( $src[0] ) ? $src[0] : '' ) . '&description=' . esc_attr( urlencode( get_the_title() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="ion-social-googleplus" aria-hidden="true"></i></a></li>';
	echo '<li><a class="link pinterest" title="' . esc_html__( 'Pinterest', 'course-builder' ) . '" href="http://pinterest.com/pin/create/button/?url=' . urlencode( get_permalink() ) . '&amp;media=' . ( ! empty( $src[0] ) ? $src[0] : '' ) . '&description=' . esc_attr( urlencode( get_the_title() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>';
	echo '</ul>';
}
function thim_element_get_video( $url = '' ) {
	$video_id = $html = '';
	switch ( thim_element_video_type( $url ) ) {
		case 'vimeo':
			$video_id = thim_element_parse_vimeo( $url );
			$html     .= '<iframe src="https://player.vimeo.com/video/' . $video_id . '?title=0&byline=0" width="640" height="268"  webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
			break;
		case 'youtube':
			$video_id = thim_element_parse_youtube( $url );
			$html     .= '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $video_id . '" allowfullscreen></iframe>';
			break;
		default:
			$html .= esc_html_e( 'Supported: Vimeo, Youtube', 'course-builder' );
			break;
	}

	return $html;
}

function thim_element_video_type( $url ) {
	if ( strpos( $url, 'youtube' ) > 0 ) {
		return 'youtube';
	} elseif ( strpos( $url, 'vimeo' ) > 0 ) {
		return 'vimeo';
	} else {
		return 'unknown';
	}
}

function thim_element_parse_youtube( $link ) {

	$regexstr = '~
			# Match Youtube link and embed code
			(?:				 				# Group to match embed codes
				(?:&lt;iframe [^&gt;]*src=")?	 
				|(?:				 		# Group to match if older embed
					(?:&lt;object .*&gt;)?		# Match opening Object tag
					(?:&lt;param .*&lt;/param&gt;)*  # Match all param tags
					(?:&lt;embed [^&gt;]*src=")?  # Match embed tag to the first quote of src
				)?				 			# End older embed code group
			)?				 				# End embed code groups
			(?:				 				# Group youtube url
				https?:\/\/		         	# Either http or https
				(?:[\w]+\.)*		        # Optional subdomains
				(?:               	        # Group host alternatives.
				youtu\.be/      	        # Either youtu.be,
				| youtube\.com		 		# or youtube.com 
				| youtube-nocookie\.com	 	# or youtube-nocookie.com
				)				 			# End Host Group
				(?:\S*[^\w\-\s])?       	# Extra stuff up to VIDEO_ID
				([\w\-]{11})		        # $1: VIDEO_ID is numeric
				[^\s]*			 			# Not a space
			)				 				# End group
			"?				 				# Match end quote if part of src
			(?:[^&gt;]*&gt;)?			 			# Match any extra stuff up to close brace
			(?:				 				# Group to match last embed code
				&lt;/iframe&gt;		         
				|&lt;/embed&gt;&lt;/object&gt;	        # or Match the end of the older embed
			)?				 				# End Group of last bit of embed code
			~ix';

	preg_match( $regexstr, $link, $matches );

	return $matches[1];

}

function thim_element_parse_vimeo( $link ) {

	$regexstr = '~
			# Match Vimeo link and embed code
			(?:&lt;iframe [^&gt;]*src=")?	
			(?:							# Group vimeo url
				https?:\/\/				# Either http or https
				(?:[\w]+\.)*			# Optional subdomains
				vimeo\.com				# Match vimeo.com
				(?:[\/\w]*\/videos?)?	# Optional video sub directory this handles groups links also
				\/						# Slash before Id
				([0-9]+)				# $1: VIDEO_ID is numeric
				[^\s]*					# Not a space
			)							# End group
			"?							# Match end quote if part of src
			(?:[^&gt;]*&gt;&lt;/iframe&gt;)?	
			(?:&lt;p&gt;.*&lt;/p&gt;)?		        # Match any title information stuff
			~ix';

	preg_match( $regexstr, $link, $matches );

	return $matches[1];

}

 function thim_course_number( $course_id ) {
	$number_courses = count( get_post_meta( $course_id, '_lp_collection_courses' ) );

	if ( $number_courses >= 1000 ) {
		$number_courses = intval( $number_courses / 1000 ) * 1000;
		echo '<div class="number-courses">' . esc_html( sprintf( __( 'Over %d courses', 'course-builder' ), $number_courses ) ) . '</div>';
	} elseif ( $number_courses >= 100 ) {
		$number_courses = intval( $number_courses / 100 ) * 100;
		echo '<div class="number-courses">' . esc_html( sprintf( __( 'Over %d courses', 'course-builder' ), $number_courses ) ) . '</div>';
	} elseif ( $number_courses > 1 ) {
		echo '<div class="number-courses">' . esc_html( sprintf( __( '%d courses', 'course-builder' ), $number_courses ) ) . '</div>';
	} else {
		echo '<div class="number-courses">' . esc_html( sprintf( __( '%d course', 'course-builder' ), $number_courses ) ) . '</div>';
	}
}