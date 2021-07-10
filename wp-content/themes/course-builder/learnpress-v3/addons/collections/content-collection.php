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
global $thim_options;
$columns = '';
$thim_options = get_theme_mods();

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( isset( $thim_options['collection_archive_columns'] ) && get_theme_mod( 'collection_archive_columns' ) <> '' ) {
    $columns = 12 / get_theme_mod( 'collection_archive_columns' );
}

?>
<div id="post-<?php the_ID(); ?>" <?php post_class( 'col-sm-'. $columns ); ?>>

    <div class="content">
        <?php do_action( 'learn_press_collections_before_loop_item' ); ?>

        <div class="thumb">
            <?php
            if ( has_post_thumbnail() ) {
                thim_thumbnail( get_the_ID(), '480x360' );
            }
            ?>
        </div>

        <div class="text">
            <a href="<?php the_permalink(); ?>" class="title">
                <?php do_action( 'learn_press_collections_loop_item_title' ); ?>
            </a>

            <?php do_action( 'learn_press_collections_after_loop_item' ); ?>
        </div>

    </div>


</div>


