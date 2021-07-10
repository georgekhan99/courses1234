<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Pricing_Element extends Widget_Base {

	public function get_name() {
		return 'thim-pricing';
	}

	public function get_title() {
		return esc_html__( 'Thim: Pricing', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-pricing';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'pricing';
	}

	protected function _register_controls() {
		wp_register_script( 'thim-sc-pricing', THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/pricing-custom.js', array( 'jquery' ),THIM_CB_VERSION, true );
  		wp_enqueue_script( 'thim-sc-pricing' );

		$this->start_controls_section(
			'pricing_settings',
			[
				'label' => esc_html__( 'Pricing Settings', 'course-builder' )
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'package',
			[
				'label'       => esc_html__( 'Package', 'course-builder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Package', 'course-builder' ),
				'default'     => 'Basic'
			]
		);

		$repeater->add_control(
			'price',
			[
				'label'       => esc_html__( 'Price', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Price', 'course-builder' ),
				'default'     => '$100'
			]
		);

		$repeater->add_control(
			'unit',
			[
				'label'       => esc_html__( 'Unit', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Unit', 'course-builder' ),
				'default'     => 'Month'
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button text', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Button text', 'course-builder' ),
				'default'     => 'Button text'
			]
		);

		$repeater->add_control(
			'button_link',
			[
				'label'       => esc_html__( 'Button Link', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Button Link', 'course-builder' ),
				'default'     => '#'
			]
		);

		$repeater->add_control(
			'features',
			[
				'label'       => esc_html__( 'Features', 'course-builder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Features', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'pricing',
			[
				'label'       => esc_html__( 'Pricing List', 'course-builder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ package }}}',
				'separator'   => 'before'
			]
		);

		$this->add_control(
			'columns',
			[
				'label'   => esc_html__( 'Select columns', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'3' => esc_html__( '3', 'course-builder' ),
					'4' => esc_html__( '4', 'course-builder' ),
				],
				'default' => '3',
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
		$settings['sc-name'] = $this->get_base();
		thim_get_template( 'default', array( 'params' => $settings ),$this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'params' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Pricing_Element() );