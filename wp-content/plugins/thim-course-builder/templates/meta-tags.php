<?php if ( $params['display_author'] === 'yes' ) : ?>
	<?php thim_entry_meta_author(); ?>
<?php endif; ?>

<?php if ( $params['display_date'] === 'yes' )  : ?>
	<span class="date"><?php thim_entry_meta_date( get_the_ID() ); ?></span>
<?php endif; ?>

<?php
if ( $params['display_ratings'] === 'yes' && $params['layout'] != 'layout-list' ) {
	echo thim_get_entry_meta_ratings();
}
?>

	