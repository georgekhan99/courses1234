<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Brand_Element extends Widget_Base {

	public function get_name() {
		return 'thim-brands';
	}

	public function get_title() {
		return esc_html__( 'Thim: Brands', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-brands';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'brands';
	}

	protected function _register_controls() {
		wp_enqueue_script( 'thim-brands', THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/brands-custom.js', array(
			'jquery',
			'owlcarousel'
		), THIM_CB_VERSION, true );

		$this->start_controls_section(
			'brands_settings',
			[
				'label' => esc_html__( 'Brands Settings', 'course-builder' )
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'brand_img',
			[
				'label'   => esc_html__( 'Brand Image', 'course-builder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

		$repeater->add_control(
			'brand_link',
			[
				'label'       => esc_html__( 'Brand Link', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Brand Link', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'items',
			[
				'label'       => esc_html__( 'Brands List', 'course-builder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ brand_link }}}',
				'separator'   => 'before'
			]
		);

		$this->add_control(
			'items_visible',
			[
				'label'   => esc_html__( 'Visible Items', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '6',
			]
		);

		$this->add_control(
			'items_tablet',
			[
				'label'   => esc_html__( 'Tablet Items', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '4',
			]
		);

		$this->add_control(
			'items_mobile',
			[
				'label'   => esc_html__( 'Mobile Items', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '2',
			]
		);

		$this->add_control(
			'nav',
			[
				'label'   => esc_html__( 'Show dots navigation?', 'course-builder' ),
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
		thim_get_template( 'default', array( 'params' => $settings ), $this->get_base() . '/tpl/' );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Brand_Element() );