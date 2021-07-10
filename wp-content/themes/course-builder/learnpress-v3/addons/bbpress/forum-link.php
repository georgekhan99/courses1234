<?php
/**
 * Template for displaying forum link in single course page.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/bbpress/forum-link.php.
 *
 * @author ThimPress
 * @package LearnPress/bbPress/Templates
 * @version 3.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( learn_press_is_learning_course() ) { ?>
    <a class="learn-press-course-forum-link" href="<?php echo get_permalink( $forum_id ); ?>"><?php echo get_the_title( $forum_id ); ?></a>

<?php } else { ?>

    <li class="list-inline-item item-forum-link">
        <label><?php esc_html_e( 'Connect', 'course-builder' ); ?></label>
        <div class="value">
            <a href="<?php echo get_the_permalink( $forum_id ); ?>"><?php esc_html_e( 'Forum', 'course-builder' ); ?></a>
        </div>
    </li>

<?php }
?>

