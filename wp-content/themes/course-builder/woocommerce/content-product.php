<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop, $thim_options, $post;
$thim_options = get_theme_mods();


// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop'] ++;
$column_product = 12 / $woocommerce_loop['columns'];

// Columns in customize effect for archive page.
if ( is_archive() && isset( $thim_options['woocommerce_product_column'] ) && get_theme_mod( 'woocommerce_product_column' ) <> '' ) {
	$column_product = 12 / get_theme_mod( 'woocommerce_product_column' );
}

// Extra post classes
$classes   = array();
$classes[] = 'col-xs-6 col-md-' . $column_product . ' col-sm-6';
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
}
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
	$classes[] = 'last';
}
$classes[] = 'product-card';
?>
<li <?php post_class($classes); ?>>
	<?php
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );
	?>
	<div class="wrapper">
		<div class="feature-image">
			<?php

			/**
			 * woocommerce_before_shop_loop_item_title hook.
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );

			if ( get_theme_mod( 'enable_product_quickview', true ) ) :
				wp_enqueue_script( 'magnific-popup' );
				wp_enqueue_script( 'flexslider' );
				wp_enqueue_script( 'variations' );
				echo '<div class="quick-view" data-prod="' . esc_attr( get_the_ID() ) . '"><span><i class="fa fa-search"></i></span></div>';
			endif;

			?>
		</div><!-- .feature-image -->
        <div class="product-content">
            <div class="title-product">
                <a href="<?php the_permalink(); ?>" class="product_name"><?php the_title(); ?></a>
            </div><!-- .title-product -->
			<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
			?>
            <div class="description ">
				<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
            </div><!-- .description -->
			<?php
			/**
			 * woocommerce_after_shop_loop_item hook
			 *
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item' );
			?>
        </div><!-- .box-title -->
	</div>
	<div class="clear"></div>
</li>
