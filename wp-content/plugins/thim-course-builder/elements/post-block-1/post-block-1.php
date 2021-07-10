<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_SC_Post_Block_1' ) ) {

	class Thim_SC_Post_Block_1 {

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
			$this->name        = esc_attr__( 'Thim: Post Block 1', 'course-builder' );
			$this->description = esc_attr__( 'Display a posts collection.', 'course-builder' );
			$this->base        = 'post-block-1';
			//====================== END: CONFIG =====================


			$this->map();
			add_shortcode( 'thim-' . $this->base, array( $this, 'shortcode' ) );
		}

		/**
		 * vc map shortcode
		 */
		public function map() {
			vc_map(
				array(
					'name'        => $this->name,
					'base'        => 'thim-' . $this->base,
					'category'    => esc_attr__( 'Thim Shortcodes', 'course-builder' ),
					'description' => $this->description,
					'icon'        => THIM_CB_URL . '/assets/images/icon/sc-post-block-1.png',
					'params'      => array(

						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Show posts by:', 'course-builder' ),
							'param_name'  => 'list_post',
							'admin_label' => true,
							'value'       => array(
								esc_html__( 'Latest', 'course-builder' )   => 'post_date',
								esc_html__( 'Popular', 'course-builder' ) => 'comment_count',
							)
						),

						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Select Category', 'course-builder' ),
							'param_name'  => 'cat_post',
                            "description"      => esc_attr__( "Select which category if you choose to show posts by category.", 'course-builder' ),
							'admin_label' => true,
							'value'       =>  thim_get_cat_courses( 'category', esc_html__('All','course-builder')),
							'std'         => 'all',
						),
						array(
							'type'             => 'dropdown',
							'admin_label'      => true,
							'heading'          => esc_html__( 'Number of columns', 'course-builder' ),
							'param_name'       => 'post_columns',
							'value'            => array(
								esc_attr__( "1", 'course-builder' ) => '1',
								esc_attr__( "2", 'course-builder' ) => '2',
								esc_attr__( "3", 'course-builder' ) => '3',
								esc_attr__( "4", 'course-builder' ) => '4',
							),
							'std'              => '2',
							'edit_field_class' => 'vc_col-sm-6',
						),
						array(
							'type'             => 'number',
							'admin_label'      => true,
							'heading'          => esc_html__( 'Number of posts', 'course-builder' ),
							'param_name'       => 'post_number',
							'edit_field_class' => 'vc_col-sm-6',
							'description'      => esc_html__( 'Choose how many posts to show', 'course-builder' ),
							'value'            => 2,
						),
						array(
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_attr__( 'Extra class name', 'course-builder' ),
							'param_name'  => 'el_class',
							'value'       => '',
							'description' => esc_attr__( 'Add extra class name for Thim Post Block shortcode to use in CSS customizations.', 'course-builder' ),
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
				'list_post'    => 'latest',
				'cat_post'     => '',
				'post_columns' => 2,
				'post_number'  => 2,
				'el_class'     => '',

			), $atts );

			$params['post-block-1'] = $this->base;

			ob_start();

			thim_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );

			$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}


	}

	new Thim_SC_Post_Block_1();
}
