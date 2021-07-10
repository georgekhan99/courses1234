<?php
/**
 * Template for displaying tab nav of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/tabs/tabs.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$class_wishlist = '';

$tabs = learn_press_get_course_tabs();

if ( thim_plugin_active( 'learnpress-wishlist/learnpress-wishlist.php' ) || class_exists( 'LP_Addon_Wishlist' ) ) {
	$class_wishlist = 'has-wishlist';
}

if ( empty( $tabs ) ) {
	return;
}

?>

<div id="thim-landing-course-menu-tab"><!--js selector-->
	<div class="container wrapper clearfix">
		<ul class="course-landing-tab">
			<?php foreach ( $tabs as $key => $tab ) { ?>
				<?php
				$classes = array( 'course-nav-tab-' . esc_attr( $key ) );
				if ( !empty( $tab['active'] ) ) {
					$classes[] = 'active';
				}

				if ( $tab['title'] == 'Overview' ) {
					?>
					<li role="presentation" class="<?php echo join( ' ', $classes ); ?>">
						<a href="#<?php echo esc_attr( $tab['id'] ); ?>">
							<?php
							echo esc_html( 'Overview', 'course-builder' );
							?>
						</a>
					</li>
				<?php } elseif ( $tab['title'] == 'Curriculum' ) {
					?>
					<li role="presentation" class="<?php echo join( ' ', $classes ); ?>">
						<a href="#<?php echo esc_attr( $tab['id'] ); ?>">
							<?php
							echo esc_html( 'Curriculum', 'course-builder' );
							?>
						</a>
					</li>
					<?php
				} elseif ( $tab['title'] == 'Instructor' ) {
					?>
					<li role="presentation" class="<?php echo join( ' ', $classes ); ?>">
						<a href="#<?php echo esc_attr( $tab['id'] ); ?>">
							<?php
							echo esc_html( 'Instructor', 'course-builder' );
							?>
						</a>
					</li>
				<?php } else { ?>
					<li role="presentation" class="<?php echo join( ' ', $classes ); ?>">
						<a href="#<?php echo esc_attr( $tab['id'] ); ?>"><?php echo $tab['title']; ?></a>
					</li>
				<?php }
				?>
			<?php } ?>
		</ul>

		<div class="course-purchase-info <?php echo esc_attr( $class_wishlist ) ?>">
			<?php do_action( 'thim_lp_landing_course_tab' ); ?>
		</div>
	</div>
</div>