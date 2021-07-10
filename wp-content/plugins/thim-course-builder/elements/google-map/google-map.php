<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_Google_Map' ) ) {

	class Thim_SC_Google_Map {

		/**
		 * Shortcode name
		 * @var string
		 */
		protected $name = '';

		/**
		 * Shortcode description
		 * @var string
		 */
		protected $description = '';

		/**
		 * Shortcode base
		 * @var string
		 */
		protected $base = '';


		public function __construct() {

			//======================== CONFIG ========================
			$this->name        = esc_attr__( 'Thim: Google Map', 'course-builder' );
			$this->description = esc_attr__( 'Display a Google Map location.', 'course-builder' );
			$this->base        = 'google-map';
			//====================== END: CONFIG =====================


			$this->map();
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
		}


		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-google-map', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/google-map-custom.js', array( 'jquery' ),THIM_CB_VERSION, true );

		}

		/**
		 * vc map shortcode
		 */
		public function map() {
			vc_map(
				array(
					'name'                    => esc_html__( 'Thim Google Map', 'course-builder' ),
					'base'                    => 'thim-google-map',
					'category'                => esc_html__( 'Thim Shortcodes', 'course-builder' ),
					'description'             => esc_html__( 'Display Google map.', 'course-builder' ),
					'controls'                => 'full',
					'icon'                    => THIM_CB_ELEMENTS_URL . 'google-map/assets/images/icon/sc-google-map.png',
					'show_settings_on_create' => true,
					'params'                  => array(

						array(
							'type'        => 'dropdown',
							'admin_label' => true,
							'heading'     => esc_html__( 'Google map Options', 'course-builder' ),
							'param_name'  => 'map_options',
							'value'       => array(
								esc_attr__( 'Use API', 'course-builder' )        => 'api',
								esc_attr__( 'Use Map Iframe', 'course-builder' ) => 'iframe',
							),
							'std'         =>'iframe'
						),
						
						// Map center
						array(
							'type'        => 'textarea',
							'heading'     => esc_html__( 'Map center location', 'course-builder' ),
							'param_name'  => 'map_center',
							'admin_label' => true,
							'value'       => esc_html__( 'Paris', 'course-builder' ),
							'description' => esc_html__( 'Enter a location. It can be a town, city, country or exact address.', 'course-builder' ),

						),
						// API
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_html__( 'Google Map API Key', 'course-builder' ),
							'param_name'  => 'api_key',
							'value'       => 'AIzaSyDNnrBbNMIqC2x_wTYJNEzHYSrMqQF-YVo',
							'description' => sprintf( 'Enter Google Map API Key. <a href="%1$s" target="_blank" >Get an API Key</a>', esc_url( 'https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key' ) ),
							'dependency'       => array(
								'element' => 'map_options',
								'value'   => array( 'api' ),
							),
						),
						// Map height
						array(
							'type'        => 'number',
							'admin_label' => true,
							'heading'     => esc_html__( 'Height', 'course-builder' ),
							'param_name'  => 'height',
							'min'         => 0,
							'value'       => 480,
							'suffix'      => 'px',
							'description' => esc_html__( 'Height for viewing the location.', 'course-builder' ),
						),

						// Zoom options
						array(
							'type'        => 'number',
							'admin_label' => true,
							'heading'     => esc_html__( 'Zoom level', 'course-builder' ),
							'param_name'  => 'zoom',
							'min'         => 0,
							'max'         => 21,
							'value'       => 12,
							'description' => esc_html__( 'Enter a value from 0 (world level) to 21 (street level).', 'course-builder' ),
						),

						// Show marker
						array(
							'type'        => 'checkbox',
							'heading'     => esc_html__( 'Pinpoint marker', 'course-builder' ),
							'param_name'  => 'marker_at_center',
							'description' => esc_html__( 'Show pinpoint marker at the map center location.', 'course-builder' ),
							'dependency'       => array(
								'element' => 'map_options',
								'value'   => array( 'api' ),
							),
						),

						// Get marker
						array(
							'type'        => 'attach_image',
							'heading'     => esc_html__( 'Choose pinpoint marker icon', 'course-builder' ),
							'param_name'  => 'marker_icon',
							'admin_label' => true,
							'value'       => '',
							'dependency'  => array( 'element' => 'marker_at_center', 'value' => array( 'true' ) ),
							'dependency'       => array(
								'element' => 'map_options',
								'value'   => array( 'api' ),
							),
						),

						// Other options
						array(
							'type'        => 'checkbox',
							'heading'     => esc_html__( 'Scroll to zoom', 'course-builder' ),
							'param_name'  => 'scroll_zoom',
							'description' => esc_html__( 'Allow scrolling on the map to zoom in or out.', 'course-builder' ),
							'dependency'       => array(
								'element' => 'map_options',
								'value'   => array( 'api' ),
							),
						),

						// Other options
						array(
							'type'        => 'checkbox',
							'heading'     => esc_html__( 'Draggable', 'course-builder' ),
							'param_name'  => 'draggable',
							'description' => esc_html__( 'Allow dragging mouse to move around the map.', 'course-builder' ),
							'dependency'       => array(
								'element' => 'map_options',
								'value'   => array( 'api' ),
							),
						),

						// Cover image
						array(
							'type'        => 'checkbox',
							'heading'     => esc_html__( 'Preload cover image', 'course-builder' ),
							'param_name'  => 'map_cover',
							'description' => esc_html__( 'Show preload cover image before loading the map. Enable this to speed up loading time.', 'course-builder' ),
							'value'       => false,
							'dependency'       => array(
								'element' => 'map_options',
								'value'   => array( 'api' ),
							),
						),

						// Get Cover image
						array(
							'type'        => 'attach_image',
							'heading'     => esc_html__( 'Choose preload cover image', 'course-builder' ),
							'param_name'  => 'map_cover_image',
							'admin_label' => true,
							'value'       => '',
							'dependency'  => array( 'element' => 'map_cover', 'value' => array( 'true' ) ),
							'dependency'       => array(
								'element' => 'map_options',
								'value'   => array( 'api' ),
							),
						),

						// Style
						array(
							'type'        => 'dropdown',
							'admin_label' => true,
							'heading'     => esc_html__( 'Map Style', 'course-builder' ),
							'param_name'  => 'map_style',
							'value'       => array(
								esc_attr__( 'Default', 'course-builder' )                          => 'default',
								esc_attr__( 'Ultra light with location labels', 'course-builder' ) => 'light',
							),
							'dependency'       => array(
								'element' => 'map_options',
								'value'   => array( 'api' ),
							),
						),

						// Extra class
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_html__( 'Extra class', 'course-builder' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_html__( 'Add extra class name for Thim Google Map shortcode to use in CSS customizations.', 'course-builder' ),
							'dependency'       => array(
								'element' => 'map_options',
								'value'   => array( 'api' ),
							),
						),

					)
				)
			);
		}

		/**
		 * Add shortcode
		 *
		 * @param $atts
		 */
		public function shortcode( $atts ) {

			$params = shortcode_atts( array(
				'map_options'      =>'api',
				'map_iframe'       => '',
				'title'            => esc_html__( 'Center St Newton Center, Boston, United States', 'course-builder' ),
				'map_center'       => 'Paris',
				'api_key'          => 'AIzaSyARtFR6zbpjGbGNqOSu-MknQYETXvS2cBU',
				'height'           => '480',
				'zoom'             => '12',
				'scroll_zoom'      => '',
				'draggable'        => '',
				'map_style'        => 'default',
				'marker_at_center' => '',
				'marker_icon'      => '',
				'map_cover'        => false,
				'map_cover_image'  => '',
				'animation'        => '',
				'el_class'         => '',
			), $atts );

			ob_start();

			wp_enqueue_script( 'thim-google-map' );

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}


	}

	new Thim_SC_Google_Map();
}