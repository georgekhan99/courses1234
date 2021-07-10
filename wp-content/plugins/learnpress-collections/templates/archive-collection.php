<?php
/**
 * Template for displaying archive collection content.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/collection/archive-collection.php.
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

<?php get_header(); ?>

<?php do_action( 'learn_press_before_main_content' ); ?>

<?php if ( apply_filters( 'learn_press_collections_show_page_title', true ) ) { ?>

	<h1 class="page-title">
		<?php learn_press_collections_page_title(); ?>
	</h1>

<?php } ?>

<?php do_action( 'learn_press_collections_archive_description' ); ?>

<?php if ( have_posts() ) : ?>

	<?php do_action( 'learn_press_collections_before_loop' ); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<?php learn_press_collections_get_template( 'content-collection.php' ); ?>

	<?php endwhile; ?>

	<?php do_action( 'learn_press_collections_after_loop' ); ?>

<?php endif; ?>

<?php do_action( 'learn_press_after_main_content' ); ?>

<?php get_footer(); ?>
