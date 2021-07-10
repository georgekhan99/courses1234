<?php
/**
 * Template for displaying price of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/price.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$user   = LP_Global::user();
$course = LP_Global::course();
if ( ! $course ) {
	return;
}
$is_buy_through_membership = false;
if ( class_exists( 'LP_Addon_PMPRO' ) ) {
	$is_buy_through_membership = LP()->settings->get( 'buy_through_membership' ) == 'yes' ? true : false;
}
$is_course_in_membership = (bool) get_post_meta( $course->get_id(), '_lp_pmpro_levels', false );

if ( learn_press_is_enrolled_course() || ( $is_buy_through_membership && $is_course_in_membership ) ) {
	return;
}

if ( ! $price = $course->get_price_html() ) {
	return;
}

?>

<?php if ( $course->has_sale_price() ) { ?>

    <span class="course-origin-price"> <?php echo $course->get_origin_price_html(); ?></span>

<?php } ?>

<?php echo '<span class="course-price">' . $price . '</span>';?>

