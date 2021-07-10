<?php
/**
 * Template for displaying collection content within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/collection/content-collection.php.
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

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'learn_press_collections_before_loop_item' ); ?>

	<a href="<?php the_permalink(); ?>" class="collection-title">
		<?php do_action( 'learn_press_collections_loop_item_title' ); ?>
    </a>

	<?php do_action( 'learn_press_collections_after_loop_item' ); ?>

</div>