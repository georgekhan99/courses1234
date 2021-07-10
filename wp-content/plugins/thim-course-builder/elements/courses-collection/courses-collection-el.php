<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Courses_Collection_Element extends Widget_Base {

	public function get_name() {
		return 'thim-courses-collection';
	}

	public function get_title() {
		return esc_html__( 'Thim: Courses Collection', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-courses-collection';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'courses-collection';
	}


	protected function _register_controls() {
		wp_register_script( 'thim-courses-collection', THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/courses-collection-custom.js', array(
			'jquery',
			'sly',
			'owlcarousel'
		),THIM_CB_VERSION, true );
  		wp_enqueue_script( 'thim-courses-collection' );

		$this->start_controls_section(
			'courses_collection_settings',
			[
				'label' => esc_html__( 'Courses Collection Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => __( 'Layout', 'course-builder' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'default'          => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/sc-courses-collection-default.png' . '">',
						'icon'  => 'bp_el_class'
					],
					'rounded-corner'   => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/sc-courses-collection-rounded.png' . '">',
						'icon'  => 'bp_el_class'
					],
					'squared-corner'   => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/sc-courses-collection-squared.png' . '">',
						'icon'  => 'bp_el_class'
					],
					'squared-corner-2' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/sc-courses-collection-squared-2.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'rounded-kit'      => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/sc-courses-collection-rounded.png' . '">',
						'icon'  => 'bp_el_class'
					],
				],
				'default' => 'default',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'none_carousel',
			[
				'label'     => esc_html__( 'Disable Carousel Feature', 'course-builder' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'layout' => [ 'default' ]
				]
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Collection Title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Collection Title', 'course-builder' ),
				'default'     => 'Science courses collection'
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Collection Description', 'course-builder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'We have the largest collection of courses', 'course-builder' ),
				'default'     => 'We have the largest collection of courses'
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter button text linked to course archive page', 'course-builder' ),
				'default'     => 'View all courses',
				'condition'   => [
					'layout' => [ 'default', 'rounded-corner', 'squared-corner-2' ]
				]
			]
		);

		$this->add_control(
			'limit',
			[
				'label'     => esc_html__( 'Number of visible courses', 'course-builder' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '8',
				'condition' => [
					'layout' => [ 'default', 'rounded-corner', 'squared-corner-2', 'rounded-kit' ]
				]
			]
		);

		$this->add_control(
			'visible',
			[
				'label'   => esc_html__( 'Number of columns', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( '1', 'course-builder' ),
					'2' => esc_html__( '2', 'course-builder' ),
					'3' => esc_html__( '3', 'course-builder' ),
					'4' => esc_html__( '4', 'course-builder' ),
					'5' => esc_html__( '5', 'course-builder' ),
				],
				'default' => '4',
			]
		);

		$this->add_control(
			'nav',
			[
				'label'     => esc_html__( 'Show arrow navigation?', 'course-builder' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'layout' => [ 'squared-corner', 'rounded-kit' ]
				]
			]
		);

		$this->add_control(
			'scrollbar',
			[
				'label'     => esc_html__( 'Show Scrollbar?', 'course-builder' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'layout' => [ 'default', 'rounded-corner' ]
				]
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$path     = thim_is_new_learnpress( '3.0' ) ? 'lp3/' : '';
		if ( ! isset( $settings['layout'] ) ) {
			$settings['layout'] = 'default';
		}
		thim_get_template( $path . $settings['layout'], array( 'params' => $settings ), $this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ), $settings['layout'] );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Courses_Collection_Element() );