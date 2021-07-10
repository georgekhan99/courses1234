<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<span class="screen-reader-text"><?php echo esc_html__( 'Search for:', 'course-builder' ) ?></span>
	<input type="search" class="search-field"
		   placeholder="<?php echo esc_attr__( 'What are you looking for ?', 'course-builder' ) ?>"
		   value="<?php echo get_search_query() ?>" name="s"
		   title="<?php echo esc_attr__( 'Search for:', 'course-builder' ) ?>" />
<button type="submit" class="search-submit"><span class="ion-android-search"></span></button>
</form>