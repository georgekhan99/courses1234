<?php
/**
 * Template part for displaying single.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 */

if ( empty(get_theme_mod( 'blog_single_group_sharing' )) ) {
    $class = 'no-social';
} else {
    $class = 'has-social';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="content-inner">
		<h1 class="title"><?php the_title(); ?></h1>
		<?php thim_entry_meta(); ?>
		<div class="entry-top">
			<?php
			if ( ( has_post_format() || has_post_thumbnail() ) && ( get_theme_mod( 'blog_single_feature_image', true ) ) ) {
				do_action( 'thim_top_entry', 'full' ); ?>
				<div class="entry-date">
					<?php thim_entry_meta_date(); ?>
				</div>
			<?php } else { ?>
				<div class="entry-date no-thumbnail">
					<?php thim_entry_meta_date(); ?>
				</div>
			<?php } ?>
		</div><!-- .entry-top -->
		<div class="entry-content-wrapper <?php echo esc_attr($class)?>">

            <?php if ( !empty(get_theme_mod( 'blog_single_group_sharing' )) ) { ?>
                <div class="left-content sticky-sidebar">
                    <div class="social-share">
                        <?php thim_social_share(); ?>
                    </div>
                </div>
            <?php }; ?>

			<div class="right-content">
				<div class="entry-content">
					<?php
					if ( has_post_format( 'chat' ) ) {
						thim_get_list_group_chat();
					}
					// Get post content
					the_content();
					?>


				</div><!-- .entry-content -->

				<?php
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'course-builder' ),
						'after'  => '</div>',
					)
				);
				?>

				<?php echo get_the_tag_list( '<div class="tag-list"> <a class="tags">TAGS: </a> ', ' ', '</div>' ); ?>

				<?php if ( get_theme_mod( 'blog_single_author', true ) ) : ?>
					<?php do_action( 'thim_about_author' ); ?>

				<?php endif; ?>


				<?php if ( get_theme_mod( 'blog_single_nav', true ) ) : ?>
					<div class="nav-single">
						<div class="post-nav nav-prev">
							<?php $prev_post = get_previous_post();
							if ( $prev_post ) : ?>
								<div class="icon-nav">
									<?php previous_post_link( '%link', '<i class="ion-ios-arrow-thin-left"></i>' ); ?>
								</div>
								<div class="content-nav text-right">
									<?php previous_post_link( '%link', '<label>' . esc_html__( 'Previous', 'course-builder' ) . '</label>' ); ?>
									<?php previous_post_link( '%link', '<h4 class="post-title">%title</h4>' ); ?>
									<div class="date"><?php echo get_the_date( get_option( 'date_format' ), $prev_post ); ?></div>
								</div>
							<?php endif; ?>
						</div>
						<div class="post-nav nav-next">
							<?php $next_post = get_next_post();
							if ( $next_post ): ?>
								<div class="icon-nav">
									<?php next_post_link( '%link', '<i class="ion-ios-arrow-thin-right"></i>' ); ?>
								</div>
								<div class="content-nav text-left">
									<?php next_post_link( '%link', '<label>' . esc_html__( 'Next', 'course-builder' ) . '</label>' ); ?>
									<?php next_post_link( '%link', '<h4 class="post-title">%title</h4>' ); ?>
									<div class="date"><?php echo get_the_date( get_option( 'date_format' ), $next_post ); ?></div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
				?>

				<?php if ( get_theme_mod( 'blog_single_related_post', true ) ) :
					get_template_part( 'templates/template-parts/related-single' );
				endif; ?>
			</div>

		</div>

	</div><!-- .content-inner -->


</article><!-- #post-## -->