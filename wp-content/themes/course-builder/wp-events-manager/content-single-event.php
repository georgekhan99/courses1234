<?php

if ( empty(get_theme_mod( 'event_group_sharing' )) ) {
    $class = 'no-social';
} else {
    $class = 'has-social';
}

?>

<article id="tp_event-<?php the_ID(); ?>" <?php post_class( 'tp_single_event' ); ?>>

	<?php
	/**
	 * tp_event_single_event_thumbnail hook
	 */
	do_action( 'tp_event_single_event_thumbnail' );

	?>

	<div class="summary entry-summary <?php echo esc_attr($class)?>">

        <?php if ( !empty(get_theme_mod( 'event_group_sharing' )) ) { ?>
            <div class="sticky-sidebar">
                <?php thim_social_share( 'event_' ); ?>
            </div>
        <?php }; ?>

		<div class="entry-right">
			<?php
			/**
			 * tp_event_before_single_event hook
			 *
			 */
			do_action( 'tp_event_before_single_event' );

			/**
			 * tp_event_loop_event_countdown hook
			 */
			do_action( 'tp_event_loop_event_countdown' );

			/**
			 * tp_event_single_event_content hook
			 */
			do_action( 'tp_event_single_event_content' );

			/**
			 * tp_event_loop_event_location hook
			 */
			do_action( 'tp_event_loop_event_location' );

			?>
		</div>
	</div><!-- .summary -->


</article><!-- #product-<?php the_ID(); ?> -->