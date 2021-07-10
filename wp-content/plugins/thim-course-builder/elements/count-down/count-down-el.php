<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Count_Down_Element extends Widget_Base {

	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );
		wp_register_script( 'thim-jquery-countdown', THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/libs/jquery.countdown.min.js', array( 'jquery' ), THIM_CB_VERSION, true );
		wp_register_script( 'thim-countdown', THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/count-down.js', array(
			'jquery',
			'thim-jquery-countdown'
		), THIM_CB_VERSION, true );
	}

	public function get_script_depends() {
		return [ 'thim-countdown' ];
	}

	public function get_name() {
		return 'thim-count-down';
	}

	public function get_title() {
		return esc_html__( 'Thim: Countdown', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-count-down';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'count-down';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'countdown_settings',
			[
				'label' => esc_html__( 'Countdown Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'time',
			[
				'label'   => __( 'Countdown Date', 'course-builder' ),
				'type'    => Controls_Manager::DATE_TIME,
				'default' => '2019/06/17 21:00'
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Countdown Title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Countdown Title', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => esc_html__( 'Select Style', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''       => esc_html__( 'Default', 'course-builder' ),
					'style2' => esc_html__( 'Contact Form', 'course-builder' ),
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
		thim_get_template( 'default', array( 'params' => $settings ), $this->get_base() . '/tpl/' );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Count_Down_Element() );