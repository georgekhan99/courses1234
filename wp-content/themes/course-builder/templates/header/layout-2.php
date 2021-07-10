<?php
/**
 * Header v2 Template
 *
 * @package Thim_Starter_Theme
 */
?>

<div class="header-wrapper header-v2 <?php echo get_theme_mod( 'header_v2_style', 'default' ); ?>">
	<div class="main-header <?php if ( get_theme_mod( 'header_v2_style', 'default' ) != 'style_kit' ) {
		echo 'container';
	} ?>">
		<div class="menu-mobile-effect navbar-toggle" data-effect="mobile-effect">
			<div class="icon-wrap">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</div>
		</div>

		<div class="width-logo">
			<?php do_action( 'thim_header_logo' ); ?>
			<?php do_action( 'thim_header_sticky_logo' ); ?>
		</div>

		<?php if ( get_theme_mod( 'header_v2_style', 'default' ) == 'style2' && get_theme_mod( 'menu_right_display' ) == true ):

			if ( get_theme_mod( 'search_text_on_header' ) ) {
				$custom_search = get_theme_mod( 'search_text_on_header' );
			} else {
				$custom_search = 'What are you looking for ?';
			}

			?>
			<div class="thim-search-wrapper hidden-md-down">
				<form role="search" method="get" class="search-form active" action="<?php echo home_url( '/' ); ?>">
					<input type="search" class="search-field"
						   placeholder="<?php echo esc_attr( $custom_search ) ?>"
						   value="<?php echo get_search_query() ?>" name="s" />
					<input type="hidden" name="post_type" value="lp_course">
					<button type="submit" class="search-submit"><span class="ion-android-search"></span>
					</button>
				</form>
			</div>
		<?php endif; ?>

		<div class="width-navigation">
			<?php get_template_part( 'templates/header/main-menu' ); ?>
			<?php if ( get_theme_mod( 'header_v2_style', 'default' ) != 'style_kit' ) {
				if ( get_theme_mod( 'header_sidebar_right_display', true ) ) : ?>
					<div class="header-right">
						<?php dynamic_sidebar( 'header_right' ); ?>
					</div>
				<?php endif; ?>
			<?php } ?>
		</div>

		<?php if ( get_theme_mod( 'header_v2_style', 'default' ) == 'style_kit' ) {
			if ( get_theme_mod( 'header_sidebar_right_display', true ) ) : ?>
				<div class="header-right">
					<?php dynamic_sidebar( 'header_right' ); ?>
				</div>
			<?php endif;
		} ?>
	</div>
</div>