<?php
/**
 * custom WC_Widget_Cart
 *
 **/
function thim_get_current_cart_info() {
	global $woocommerce;
	if ( is_object($woocommerce->cart) ) {
        $items = count( $woocommerce->cart->get_cart() );

        return array(
            $items,
            get_woocommerce_currency_symbol()
        );
	}

}

add_filter( 'woocommerce_add_to_cart_fragments', 'thim_add_to_cart_success_ajax' );
function thim_add_to_cart_success_ajax( $count_cat_product ) {
	list( $cart_items ) = thim_get_current_cart_info();
	if ( $cart_items < 0 ) {
		$cart_items = '0';
	}

	$count_cat_product['#header-mini-cart .cart-items-number .items-number'] = '<span class="items-number">' . $cart_items . '</span>';

	return $count_cat_product;
}

add_action( 'widgets_init', 'thim_override_woocommerce_widgets', 15 );
function thim_override_woocommerce_widgets() {
	if ( class_exists( 'WC_Widget_Cart' ) ) {
		unregister_widget( 'WC_Widget_Cart' );
		include_once( 'widgets/class-wc-widget-cart.php' );
		register_widget( 'Thim_Custom_WC_Widget_Cart' );
	}
}

/**
 * Woocommerce: Add, remove, override hooks, templates.
 *
 */

// Remove hooks archive page
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
// Remove hooks single page
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

// Get number of product per page
/**
 * Get switch icon on product filter
 *
 * @return number
 */
function thim_loop_product_per_page() {
	$thim_options = get_theme_mods();
	parse_str( $_SERVER['QUERY_STRING'], $params );
	if ( isset( $thim_options['woocommerce_product_per_page'] ) && get_theme_mod( 'woocommerce_product_per_page' ) ) {
		$per_page = get_theme_mod( 'woocommerce_product_per_page' );
	} else {
		$per_page = 9;
	}
	$pc = ! empty( $params['product_count'] ) ? $params['product_count'] : $per_page;

	return $pc;
}

add_filter( 'loop_shop_per_page', 'thim_loop_product_per_page' );

/**
 * Get switch icon on product filter
 *
 * @return string
 */
if ( ! function_exists( 'thim_woocommerce_product_filter' ) ) {
	function thim_woocommerce_product_filter() {
		echo '<div class="display grid-list-switch" data-cookie="product-switch" data-layout="grid">
					<a href="javascript:;" class="grid switchToGrid"><i class="fa fa-th"></i></a>
					<a href="javascript:;" class="list switchToList"><i class="fa fa-th-list"></i></a>
				</div>';
	}
}
add_action( 'woocommerce_before_shop_loop', 'thim_woocommerce_product_filter', 15 );

/**
 * Get woocommerce sorting options
 *
 * @return string
 */
if ( ! function_exists( 'thim_woocommerce_catalog_ordering' ) ) {
	function thim_woocommerce_catalog_ordering() {
		global $wp_query;

		if ( 1 === $wp_query->found_posts || ! woocommerce_products_will_display() ) {
			return;
		}

		$orderby                 = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
		$show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
		$catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
			'menu_order' => esc_html__( 'Default sorting', 'course-builder' ),
			'popularity' => esc_html__( 'Sort by popularity', 'course-builder' ),
			'rating'     => esc_html__( 'Sort by average rating', 'course-builder' ),
			'date'       => esc_html__( 'Sort by newness', 'course-builder' ),
			'price'      => esc_html__( 'Sort by price: low to high', 'course-builder' ),
			'price-desc' => esc_html__( 'Sort by price: high to low', 'course-builder' ),
		) );

		if ( ! $show_default_orderby ) {
			unset( $catalog_orderby_options['menu_order'] );
		}

		if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
			unset( $catalog_orderby_options['rating'] );
		}

		wc_get_template( 'loop/orderby.php', array(
			'catalog_orderby_options' => $catalog_orderby_options,
			'orderby'                 => $orderby,
			'show_default_orderby'    => $show_default_orderby
		) );
	}
}
add_action( 'woocommerce_before_shop_loop', 'thim_woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );


// Product quickview
add_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_meta', 7 );
add_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_rating', 15 );
add_action( 'woocommerce_single_product_summary_quick', 'thim_woocommerce_template_loop_add_to_cart_quick_view', 20 );
add_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_excerpt', 30 );
add_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_sharing', 50 );

if ( ! function_exists( 'thim_woocommerce_template_loop_add_to_cart_quick_view' ) ) {
	function thim_woocommerce_template_loop_add_to_cart_quick_view() {
		global $product;
		do_action( 'woocommerce_' . $product->product_type . '_add_to_cart' );
	}
}

add_action( 'wp_ajax_jck_quickview', 'thim_jck_quickview' );
add_action( 'wp_ajax_nopriv_jck_quickview', 'thim_jck_quickview' );
/** The Quickview Ajax Output **/
function thim_jck_quickview() {
	global $post, $product;
	$prod_id = $_POST["product"];
	$post    = get_post( $prod_id );
	$product = wc_get_product( $prod_id );
	// Get category permalink
	ob_start();
	?>
	<?php wc_get_template( 'content-single-product-lightbox.php' ); ?>
	<?php
	$output = ob_get_contents();
	ob_end_clean();
	echo ent2ncr( $output );
	die();
}

// Woocommerce sharing
add_action( 'woocommerce_share', 'thim_social_share' );

// Remove hooks cart page
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

function thim_change_breadcrumb_delimiter( $defaults ) {
	$thim_options = get_theme_mods();
	$icon         = '';
	if ( isset( $thim_options['breadcrumb_icon'] ) ) {
		$icon = html_entity_decode( get_theme_mod( 'breadcrumb_icon' ) );
	}

	// Change the breadcrumb delimeter from '/' to '>'
	$defaults['delimiter'] = '<span class="breadcrum-icon">' . ent2ncr( $icon ) . '</span>';

	return $defaults;
}

add_filter( 'woocommerce_breadcrumb_defaults', 'thim_change_breadcrumb_delimiter' );