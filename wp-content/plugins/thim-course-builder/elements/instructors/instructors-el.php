<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Instructors_Element extends Widget_Base {

	public function get_name() {
		return 'thim-instructors';
	}

	public function get_title() {
		return esc_html__( 'Thim: Instructors', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-instructors';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'instructors';
	}

	protected function _register_controls() {
		wp_register_script( 'thim-sc-instructors', THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/instructors-custom.js', array( 'jquery' ),THIM_CB_VERSION, true );
  		wp_enqueue_script( 'thim-sc-instructors' );

		$this->start_controls_section(
			'instructors_settings',
			[
				'label' => esc_html__( 'Instructors Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'columns',
			[
				'label'   => esc_html__( 'Columns', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'3' => esc_html__( '3', 'course-builder' ),
					'4' => esc_html__( '4', 'course-builder' ),
					'2' => esc_html__( '2', 'course-builder' ),
				],
				'default' => '3',
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Limit', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '20',
			]
		);

		$this->add_control(
			'instructor_style',
			[
				'label'   => esc_html__( 'Instructor Style', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'courses_instructor'       => esc_html__( 'Courses Instructor', 'course-builder' ),
					'all_instructor'           => esc_html__( 'All Administrator + Instructor', 'course-builder' ),
					'home1_courses_instructor' => esc_html__( 'Courses Instructor Corporate', 'course-builder' ),
					'home_courses_instructor'  => esc_html__( 'Courses Instructor Test Prep', 'course-builder' ),
				],
				'default' => 'courses_instructor',
			]
		);

		$this->add_control(
			'text_load_more',
			[
				'label'       => esc_html__( 'Text Load More', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Text Load More', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'instructor_style' => [ 'courses_instructor', 'all_instructor', 'home1_courses_instructor' ]
				]
			]
		);

		$this->add_control(
			'link_load_more',
			[
				'label'         => __( 'Link Load More', 'course-builder' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'course-builder' ),
				'show_external' => false,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
				'condition'     => [
					'instructor_style' => [ 'home1_courses_instructor' ]
				]
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

		$params = array(
			'columns'          => $settings['columns'],
			'limit'            => $settings['limit'],
			'text_load_more'   => $settings['text_load_more'],
			'link_load_more'   => $settings['link_load_more'],
			'instructor_style' => $settings['instructor_style'],
			'el_class'         => $settings['el_class'],
		);

		$params['rank']         = 0;
		$params['current_page'] = $params['page'] = $page = 1;
		$params['sc-name']      = $this->get_base();
		$path                   = thim_is_new_learnpress( '3.0' ) ? 'lp3/' : '';

		thim_get_template( $path . 'default', array( 'params' => $params ), $this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'params' => $params) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Instructors_Element() );