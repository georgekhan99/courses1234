<?php

/**
 * Set Default value when theme option not save at first time setup
 *
 */
/**
 * Set Default value when theme option not save at first time setup
 *
 */

if ( is_page_template( 'templates/home-page.php' ) || is_page_template( 'templates/home-page-2.php' ) ||
     is_page_template( 'templates/page-default.php' ) || is_page_template( 'page-templates/landing-no-footer.php' ) ||
     is_page_template( 'elementor_canvas' ) ) {
	$file = thim_template_path();
	include $file;

	return;
} else {
	$file = thim_template_path();
	get_header();
	?>
    <section class="content-area">
		<?php
		get_template_part( 'templates/page-title/page', 'title' );

		do_action( 'thim_wrapper_loop_start' );
		include $file;
		do_action( 'thim_wrapper_loop_end' );
		?>
    </section>
	<?php
	get_footer();
}
