<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Courses_Carousel_Element extends Widget_Base {

	public function get_name() {
		return 'thim-courses-carousel';
	}

	public function get_title() {
		return esc_html__( 'Thim: Courses Carousel', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-courses-carousel';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'courses-carousel';
	}

	// Get list category


	protected function _register_controls() {
		wp_register_script( 'thim-courses-carousel', THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/courses-carousel-custom.js', array(
			'jquery',
			'owlcarousel'
		),THIM_CB_VERSION, true );

		wp_enqueue_script( 'thim-courses-carousel' );

		$this->start_controls_section(
			'courses_carousel_settings',
			[
				'label' => esc_html__( 'Courses Carousel', 'course-builder' )
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
				'options'   => thim_get_cat_courses( 'course_category', esc_html__( 'All', 'course-builder' ), true ),
				'default'   => '0',
				'condition' => [
					'list_courses' => [ 'category' ]
				]
			]
		);

		$this->add_control(
			'featured_courses',
			[
				'label'   => esc_html__( 'Show Featured Courses?', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => esc_html__( 'Select Style', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'course-builder' ),
					'style-1' => esc_html__( 'Style 1', 'course-builder' ),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'course_navigation',
			[
				'label'   => esc_html__( 'Show arrow navigation', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$this->add_control(
			'course_dots',
			[
				'label'   => esc_html__( 'Show dots navigation', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$this->add_control(
			'course_columns',
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
			'course_number',
			[
				'label'   => esc_html__( 'Number of visible courses', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '8',
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
		if ( ! isset( $settings['style'] ) ) {
			$settings['style'] = 'default';
		}
		thim_get_template( $path . $settings['style'], array( 'params' => $settings ), $this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ), $settings['style'] );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Courses_Carousel_Element() );