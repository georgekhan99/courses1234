<?php

/**
 * Search
 *
 * @package    bbPress
 * @subpackage Theme
 */

?>

<form role="search" method="get" id="bbp-search-form" action="<?php bbp_search_url(); ?>">
	<label class="screen-reader-text hidden" for="bbp_search"><?php esc_html_e( 'Search for:', 'course-builder' ); ?></label>
	<input type="hidden" name="action" value="bbp-search-request" />
	<input tabindex="<?php bbp_tab_index(); ?>" type="text" value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" name="bbp_search" id="bbp_search" placeholder="<?php echo esc_attr__( 'What do you want to find?', 'course-builder' ) ?>" />
	<span class="icon-search">
		<input tabindex="<?php bbp_tab_index(); ?>" class="button" type="submit" id="bbp_search_submit" value="<?php esc_attr_e( 'Search', 'course-builder' ); ?>" />
	</span>
</form>
