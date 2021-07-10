<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Photo_Wall_Element extends Widget_Base {

	public function get_name() {
		return 'thim-photo-wall';
	}

	public function get_title() {
		return esc_html__( 'Thim: Photo Wall', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-photo-wall';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'photo-wall';
	}

	protected function _register_controls() {
		wp_register_script( 'thim-sc-photo-wall', THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/photo-wall.js', array( 'jquery','imagesloaded','masonry','waypoints' ),THIM_CB_VERSION, true );
  		wp_enqueue_script( 'thim-sc-photo-wall' );

		$this->start_controls_section(
			'photo_wall_settings',
			[
				'label' => esc_html__( 'Photo Wall Settings', 'course-builder' )
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Select Image', 'course-builder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Image Title', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Image Title', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'       => esc_html__( 'Image Description', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Image Description', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Image Link', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Image Link', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'images',
			[
				'label'       => esc_html__( 'Images List', 'course-builder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'separator'   => 'before'
			]
		);

		$this->add_control(
			'crop_images',
			[
				'label'   => esc_html__( 'Crop Images', 'course-builder' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'image-crop' => esc_html__( 'Yes', 'course-builder' ),
					'full-size'  => esc_html__( 'No', 'course-builder' ),
				],
				'default' => 'image-crop',
			]
		);

		$this->add_control(
			'mobile_limit',
			[
				'label'   => esc_html__( 'Mobile Limit', 'course-builder' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '6',
			]
		);

		$this->add_control(
			'mobile_title',
			[
				'label'       => esc_html__( 'Mobile Text Load more', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Text for Load more on on mobile', 'course-builder' ),
				'default'     => ''
			]
		);

		$this->add_control(
			'mobile_link',
			[
				'label'       => esc_html__( 'Mobile Link Load more', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Link for Load more on on mobile', 'course-builder' ),
				'default'     => ''
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

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Photo_Wall_Element() );