<?php
/**
 * Header Mobile Menu Template
 *
 * @package Thim_Starter_Theme
 */
$login = '';
if ( is_user_logged_in() ) {
	$login = 'logined';
}
?>

<div class="inner-off-canvas">
	<div class="menu-mobile-effect navbar-toggle" data-effect="mobile-effect">
		<?php esc_html_e( 'Close', 'course-builder' ); ?> <i class="fa fa-times" aria-hidden="true"></i>
	</div>

	<div class="thim-mobile-search-cart <?php if ( ! class_exists( 'WC_Widget_Cart' ) ) {
		echo 'no-cart';
	} ?>">
        <?php
        if ( get_theme_mod( 'search_text_on_header' ) ) {
	        $custom_search = get_theme_mod( 'search_text_on_header' );
        } else {
	        $custom_search = 'What are you looking for ?';
        }
        ?>
		<div class="thim-search-wrapper hidden-lg-up">
            <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
                <input type="search" class="search-field"
                       placeholder="<?php echo esc_attr( $custom_search ) ?>"
                       value="<?php echo get_search_query() ?>" name="s"
                       title="<?php echo esc_attr__( 'Search for:', 'course-builder' ) ?>" />
                <button type="submit" class="search-submit"><span class="ion-android-search"></span></button>
            </form>
		</div>
		<?php if ( class_exists( 'WC_Widget_Cart' ) ) { ?>
			<div class="thim-mini-cart hidden-lg-up">
				<?php the_widget( 'Thim_Custom_WC_Widget_Cart' ); ?>
			</div>
		<?php } ?>
	</div>

	<ul class="nav navbar-nav">
		<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'items_wrap'     => '%3$s'
			) );
		} else {
			echo '<li class="alert alert-danger">';
			echo esc_html__( 'To set which menu will appear, navigate to Appearance > Menus > Manage Locations and set your desired menu in the Primary Menu.', 'course-builder' );
			echo '</li>';
		}
		?>
	</ul>

	<div class="off-canvas-widgetarea">
		<?php dynamic_sidebar( 'off_canvas_menu' ); ?>
	</div>
</div>