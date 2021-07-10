<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Courses_Block_3_Element extends Widget_Base {

	public function get_name() {
		return 'thim-courses-block-3';
	}

	public function get_title() {
		return esc_html__( 'Thim: Courses - Block 3', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-courses-block-3';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'courses-block-3';
	}

	// Get list category


	protected function _register_controls() {
		wp_register_script( 'thim-courses-block-3', THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/courses-block-3-custom.js', array(
			'jquery',
			'imagesloaded',
			'isotope'
		),THIM_CB_VERSION, true );

 		wp_enqueue_script( 'thim-courses-block-3' );

		$this->start_controls_section(
			'courses_block_3_settings',
			[
				'label' => esc_html__( 'Courses Block 3 Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Course Block Title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Course Block Title', 'course-builder' ),
				'default'     => 'Our Top Courses'
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button text', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Button text', 'course-builder' ),
				'default'     => 'View all courses'
			]
		);

		$this->add_control(
			'filter',
			[
				'label'   => esc_html__( 'Hide categories filter?', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'cols',
			[
				'label'   => esc_html__( 'Number of columns', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'3' => esc_html__( '3', 'course-builder' ),
					'4' => esc_html__( '4', 'course-builder' ),
				],
				'default' => '4',
			]
		);

		$this->add_control(
			'course_list',
			[
				'label'   => esc_html__( 'Show courses by', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'latest'   => esc_html__( 'Latest', 'course-builder' ),
					'popular'  => esc_html__( 'Popular', 'course-builder' ),
					'category' => esc_html__( 'Category', 'course-builder' ),
				],
				'default' => 'latest',
			]
		);

		$this->add_control(
			'course_cat',
			[
				'label'     => esc_html__( 'Select Category', 'course-builder' ),
				'type'      => Controls_Manager::SELECT2,
				'multiple'  => false,
				'options'   => thim_get_cat_courses( 'course_category', '', true ),
				'default'   => '0',
				'condition' => [
					'course_list' => [ 'category' ]
				]
			]
		);

		$this->add_control(
			'course_featured',
			[
				'label'   => esc_html__( 'Show Featured Courses?', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'course_limit',
			[
				'label'   => esc_html__( 'Number of visible courses', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '8',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$path     = thim_is_new_learnpress( '3.0' ) ? 'lp3/' : '';
		thim_get_template( $path . 'default', array( 'params' => $settings ), $this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Courses_Block_3_Element() );