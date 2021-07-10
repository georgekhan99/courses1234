<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Thim_SC_Project' ) ) {

	class Thim_SC_Project {

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
			$this->name        = esc_attr__( 'Thim: Portfolio', 'course-builder' );
			$this->description = esc_attr__( 'Display Portfolio', 'course-builder' );
			$this->base        = 'portfolio';
			//====================== END: CONFIG =====================


			$this->map();
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
		}

		/**
		 * Load assets
		 */
		public function assets() {
			wp_register_script( 'thim-portfolio-appear', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/jquery.appear.js', array( 'jquery' ),THIM_CB_VERSION, true );
			wp_register_script( 'thim-portfolio-widget', THIM_CB_ELEMENTS_URL . $this->base . '/assets/js/portfolio.js', array(
				'jquery',
				'thim-portfolio-appear',
				'magnific-popup',
				'imagesloaded',
				'isotope',
				'masonry'
			),THIM_CB_VERSION, true );
		}

		/**
		 * vc map shortcode
		 */
		public function map() {

			vc_map( array(
				'name'        => $this->name,
				'base'        => 'thim-' . $this->base,
				'category'    => esc_html__( 'Thim Shortcodes', 'course-builder' ),
				'description' => $this->description,
				'icon'        => THIM_CB_URL . '/assets/images/icon/portfolio.jpg',
				'params'      => array(

					array(
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Columns:', 'course-builder' ),
						'param_name'       => 'column',
						'edit_field_class' => 'vc_col-sm-6',
						'value'            => array(
							esc_html__( '4', 'course-builder' ) => 4,
							esc_html__( '3', 'course-builder' ) => 3,
							esc_html__( '2', 'course-builder' ) => 2,
						),
						'admin_label'      => true,
					),

					array(
						'type'             => 'checkbox',
						'heading'          => esc_html__( 'Gutter', 'course-builder' ),
						'value'            => array(
							esc_html__( 'yes', 'course-builder' ) => esc_attr( 'yes' ),
						),
						'std'              => 'true',
						'param_name'       => 'gutter',
						'admin_label'      => true,
						'edit_field_class' => 'vc_col-sm-6',
					),

					array(
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Select a item size', 'course-builder' ),
						'param_name'       => 'item_size',
						'edit_field_class' => 'vc_col-sm-6',
						'value'            => array(
							esc_html__( 'Multigrid', 'course-builder' ) => 'multigrid',
							esc_html__( 'Masonry', 'course-builder' )   => 'masonry',
							esc_html__( 'Same size', 'course-builder' ) => 'same',
						),
						'admin_label'      => true,
					),

					array(
						'type'             => 'dropdown',
						'heading'          => esc_html__( 'Select a paging:', 'course-builder' ),
						'param_name'       => 'paging',
						'edit_field_class' => 'vc_col-sm-6',
						'value'            => array(
							esc_html__( 'Show All', 'course-builder' )        => 'all',
							esc_html__( 'Limit Items', 'course-builder' )     => 'limit',
							esc_html__( 'Paging', 'course-builder' )          => 'paging',
							esc_html__( 'Infinite Scroll', 'course-builder' ) => 'infinite_scroll',
						),
						'admin_label'      => true,
					),

					// Extra class
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => esc_html__( 'Extra class', 'course-builder' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'Add extra class name for Thim Gallery Carousel shortcode to use in CSS customizations.', 'course-builder' ),
					),

				)
			) );
		}

		/**
		 * Add shortcode
		 *
		 * @param $atts
		 */
		public function shortcode( $atts ) {
			$params = shortcode_atts( array(
				'column'    => '',
				'gutter'    => '',
				'item_size' => '',
				'paging'    => '',
				'el_class'  => '',
			), $atts );

			ob_start();
			wp_enqueue_script( 'thim-portfolio-widget' );
			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;

		}

	}

	new Thim_SC_Project();
}