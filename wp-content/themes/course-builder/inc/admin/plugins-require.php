<?php
if( !function_exists('thim_get_all_plugins_require') ) {
	function thim_get_all_plugins_require( $plugins ) {
		$plugins = array(
			array(
				'name'     => 'LearnPress',
				'slug'     => 'learnpress',
				'required' => true,
			),
			array(
				'name'     => 'Thim Course Builder',
				'slug'     => 'thim-course-builder',
				'premium'  => true,
 				'required' => true,
			),

			array(
				'name'     => 'Widget Logic',
				'slug'     => 'widget-logic',
				'premium'  => false,
				'required' => true,
			),

			array(
				'name'        => 'LearnPress Certificates',
				'slug'        => 'learnpress-certificates',
				'premium'     => true,
				'required'    => false,
				'icon'        => 'https://plugins.thimpress.com/downloads/images/learnpress-certificates.png',
				'description' => 'An addon for LearnPress plugin to create certificate for a course By ThimPress.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress - Coming Soon Courses',
				'slug'        => 'learnpress-coming-soon-courses',
				'premium'     => true,
				'required'    => false,
				'description' => 'Set a course is "Coming Soon" and schedule to public.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress Co-Instructors',
				'slug'        => 'learnpress-co-instructor',
				'premium'     => true,
				'required'    => false,
				'icon'        => 'https://plugins.thimpress.com/downloads/images/learnpress-co-instructor.png',
				'description' => 'Building courses with other instructors By ThimPress.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress Collections',
				'slug'        => 'learnpress-collections',
				'premium'     => true,
				'required'    => false,
				'icon'        => 'https://plugins.thimpress.com/downloads/images/learnpress-collections.png',
				'description' => 'Collecting related courses into one collection by administrator By ThimPress.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress - Content Drip',
				'slug'        => 'learnpress-content-drip',
				'premium'     => true,
				'required'    => false,
				'description' => 'Decide when learners will be able to access the lesson content.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress Course Review',
				'slug'        => 'learnpress-course-review',
				'required'    => false,
				'description' => 'Adding review for course By ThimPress.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress – Export Import',
				'slug'        => 'learnpress-import-export',
				'required'    => false,
				'description' => 'Export/Import courses along with their lessons and quizzes.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress Fill in Blank Question',
				'slug'        => 'learnpress-fill-in-blank',
				'required'    => false,
				'description' => 'Create fill-in-blank question type.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress - Authorize.net Payment',
				'slug'        => 'learnpress-authorizenet-payment',
				'premium'     => true,
				'required'    => false,
				'version'     => '3.0',
				'description' => 'Payment Authorize.net for LearnPress.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress - Gradebook',
				'slug'        => 'learnpress-gradebook',
				'premium'     => true,
				'required'    => false,
				'description' => 'Adding Course Gradebook for LearnPress.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress - Instructor Commission',
				'slug'        => 'learnpress-commission',
				'premium'     => true,
				'required'    => false,
				'description' => 'Commission add-on for LearnPress.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress - myCred Integration',
				'slug'        => 'learnpress-mycred',
				'premium'     => true,
				'required'    => false,
				'description' => 'Running with the point management system - myCred.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress – Offline Payment',
				'slug'        => 'learnpress-offline-payment',
				'required'    => false,
				'description' => 'Transaction can be done offline if other payment gateways are not available.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress - Paid Membership Pro',
				'slug'        => 'learnpress-paid-membership-pro',
				'premium'     => true,
				'required'    => false,
				'icon'        => 'https://plugins.thimpress.com/downloads/images/learnpress-paid-membership-pro.png',
				'description' => 'Paid Membership Pro add-on for LearnPress By ThimPress.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress – Prerequisites Courses',
				'slug'        => 'learnpress-prerequisites-courses',
				'required'    => false,
				'description' => 'Allow instructor to set prerequisite courses for a certain course.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress BuddyPress Integration',
				'slug'        => 'learnpress-buddypress',
				'required'    => false,
				'version'     => '3.0',
				'description' => 'You can view the courses you have taken, finished or wanted to learn inside of wonderful profile page of BuddyPress with LearnPress buddyPress plugin.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress - Randomize Quiz Questions',
				'slug'        => 'learnpress-random-quiz',
				'premium'     => true,
				'required'    => false,
				'description' => 'Mix all available questions in a quiz.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress - Sorting Choice Question',
				'slug'        => 'learnpress-sorting-choice',
				'premium'     => true,
				'required'    => false,
				'description' => 'Sorting Choice provide ability to sorting the options of a question to the right order.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress bbPress',
				'slug'        => 'learnpress-bbpress',
				'required'    => false,
				'version'     => '3.0',
				'description' => 'Using the forum for courses provided by bbPress By ThimPress.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress – 2Checkout Payment',
				'slug'        => 'learnpress-2checkout-payment',
				'premium'     => true,
				'required'    => false,
				'description' => '2checkout payment gateway for LearnPress.',
				'add-on'      => true,
			),

			array(
				'name'        => 'LearnPress - Stripe Payment',
				'slug'        => 'learnpress-stripe',
				'premium'     => true,
				'required'    => false,
				'description' => 'Stripe payment gateway for LearnPress.',
				'add-on'      => true,
			),

			array(
				'name'        => 'LearnPress - Students List	',
				'slug'        => 'learnpress-students-list',
				'premium'     => true,
				'required'    => false,
				'description' => 'Get students list by filters.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress Wishlist',
				'slug'        => 'learnpress-wishlist',
				'required'    => false,
				'description' => 'Wishlist feature By ThimPress.',
				'add-on'      => true,
			),
			array(
				'name'        => 'LearnPress - WooCommerce Payment Methods Integration',
				'slug'        => 'learnpress-woo-payment',
				'premium'     => true,
				'required'    => false,
				'icon'        => 'https://plugins.thimpress.com/downloads/images/learnpress-woo-payment.png',
				'description' => 'Support paying for a booking with the payment methods provided by Woocommerce.',
				'add-on'      => true,
			),
			array(
				'name'        => 'WP Events Manager - WooCommerce Payment ',
				'slug'        => 'wp-events-manager-woo-payment',
				'premium'     => true,
				'required'    => false,
				'version'     => '2.2',
				'description' => 'Support paying for a booking with the payment methods provided by Woocommerce',
				'add-on'      => true,
			),
			array(
				'name'     => 'WPBakery Visual Composer',
				'slug'     => 'js_composer',
				'premium'  => true,
				'required' => true,
			),
			array(
				'name'        => 'Elementor Page Builder',
				'slug'        => 'elementor',
				'required'    => false,
				'description' => 'The most advanced frontend drag & drop page builder. Create high-end, pixel perfect websites at record speeds. Any theme, any page, any design.',
			),

			array(
				'name'        => 'Anywhere Elementor',
				'slug'        => 'anywhere-elementor',
				'required'    => false,
				'description' => 'Allows you to insert elementor pages and library templates anywhere using shortcodes.',
				'add-on'      => true,
			),
			array(
				'name'     => 'WooCommerce',
				'slug'     => 'woocommerce',
				'required' => false,
			),
			array(
				'name'     => 'Contact Form 7',
				'slug'     => 'contact-form-7',
				'required' => false,
			),
			array(
				'name'     => 'WP Events Manager',
				'slug'     => 'wp-events-manager',
				'required' => false,
			),
			array(
				'name'     => 'Paid Memberships Pro',
				'slug'     => 'paid-memberships-pro',
				'required' => false,
			),
			array(
				'name'     => 'WordPress Social Login',
				'slug'     => 'wordpress-social-login',
				'required' => false,
			),

			array(
				'name'     => 'MailChimp for WordPress',
				'slug'     => 'mailchimp-for-wp',
				'required' => false,
			),

			array(
				'name'        => 'bbPress',
				'slug'        => 'bbpress',
				'required'    => false,
				'description' => 'bbPress is forum software with a twist from the creators of WordPress. By The bbPress Community.',
			),

			array(
				'name'        => 'Thim Portfolio',
				'slug'        => 'tp-portfolio',
				'premium'     => true,
				'required'    => false,
				'icon'        => 'https://plugins.thimpress.com/downloads/images/thim-portfolio.png',
				'version'     => '1.6',
				'description' => 'A plugin that allows you to show off your portfolio. By ThimPress.',
			),

			array(
				'name'    => 'Slider Revolution',
				'slug'    => 'revslider',
				'premium' => true,
				'version' => '6.1.0',
			),
		);

		return $plugins;
	}
}

add_filter( 'thim_core_get_all_plugins_require', 'thim_get_all_plugins_require' );


function thim_envato_item_id() {
	return '20370918';
}

add_filter( 'thim_envato_item_id', 'thim_envato_item_id' );

add_filter( 'thim_core_plugin_icon_install', 'thim_custom_plugin_icon', 10, 2 );
if ( ! function_exists( 'thim_custom_plugin_icon' ) ) {
	function thim_custom_plugin_icon( $icon, $plugin ) {
		if ( $plugin->get_slug() == 'anywhere-elementor' ) {
			$icon = 'https://ps.w.org/' . $plugin->get_slug() . '/assets/icon-128x128.jpg';
		}

		return $icon;
	}
}
