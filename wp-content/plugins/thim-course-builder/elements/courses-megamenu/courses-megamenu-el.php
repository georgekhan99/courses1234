<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Courses_Magamenu_Element extends Widget_Base {

	public function get_name() {
		return 'thim-courses-megamenu';
	}

	public function get_title() {
		return esc_html__( 'Thim: Courses - MegaMenu', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-course-megamenu';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return  'courses-megamenu';
	}

	// Get list category


	protected function _register_controls() {

		$this->start_controls_section(
			'courses_megamenu_settings',
			[
				'label' => esc_html__( 'Courses Megamenu Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'cols',
			[
				'label'   => esc_html__( 'Number of columns', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( '1', 'course-builder' ),
					'2' => esc_html__( '2', 'course-builder' ),
					'3' => esc_html__( '3', 'course-builder' ),
					'4' => esc_html__( '4', 'course-builder' ),
				],
				'default' => '1',
			]
		);

		$this->add_control(
			'list_courses',
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
			'cat_courses',
			[
				'label'     => esc_html__( 'Select Category', 'course-builder' ),
				'type'      => Controls_Manager::SELECT2,
				'multiple'  => false,
				'options'   => thim_get_cat_courses( 'course_category', '', true ),
				'default'   => '0',
				'condition' => [
					'list_courses' => [ 'category' ]
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

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		thim_get_template( 'default', array( 'params' => $settings ),$this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Courses_Magamenu_Element() );