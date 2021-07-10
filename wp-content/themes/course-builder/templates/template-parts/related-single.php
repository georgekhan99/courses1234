<?php
/**
 * Related Post
 *
 */

$related = thim_get_related_posts();

$thumb       = false;
$thumb_class = 'no-thumbnail';


if ( $related->have_posts() ) {
	?>
	<section class="related-archive">
		<h3 class="related-title"><?php esc_html_e( 'You Might Also Like', 'course-builder' ); ?></h3>
		<div class="related-carousel owl-carousel owl-theme">
			<?php while ( $related->have_posts() ) : $related->the_post(); ?>
				<div class="item">
					<?php
					if ( has_post_thumbnail() ) {
						$thumb       = true;
						$thumb_class = 'has-thumbnail';
					}
					?>
					<?php if ( $thumb ) : ?>
						<div class="thumbnail-wrapper <?php echo esc_attr( $thumb_class ); ?>">
							<?php thim_thumbnail( get_the_ID(), '280x190', 'post', false, 'no-lazy' ); ?>
							<div class="entry-date">
								<?php thim_entry_meta_date(); ?>
							</div>
						</div>
					<?php endif; ?>
					<div class="rel-post-text">
						<a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
							<h5 class="entry-title"><?php the_title(); ?></h5>
						</a>
						<div class="entry-meta">
							<?php thim_entry_meta_author(); ?>
							<?php thim_entry_meta_comment_number(); ?>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
	</section><!--.related-->
	<?php
}
wp_reset_postdata();