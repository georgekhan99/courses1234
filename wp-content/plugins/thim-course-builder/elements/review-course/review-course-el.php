<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Review_Course_Element extends Widget_Base {

	public function get_name() {
		return 'thim-review-course';
	}

	public function get_title() {
		return esc_html__( 'Thim: Course Reviews', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-course-review';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'review-course';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'review_course_settings',
			[
				'label' => esc_html__( 'Course Reviews Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'id_course',
			[
				'label'   => esc_html__( 'Course ID', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '3946',
			]
		);

		$this->add_control(
			'number_review',
			[
				'label'       => esc_html__( 'Number of reviews', 'course-builder' ),
				'description' => 'Enter number of reviews you want to show.',
				'type'        => Controls_Manager::NUMBER,
				'default'     => '3',
			]
		);

		$this->add_control(
			'read_more',
			[
				'label'   => esc_html__( 'Show button Read More?', 'course-builder' ),
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
		$path     = thim_is_new_learnpress( '3.0' ) ? 'lp3/' : '';
		thim_get_template( $path . 'default', array( 'params' => $settings ), $this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'params' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Review_Course_Element() );