<?php
/**
 * Plugin Name: Thim Course Builder
 * Plugin URI: http://thimpress.com
 * Description: Advanced features for Course Builder theme.
 * Author: ThimPress
 * Author URI: http://thimpress.com
 * Version: 3.2.6
 * Text Domain: course-builder
 */
// Exit if accessed directly

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Thim_Course_Builder' ) ) {

	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	class Thim_Course_Builder {

		/**
		 * constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			if ( ! defined( 'THIM_CB_PATH' ) ) {
				define( 'THIM_CB_PATH', plugin_dir_path( __FILE__ ) );
			}

			// Symlink "shortcode" folder in the theme to "plugins" folder to dev ( create the environment same with user )
			define( 'THIM_CB_URL', plugin_dir_url( __FILE__ ) );
			define( 'THIM_CB_VERSION', '3.2.4' );
			define( 'THIM_CB_ELEMENTS_URL', plugin_dir_url( __FILE__ ) . 'elements/' );

			add_filter( 'user_contactmethods', array( $this, 'modify_contact_methods' ) );
			add_action( 'learn_press_update_user_profile_basic-information', array(
				$this,
				'update_contact_methods'
			), 9 );

			$this->init();

			add_action( 'init', array( $this, 'register_assets' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_assets' ) );
			add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'admin_elementor_enqueue_assets' ) );

			// Depend on Visual Composer
			if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
				add_action( 'vc_before_init', array( $this, 'load_shortcodes' ), 30 );
				add_action( 'vc_before_init', array( $this, 'thim_add_extra_vc_params' ) );
			}

			$my_theme = wp_get_theme( 'course-builder' );
			if ( is_plugin_active( 'elementor/elementor.php' ) && $my_theme->Version > '3.1.7' ) {
				include_once( THIM_CB_PATH . 'inc/el/class-elementor-extend-icons.php' );
 				add_action( 'elementor/init', array( $this, 'register_categories' ) );
				add_action( 'elementor/widgets/widgets_registered', array( $this, 'thim_add_new_elements' ) );
			}
		}


		/**
		 * Add field to user profile
		 *
		 * @param $user_contact_method
		 *
		 * @return mixed
		 */
		public function modify_contact_methods( $user_contact_method ) {
			//Add Major
			$user_contact_method['lp_info_major'] = 'Major';
			//Add status
			$user_contact_method['lp_info_status'] = 'Status';
			//Add Phone
			$user_contact_method['lp_info_phone'] = 'Phone Number';
			//Add Facebook
			$user_contact_method['lp_info_facebook'] = 'Facebook';
			// Add Twitter
			$user_contact_method['lp_info_twitter'] = 'Twitter';
			// Add Twitter
			$user_contact_method['lp_info_skype'] = 'Skype';
			//Add Facebook
			$user_contact_method['lp_info_pinterest'] = 'Pinterest';
			//Add Google Plus URL
			$user_contact_method['lp_info_google_plus'] = 'Google Plus URL';

			$user_contact_method['lp_info_linkedin'] = 'Linkedin URL';

			$user_contact_method['lp_info_instagram'] = 'Instagram URL';

			$user_contact_method['lp_info_work'] = 'Company Logo URL';

			return $user_contact_method;
		}

		public function update_contact_methods() {
			$user_id     = get_current_user_id();
			$update_data = array(
				'ID'                  => $user_id,
				'lp_info_major'       => filter_input( INPUT_POST, 'lp_info_major', FILTER_SANITIZE_STRING ),
				'lp_info_status'      => filter_input( INPUT_POST, 'lp_info_status', FILTER_SANITIZE_STRING ),
				'lp_info_phone'       => filter_input( INPUT_POST, 'lp_info_phone', FILTER_SANITIZE_STRING ),
				'lp_info_facebook'    => filter_input( INPUT_POST, 'lp_info_facebook', FILTER_SANITIZE_STRING ),
				'lp_info_twitter'     => filter_input( INPUT_POST, 'lp_info_twitter', FILTER_SANITIZE_STRING ),
				'lp_info_skype'       => filter_input( INPUT_POST, 'lp_info_skype', FILTER_SANITIZE_STRING ),
				'lp_info_pinterest'   => filter_input( INPUT_POST, 'lp_info_pinterest', FILTER_SANITIZE_STRING ),
				'lp_info_google_plus' => filter_input( INPUT_POST, 'lp_info_google_plus', FILTER_SANITIZE_STRING ),
				'lp_info_linkedin'    => filter_input( INPUT_POST, 'lp_info_linkedin', FILTER_SANITIZE_STRING ),
				'lp_info_instagram'   => filter_input( INPUT_POST, 'lp_info_instagram', FILTER_SANITIZE_STRING ),
				'lp_info_work'        => filter_input( INPUT_POST, 'lp_info_work', FILTER_SANITIZE_STRING ),
			);
			$res         = wp_update_user( $update_data );
		}


		/**
		 * Register shortcodes.
		 *
		 * @since 1.0.0
		 */
		public function load_shortcodes() {

			include_once( THIM_CB_PATH . 'elements/brands/brands.php' );
			include_once( THIM_CB_PATH . 'elements/social-links/social-links.php' );
			include_once( THIM_CB_PATH . 'elements/heading/heading.php' );
			include_once( THIM_CB_PATH . 'elements/google-map/google-map.php' );
			include_once( THIM_CB_PATH . 'elements/skills-bar/skills-bar.php' );
			include_once( THIM_CB_PATH . 'elements/icon-box/icon-box.php' );
			include_once( THIM_CB_PATH . 'elements/button/button.php' );
			include_once( THIM_CB_PATH . 'elements/count-down/count-down.php' );
			include_once( THIM_CB_PATH . 'elements/image-box/image-box.php' );
			include_once( THIM_CB_PATH . 'elements/scroll-heading/scroll-heading.php' );
			include_once( THIM_CB_PATH . 'elements/testimonials/testimonials.php' );
			include_once( THIM_CB_PATH . 'elements/counter-box/counter-box.php' );
			include_once( THIM_CB_PATH . 'elements/steps/steps.php' );
			include_once( THIM_CB_PATH . 'elements/video-box/video-box.php' );
			include_once( THIM_CB_PATH . 'elements/post-block-1/post-block-1.php' );
			include_once( THIM_CB_PATH . 'elements/photo-wall/photo-wall.php' );
			include_once( THIM_CB_PATH . 'elements/user-info/user-info.php' );
			include_once( THIM_CB_PATH . 'elements/features-list/features-list.php' );
			include_once( THIM_CB_PATH . 'elements/login-form/login-form.php' );
			include_once( THIM_CB_PATH . 'elements/gallery-carousel/gallery-carousel.php' );
			include_once( THIM_CB_PATH . 'elements/pricing/pricing.php' );
			include_once( THIM_CB_PATH . 'elements/introduction-box/introduction-box.php' );
			include_once( THIM_CB_PATH . 'elements/text-box/text-box.php' );
			include_once( THIM_CB_PATH . 'elements/gallery/gallery.php' );
			include_once( THIM_CB_PATH . 'elements/posts/posts.php' );
			include_once( THIM_CB_PATH . 'elements/new-iconbox/new-iconbox.php' );
			include_once( THIM_CB_PATH . 'elements/new-post/new-post.php' );
			include_once( THIM_CB_PATH . 'elements/new-image-box/new-image-box.php' );
			include_once( THIM_CB_PATH . 'elements/new-video/new-video.php' );
			include_once( THIM_CB_PATH . 'elements/register-form/register-form.php' );

			// Shortcodes for LearnPress
			if ( class_exists( 'LearnPress' ) ) {
				include_once( THIM_CB_PATH . 'elements/enroll-course/enroll-course.php' );
				include_once( THIM_CB_PATH . 'elements/courses-carousel/courses-carousel.php' );
				include_once( THIM_CB_PATH . 'elements/course-search/course-search.php' );
				include_once( THIM_CB_PATH . 'elements/courses-block-1/courses-block-1.php' );
				include_once( THIM_CB_PATH . 'elements/courses-block-2/courses-block-2.php' );
				include_once( THIM_CB_PATH . 'elements/courses-block-3/courses-block-3.php' );
				include_once( THIM_CB_PATH . 'elements/courses-block-4/courses-block-4.php' );
				include_once( THIM_CB_PATH . 'elements/courses-megamenu/courses-megamenu.php' );
			}

			if ( class_exists( 'LP_Co_Instructor_Preload' ) ) {
				include_once( THIM_CB_PATH . 'elements/instructors/instructors.php' );
				include_once( THIM_CB_PATH . 'elements/new-instructor/new-instructor.php' );
			}

			if ( class_exists( 'LP_Addon_Course_Review' ) ) {
				include_once( THIM_CB_PATH . 'elements/review-course/review-course.php' );
			}

			// Shortcodes for WP Events Manager
			if ( class_exists( 'WPEMS' ) ) {
				include_once( THIM_CB_PATH . 'elements/events/events.php' );
			}

			// Shortcodes for LearnPress Collections
			if ( class_exists( 'LP_Addon_Collections' ) ) {
				include_once( THIM_CB_PATH . 'elements/courses-collection/courses-collection.php' );
			}

			// Shortcodes for Portfolio
			if ( class_exists( 'Thim_Portfolio' ) ) {
				include_once( THIM_CB_PATH . 'elements/portfolio/portfolio.php' );
			}

		}

		public function register_categories() {
			\Elementor\Plugin::instance()->elements_manager->add_category(
				'thim-elements',
				array(
					'title' => esc_html__( 'Thim Elements', 'course-builder' ),
					'icon'  => 'font'
				)
			);
		}

		/**
		 * Register shortcodes.
		 *
		 * @since 1.0.0
		 */
		public function thim_add_new_elements() {

			include_once( THIM_CB_PATH . 'elements/brands/brands-el.php' );
			include_once( THIM_CB_PATH . 'elements/social-links/social-links-el.php' );
			include_once( THIM_CB_PATH . 'elements/heading/heading-el.php' );
			include_once( THIM_CB_PATH . 'elements/google-map/google-map-el.php' );
			include_once( THIM_CB_PATH . 'elements/skills-bar/skills-bar-el.php' );
			include_once( THIM_CB_PATH . 'elements/icon-box/icon-box-el.php' );
			include_once( THIM_CB_PATH . 'elements/button/button-el.php' );
			include_once( THIM_CB_PATH . 'elements/count-down/count-down-el.php' );
			include_once( THIM_CB_PATH . 'elements/image-box/image-box-el.php' );
			include_once( THIM_CB_PATH . 'elements/scroll-heading/scroll-heading-el.php' );
			include_once( THIM_CB_PATH . 'elements/testimonials/testimonials-el.php' );
			include_once( THIM_CB_PATH . 'elements/counter-box/counter-box-el.php' );
			include_once( THIM_CB_PATH . 'elements/steps/steps-el.php' );
			include_once( THIM_CB_PATH . 'elements/video-box/video-box-el.php' );
			include_once( THIM_CB_PATH . 'elements/post-block-1/post-block-1-el.php' );
			include_once( THIM_CB_PATH . 'elements/photo-wall/photo-wall-el.php' );
			include_once( THIM_CB_PATH . 'elements/user-info/user-info-el.php' );
			include_once( THIM_CB_PATH . 'elements/features-list/features-list-el.php' );
			include_once( THIM_CB_PATH . 'elements/login-form/login-form-el.php' );
			include_once( THIM_CB_PATH . 'elements/gallery-carousel/gallery-carousel-el.php' );
			include_once( THIM_CB_PATH . 'elements/pricing/pricing-el.php' );
			include_once( THIM_CB_PATH . 'elements/introduction-box/introduction-box-el.php' );
			include_once( THIM_CB_PATH . 'elements/text-box/text-box-el.php' );
			include_once( THIM_CB_PATH . 'elements/gallery/gallery-el.php' );
			include_once( THIM_CB_PATH . 'elements/posts/posts-el.php' );
			include_once( THIM_CB_PATH . 'elements/new-iconbox/new-iconbox-el.php' );
			include_once( THIM_CB_PATH . 'elements/new-post/new-post-el.php' );
			include_once( THIM_CB_PATH . 'elements/new-image-box/new-image-box-el.php' );
			include_once( THIM_CB_PATH . 'elements/new-video/new-video-el.php' );
//			include_once( THIM_CB_PATH . 'elements/register-form/register-form-el.php' );
//
//			// Shortcodes for LearnPress
			if ( class_exists( 'LearnPress' ) ) {
				include_once( THIM_CB_PATH . 'elements/enroll-course/enroll-course-el.php' );
				include_once( THIM_CB_PATH . 'elements/courses-carousel/courses-carousel-el.php' );
				include_once( THIM_CB_PATH . 'elements/course-search/course-search-el.php' );
				include_once( THIM_CB_PATH . 'elements/courses-block-1/courses-block-1-el.php' );
				include_once( THIM_CB_PATH . 'elements/courses-block-2/courses-block-2-el.php' );
				include_once( THIM_CB_PATH . 'elements/courses-block-3/courses-block-3-el.php' );
				include_once( THIM_CB_PATH . 'elements/courses-block-4/courses-block-4-el.php' );
				include_once( THIM_CB_PATH . 'elements/courses-megamenu/courses-megamenu-el.php' );
			}

			if ( class_exists( 'LP_Co_Instructor_Preload' ) ) {
				include_once( THIM_CB_PATH . 'elements/instructors/instructors-el.php' );
				include_once( THIM_CB_PATH . 'elements/new-instructor/new-instructor-el.php' );
			}

			if ( class_exists( 'LP_Addon_Course_Review' ) ) {
				include_once( THIM_CB_PATH . 'elements/review-course/review-course-el.php' );
			}

			// Shortcodes for WP Events Manager
			if ( class_exists( 'WPEMS' ) ) {
				include_once( THIM_CB_PATH . 'elements/events/events-el.php' );
			}

			// Shortcodes for LearnPress Collections
			if ( class_exists( 'LP_Addon_Collections' ) ) {
				include_once( THIM_CB_PATH . 'elements/courses-collection/courses-collection-el.php' );
			}

			// Shortcodes for Portfolio
			if ( class_exists( 'Thim_Portfolio' ) ) {
				include_once( THIM_CB_PATH . 'elements/portfolio/portfolio-el.php' );
			}

		}

		/**
		 * Load functions.
		 *
		 * @since 1.0.0
		 */
		public function init() {

			include_once( THIM_CB_PATH . 'inc/demo-data-config.php' );

			include_once( THIM_CB_PATH . 'inc/functions.php' );

			include_once( THIM_CB_PATH . 'inc/learnpress.php' );
		}

		/**
		 * Create custom param number
		 *
		 * @param $settings
		 * @param $value
		 *
		 * @return string
		 * @since 1.0.0
		 */
		public function param_number( $settings, $value ) {
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type'] ) ? $settings['type'] : '';
			$min        = isset( $settings['min'] ) ? $settings['min'] : '';
			$max        = isset( $settings['max'] ) ? $settings['max'] : '';
			$suffix     = isset( $settings['suffix'] ) ? $settings['suffix'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$value      = isset( $value ) ? $value : $settings['value'];
			$output     = '<input type="number" min="' . $min . '" max="' . $max . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" style="max-width:100px; margin-right: 10px;" />' . $suffix;

			return $output;
		}


		/**
		 * Generate param type "radioimage"
		 *
		 * @param $settings
		 * @param $value
		 *
		 * @return string
		 */
		function param_radioimage( $settings, $value ) {
			$dependency = '';
			$dependency = function_exists( 'vc_generate_dependencies_attributes' ) ? vc_generate_dependencies_attributes( $settings ) : '';
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type'] ) ? $settings['type'] : '';
			$radios     = isset( $settings['options'] ) ? $settings['options'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$output     = '<input type="hidden" name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . '_field ' . $class . '" value="' . $value . '"  ' . $dependency . ' />';
			$output     .= '<div id="' . $param_name . '_wrap" class="icon_style_wrap ' . $class . '" >';
			if ( $radios != '' && is_array( $radios ) ) {
				$i = 0;
				foreach ( $radios as $key => $image_url ) {
					$class   = ( $key == $value ) ? ' class="selected" ' : '';
					$image   = '<img id="' . $param_name . $i . '_img' . $key . '" src="' . $image_url . '" ' . $class . '/>';
					$checked = ( $key == $value ) ? ' checked="checked" ' : '';
					$output  .= '<input name="' . $param_name . '_option" id="' . $param_name . $i . '" value="' . $key . '" type="radio" '
					            . 'onchange="document.getElementById(\'' . $param_name . '\').value=this.value;'
					            . 'jQuery(\'#' . $param_name . '_wrap img\').removeClass(\'selected\');'
					            . 'jQuery(\'#' . $param_name . $i . '_img' . $key . '\').addClass(\'selected\');'
					            . 'jQuery(\'#' . $param_name . '\').trigger(\'change\');" '
					            . $checked . ' style="display:none;" />';
					$output  .= '<label for="' . $param_name . $i . '">' . $image . '</label>';
					$i ++;
				}
			}
			$output .= '</div>';

			return $output;
		}


		/**
		 * @param $settings
		 * @param $value
		 *
		 * @return string
		 */
		public function param_datepicker( $settings, $value ) {
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type'] ) ? $settings['type'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$value      = isset( $value ) ? $value : $settings['value'];
			$output     = '<input type="text" name="' . $param_name . '" class="thim-datetimepicker wpb_vc_param_value ' . $param_name . ' ' . $type . '_field ' . $class . '" value="' . $value . '"  />';
			$output     .= '<script>jQuery(\'.thim-datetimepicker\').datetimepicker();</script>';
			$output     .= '';

			return $output;
		}
		public function thim_vc_dropdown_multiple_form_field( $settings, $value ) {
			$output     = '';
			$css_option = str_replace( '#', 'hash-', vc_get_dropdown_option( $settings, $value ) );
			$output     .= '<select name="'
						   . $settings['param_name']
						   . '" class="wpb_vc_param_value wpb-input wpb-select '
						   . $settings['param_name']
						   . ' ' . $settings['type']
						   . ' ' . $css_option
						   . '" multiple data-option="' . $css_option . '">';
			if ( is_array( $value ) ) {
				$value = isset( $value['value'] ) ? $value['value'] : array_shift( $value );
			}
			if ( ! empty( $settings['value'] ) ) {
				foreach ( $settings['value'] as $index => $data ) {
					if ( is_numeric( $index ) && ( is_string( $data ) || is_numeric( $data ) ) ) {
						$option_label = $data;
						$option_value = $data;
					} elseif ( is_numeric( $index ) && is_array( $data ) ) {
						$option_label = isset( $data['label'] ) ? $data['label'] : array_pop( $data );
						$option_value = isset( $data['value'] ) ? $data['value'] : array_pop( $data );
					} else {
						$option_value = $data;
						$option_label = $index;
					}
					$selected            = '';
					$option_value_string = (string) $option_value;
					$value_string        = (string) $value;
					if ( '' !== $value && $option_value_string === $value_string ) {
						$selected = ' selected="selected"';
					}
					$option_class = str_replace( '#', 'hash-', $option_value );
					$output       .= '<option class="' . esc_attr( $option_class ) . '" value="' . esc_attr( $option_value ) . '"' . $selected . '>'
									 . htmlspecialchars( $option_label ) . '</option>';
				}
			}
			$output .= '</select>';
		
			return $output;
		}
		
		public function thim_add_extra_vc_params() {
			vc_add_shortcode_param( 'number', array( $this, 'param_number' ) );
			vc_add_shortcode_param( 'radio_image', array( $this, 'param_radioimage' ) );
			vc_add_shortcode_param( 'datepicker', array( $this, 'param_datepicker' ) );
			vc_add_shortcode_param( 'dropdown_multiple', array( $this, 'thim_vc_dropdown_multiple_form_field' ) );
		}

		/**
		 * Register assets
		 * @author Khoapq
		 */
		public function register_assets() {
			wp_register_style( 'thim-wplms-datetimepicker', THIM_CB_URL . 'assets/css/jquery.datetimepicker.min.css' );
			wp_register_script( 'thim-wplms-datetimepicker', THIM_CB_URL . 'assets/js/libs/jquery.datetimepicker.full.min.js', array( 'jquery', ), '', true );

		}

		function admin_elementor_enqueue_assets() {
			wp_enqueue_style( 'thim-admin-icon-sc', THIM_CB_URL . 'assets/css/admin-icon.css' );
		}

		/**
		 * Enqueue assets
		 * @author Khoapq
		 */
		public function admin_enqueue_assets() {

			/**
			 * Check conflict with WP Events Manager by ThimPress
			 */
			wp_dequeue_script( 'wpems-admin-datetimepicker-full' );
			wp_dequeue_style( 'wpems-admin-datetimepicker-min' );

			/**
			 * Enqueue assets
			 */
			wp_enqueue_style( 'thim-wplms-datetimepicker' );
			wp_enqueue_style( 'jquery' );
			wp_enqueue_script( 'thim-wplms-datetimepicker' );

		}

	}

	new Thim_Course_Builder();
}

if ( ! function_exists( "thim_get_cat_courses" ) ) {
	function thim_get_cat_courses( $term = 'category', $show_all = '', $el = false ) {
		$args  = array(
			'pad_counts'   => 1,
			'hierarchical' => 1,
			'hide_empty'   => 1,
			'orderby'      => 'name',
			'menu_order'   => false
		);
		$terms = get_terms( $term, $args );
		$cats  = array();
		if ( $el == true ) {
			if ( $show_all ) {
				$cats['all'] = $show_all;
			}
		} else {
			if ( $show_all ) {
				$cats[ $show_all ] = 'all';
			}
		}
		if ( is_wp_error( $terms ) ) {
		} else {
			if ( empty( $terms ) ) {
			} else {
				foreach ( $terms as $term ) {
					if ( $el == true ) {
						$cats[ $term->term_id ] = $term->name;
					} else {
						$cats[ $term->name ] = $term->term_id;
					}
				}
			}
		}

		return $cats;
	}
}
