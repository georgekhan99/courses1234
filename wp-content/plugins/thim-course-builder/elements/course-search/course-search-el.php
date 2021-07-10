<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Course_Search_Element extends Widget_Base {

	public function get_name() {
		return 'thim-course-search';
	}

	public function get_title() {
		return esc_html__( 'Thim: Search Courses', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-course-search';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'course-search';
	}

	protected function _register_controls() {
		wp_register_script( 'thim-course-search', THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/course-search.js', array( 'jquery' ), THIM_CB_VERSION, true );
		wp_enqueue_script( 'thim-course-search' );

		$this->start_controls_section(
			'course_search_settings',
			[
				'label' => esc_html__( 'Course Search Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'placeholder',
			[
				'label'       => esc_html__( 'Search box placeholder', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'What do you want to learn today?', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( '* Counter Box Style', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''          => esc_html__( 'Default', 'course-builder' ),
					'popup'     => esc_html__( 'Popup', 'course-builder' ),
					'style_kit' => esc_html__( 'Style Kit Builder', 'course-builder' ),
				],
				'default' => '',
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
        $path = thim_is_new_learnpress( '3.0' ) ? 'lp3/' : '';
		thim_get_template( $path. 'default', array( 'params' => $settings ), $this->get_base() . '/tpl/' );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Course_Search_Element() );