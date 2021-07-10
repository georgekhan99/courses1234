<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Gallery_Element extends Widget_Base {

	public function get_name() {
		return 'thim-gallery';
	}

	public function get_title() {
		return esc_html__( 'Thim: Gallery Posts', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-gallery-post';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return  'gallery';
	}

	protected function _register_controls() {
		wp_register_script( 'thim-gallery', THIM_CB_ELEMENTS_URL . $this->get_base()  . '/assets/js/gallery-custom.js', array(
			'jquery',
			'isotope',
			'magnific-popup'
		),THIM_CB_VERSION, true );

		wp_enqueue_script( 'thim-gallery' );

		$this->start_controls_section(
			'gallery_settings',
			[
				'label' => esc_html__( 'Courses Block 3 Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'cat',
			[
				'label'    => esc_html__( 'Select Category', 'course-builder' ),
				'type'     => Controls_Manager::SELECT2,
				'multiple' => true,
				'options'   => thim_get_cat_courses( 'category','', true ),
 				'default'  => '',
			]
		);

		$this->add_control(
			'columns',
			[
				'label'   => esc_html__( 'Number of columns', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'3' => esc_html__( '3', 'course-builder' ),
					'4' => esc_html__( '4', 'course-builder' ),
					'5' => esc_html__( '5', 'course-builder' ),
					'6' => esc_html__( '6', 'course-builder' ),
				],
				'default' => '4',
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Number', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '8',
			]
		);

		$this->add_control(
			'filter',
			[
				'label'   => esc_html__( 'Hide Filter?', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'el_class',
			[
				'label'       => esc_html__( 'Extra Class', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Extra Class', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		thim_get_template( 'default', array( 'params' => $settings ),$this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Gallery_Element() );