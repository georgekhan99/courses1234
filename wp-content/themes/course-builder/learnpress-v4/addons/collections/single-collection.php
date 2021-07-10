<?php
/**
 * The template for displaying single collection.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/collection/single-collection.php.
 *
 * @author  ThimPress
 * @package LearnPress/Collections/Templates
 * @version 3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>

<?php do_action( 'learn_press_before_main_content' ); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php learn_press_collections_get_template( 'content-single-collection.php' ); ?>

<?php endwhile; ?>

<?php do_action( 'learn_press_after_main_content' ); ?>

