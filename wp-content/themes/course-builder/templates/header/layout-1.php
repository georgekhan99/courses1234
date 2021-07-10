<?php
/**
 * Header V1 Template
 *
 * @package Thim_Starter_Theme
 */
?>

<div class="header-v1 header-wrapper">
	<div class="main-header row">
		<div class="header-left col-lg-3">
			<div class="menu-mobile-effect navbar-toggle" data-effect="mobile-effect">
				<div class="icon-wrap">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</div>
				<div class="text-menu">
					<?php esc_html_e( 'Menu', 'course-builder' ); ?>
				</div>
			</div>
			<?php if ( get_theme_mod( 'menu_right_display' ) ):

				if ( get_theme_mod( 'search_text_on_header' ) ) {
					$custom_search = get_theme_mod( 'search_text_on_header' );
				}

                ?>
				<div class="thim-search-wrapper hidden-md-down">
					<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
						<input type="search" class="search-field"
						       placeholder="<?php echo esc_attr( $custom_search ) ?>"
						       value="<?php echo get_search_query() ?>" name="s" />
						<input type="hidden" name="post_type" value="lp_course">
						<button type="submit" class="search-submit"><span class="ion-android-search"></span>
						</button>
					</form>
				</div>
			<?php endif; ?>
		</div>

		<div class="header-center col-lg-6">
			<div class="width-logo">
				<?php do_action( 'thim_header_logo' ); ?>
				<?php do_action( 'thim_header_sticky_logo' ); ?>
			</div>
		</div>
		<?php if ( get_theme_mod( 'header_sidebar_right_display' ) ): ?>
			<div class="header-right col-lg-3">
				<?php if ( get_theme_mod( 'header_sidebar_right_display', true ) ) : ?>
					<?php dynamic_sidebar( 'header_right' ); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</div>