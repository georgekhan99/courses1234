<?php
/**
 * Template for displaying content and items of section in single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/section/content.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if ( ! isset( $section ) ) {
	return;
}

$user   = LP_Global::user();
$course = LP()->global['course'];
?>

<?php if ( $items = $section->get_items() ) { ?>

    <ul class="section-content">

		<?php foreach ( $items as $item ) { ?>

            <li class="<?php echo join( ' ', $item->get_class() ); ?>" data-type="<?php echo $item->get_item_type(); ?>">
				<?php

				$post_type = str_replace( 'lp_', '', $item->get_item_type() );
				if ( empty( $count[$post_type] ) ) {
					$count[$post_type] = 1;
				} else {
					$count[$post_type] ++;
				}

				if ( $item->is_visible() ) {
					/**
					 * @since 3.0.0
					 */
					do_action( 'learn-press/begin-section-loop-item', $item );

					?>

                    <div class="meta-rank">
						<?php  ?>

						<?php if ( $item->get_item_type() == 'lp_quiz' ) { ?>
                            <div class="rank"><?php echo '<span class="label">' . esc_html__( 'Quiz', 'course-builder' ) . '</span>' . $section->position . '.' . $count[ $post_type ]; ?></div>
						<?php } elseif ( $item->get_item_type() == 'lp_assignment' ) {?>
                            <div class="rank"><?php echo '<span class="label">' . esc_html__( 'Assign', 'course-builder' ) . '</span>' . $section->position . '.' . $count[ $post_type ]; ?></div>
						<?php } else { ?>
                            <div class="rank"><?php echo '<span class="label">' . esc_html__( 'Lecture', 'course-builder' ) . '</span>' . $section->position . '.' . $count[ $post_type ]; ?></div>
						<?php } ?>
                    </div>


					<?php

					if ( $user->can_view_item( $item->get_id() ) ) {
						?>
                        <a class="section-item-link" href="<?php echo $item->get_permalink(); ?>">
							<?php learn_press_get_template( 'single-course/section/content-item.php', array(
								'item'    => $item,
								'section' => $section
							) ); ?>
                        </a>
					<?php } else { ?>
                        <div class="section-item-link">
							<?php learn_press_get_template( 'single-course/section/content-item.php', array(
								'item'    => $item,
								'section' => $section
							) ); ?>
                        </div>
					<?php } ?>

					<?php
					/**
					 * @since 3.0.0
					 */
					do_action( 'learn-press/end-section-loop-item', $item );
				}
				?>

            </li>

		<?php } ?>

    </ul>

<?php } else { ?>

	<?php learn_press_display_message( __( 'No items in this section', 'course-builder' ) ); ?>

<?php } ?>