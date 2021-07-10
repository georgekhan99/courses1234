<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Gallery_Carousel_Element extends Widget_Base {

	public function get_name() {
		return 'thim-gallery-carousel';
	}

	public function get_title() {
		return esc_html__( 'Thim: Gallery Carousel', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-gallery-carousel';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'gallery-carousel';
	}

	protected function _register_controls() {
		wp_register_script( 'thim-gallery-carousel', THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/gallery-carousel-custom.js', array(
			'jquery',
			'owlcarousel'
		),THIM_CB_VERSION, true );

		wp_enqueue_script( 'thim-gallery-carousel' );

		$this->start_controls_section(
			'gallery_carousel_settings',
			[
				'label' => esc_html__( 'Gallery Carousel Settings', 'course-builder' )
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'gallery_img',
			[
				'label'   => esc_html__( 'Image', 'course-builder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

		$repeater->add_control(
			'gallery_title',
			[
				'label'       => esc_html__( 'Image title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Image title', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'gallery_subtitle',
			[
				'label'       => esc_html__( 'Image subtitle', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Image subtitle', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'items',
			[
				'label'       => esc_html__( 'Gallery List', 'course-builder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ gallery_title }}}',
				'separator'   => 'before'
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
		thim_get_template( 'default', array( 'params' => $settings ),$this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'setting' => $settings ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Gallery_Carousel_Element() );