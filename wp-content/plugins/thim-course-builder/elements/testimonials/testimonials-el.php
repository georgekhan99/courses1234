<?php

namespace Elementor;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Testimonials_Element extends Widget_Base {
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		wp_register_script( 'thim-sc-testimonials', THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/js/testimonials.js', array( 'jquery', 'thim-content-slider', 'owlcarousel' ),THIM_CB_VERSION, true );
  	}

	public function get_script_depends() {
		return [ 'thim-sc-testimonials' ];
	}
	public function get_name() {
		return 'thim-testimonials';
	}

	public function get_title() {
		return esc_html__( 'Thim: Testimonials', 'course-builder' );
	}

	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-sc-testimonials';
	}

	public function get_categories() {
		return [ 'thim-elements' ];
	}

	public function get_base() {
		return 'testimonials';
	}

	protected function _register_controls() {


		$this->start_controls_section(
			'testimonials_settings',
			[
				'label' => esc_html__( 'Testimonials Settings', 'course-builder' )
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => __( 'Layout', 'course-builder' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'layout-1' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout-1.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'layout-2' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout-2.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'layout-3' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout-3.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'layout-4' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout-4.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'layout-5' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout-5.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'layout-6' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout-6.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'layout-7' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout-6.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
					'layout-8' => [
						'title' => '<img src="'.THIM_CB_ELEMENTS_URL . $this->get_base() . '/assets/images/layouts/layout-2.jpg' . '">',
						'icon'  => 'bp_el_class'
					],
				],
				'default' => 'layout-1',
				'toggle'  => false,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'name',
			[
				'label'       => esc_html__( 'Person Name', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Person Name', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Person Image', 'course-builder' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				]
			]
		);

		$repeater->add_control(
			'website',
			[
				'label'       => esc_html__( 'Person Website', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Person Website', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'regency',
			[
				'label'       => esc_html__( 'Person Regency', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Person Regency', 'course-builder' ),
				'default'     => ''
			]
		);

		$repeater->add_control(
			'content',
			[
				'label'       => esc_html__( 'Content', 'course-builder' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Content', 'course-builder' ),
				'default'     => ''
			]
		);

		//Social
		$repeater->add_control(
			'show_facebook',
			[
				'label'   => esc_html__( 'Show Facebook', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$repeater->add_control(
			'name_social_facebook',
			[
				'label'       => esc_html__( 'Social Name', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Social Name', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'show_facebook' => [ 'yes' ]
				]
			]
		);

		$repeater->add_control(
			'link_facebook',
			[
				'label'       => esc_html__( 'Social Link', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Social Link', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'show_facebook' => [ 'yes' ]
				]
			]
		);

		$repeater->add_control(
			'show_dribbble',
			[
				'label'   => esc_html__( 'Show Dribbble', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$repeater->add_control(
			'name_social_dribbble',
			[
				'label'       => esc_html__( 'Social Name', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Social Name', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'show_dribbble' => [ 'yes' ]
				]
			]
		);

		$repeater->add_control(
			'link_dribbble',
			[
				'label'       => esc_html__( 'Social Link', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Social Link', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'show_dribbble' => [ 'yes' ]
				]
			]
		);

		$repeater->add_control(
			'show_instagram',
			[
				'label'   => esc_html__( 'Show Instagram', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$repeater->add_control(
			'name_social_instagram',
			[
				'label'       => esc_html__( 'Social Name', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Social Name', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'show_instagram' => [ 'yes' ]
				]
			]
		);

		$repeater->add_control(
			'link_instagram',
			[
				'label'       => esc_html__( 'Social Link', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Social Link', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'show_instagram' => [ 'yes' ]
				]
			]
		);

		$repeater->add_control(
			'show_twitter',
			[
				'label'   => esc_html__( 'Show Twitter', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$repeater->add_control(
			'name_social_twitter',
			[
				'label'       => esc_html__( 'Social Name', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Social Name', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'show_twitter' => [ 'yes' ]
				]
			]
		);

		$repeater->add_control(
			'link_twitter',
			[
				'label'       => esc_html__( 'Social Link', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Social Link', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'show_twitter' => [ 'yes' ]
				]
			]
		);

		$repeater->add_control(
			'show_youtube',
			[
				'label'   => esc_html__( 'Show Youtube', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$repeater->add_control(
			'name_social_youtube',
			[
				'label'       => esc_html__( 'Social Name', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Social Name', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'show_youtube' => [ 'yes' ]
				]
			]
		);

		$repeater->add_control(
			'link_youtube',
			[
				'label'       => esc_html__( 'Social Link', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Social Link', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'show_youtube' => [ 'yes' ]
				]
			]
		);

		$repeater->add_control(
			'show_google',
			[
				'label'   => esc_html__( 'Show Google', 'course-builder' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$repeater->add_control(
			'name_social_google',
			[
				'label'       => esc_html__( 'Social Name', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Social Name', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'show_google' => [ 'yes' ]
				]
			]
		);

		$repeater->add_control(
			'link_google',
			[
				'label'       => esc_html__( 'Social Link', 'course-builder' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Social Link', 'course-builder' ),
				'default'     => '',
				'condition'   => [
					'show_google' => [ 'yes' ]
				]
			]
		);

		$this->add_control(
			'testimonials',
			[
				'label'       => esc_html__( 'Testimonials List', 'course-builder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
				'separator'   => 'before'
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

		$params            = array(
			'layout'       => $settings['layout'],
			'testimonials' => $settings['testimonials'],
			'el_class'     => $settings['el_class'],
		);
 		$params['base'] = $this->get_base();

		thim_get_template( 'default', array( 'params' => $params ),$this->get_base() . '/tpl/' );

//		thim_get_elementor_template( $this->get_base(), array( 'params' => $params ) );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Thim_Testimonials_Element() );