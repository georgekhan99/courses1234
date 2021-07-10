<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */

$thim_options = get_theme_mods();

$column = isset( $thim_options['archive_post_column'] ) ? get_theme_mod( 'archive_post_column' ) : 1;
$class  = 'column-' . $column . ' col-md-' . ( 12 / $column );

if ( isset( $_GET['column'] ) ) {
	$class = 'col-md-' . ( 12 / ( $_GET['column'] ) );
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
    <div class="content-inner">
        <div class="entry-top">
			<?php
			do_action( 'thim_entry_top', 'full' );
			?>
        </div><!-- .entry-top -->

        <div class="entry-content">
			<?php
			if ( function_exists( 'thim_meta' ) && has_post_format( 'link' ) && thim_meta( 'thim_link_url' ) && thim_meta( 'thim_link_text' ) ) {
				$url  = thim_meta( 'thim_link_url' );
				$text = thim_meta( 'thim_link_text' );
				if ( $url && $text ) { ?>
                    <header class="entry-header">
                        <h3 class="entry-title">
                            <a class="link" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $text ); ?></a>
                        </h3>
                    </header><!-- .entry-header -->
					<?php
				}
				?>
				<?php if ( get_theme_mod( 'excerpt_archive_content_display', true ) ) { ?>
                    <div class="entry-summary">
						<?php the_excerpt(); ?>
                    </div><!-- .entry-summary -->
				<?php } ?>
				<?php if ( get_theme_mod( 'readmore_archive_content_display', true ) ) { ?>
                    <div class="readmore">
                        <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( 'Read More', 'course-builder' ); ?></a>
                    </div><!-- .read-more -->
				<?php } ?>

			<?php } elseif ( function_exists( 'thim_meta' ) && has_post_format( 'quote' ) && thim_meta( 'thim_quote_author_url' ) ) {

				$author     = thim_meta( 'thim_quote_author_text' );
				$author_url = thim_meta( 'thim_quote_author_url' );
				if ( $author_url ) {
					$author = ' <a href=' . esc_url( $author_url ) . '>' . $author . '</a>';
				}
				?>
                <header class="entry-header">
					<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                </header><!-- .entry-header -->
				<?php if ( get_theme_mod( 'excerpt_archive_content_display', true ) ) { ?>
                    <div class="entry-summary">
						<?php if ( $author ) { ?>
                            <div class="box-header box-quote">
                                <blockquote><?php the_content(); ?><cite><?php echo wp_kses( $author, array(
											'a' => array(
												'href' => array(),
											)
										) ); ?></cite>
                                </blockquote>
                            </div>
						<?php } ?>
                    </div><!-- .entry-summary -->
				<?php } ?>
				<?php if ( get_theme_mod( 'readmore_archive_content_display', true ) ) { ?>
                    <div class="readmore">
                        <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( 'Read More', 'course-builder' ); ?></a>
                    </div><!-- .read-more -->
				<?php } ?>
				<?php
			} elseif ( has_post_format( 'audio' ) ) { ?>
                <header class="entry-header">
                    <div class="entry-meta">
						<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
						<?php thim_entry_meta(); ?>
                    </div>
                </header><!-- .entry-header -->
				<?php if ( get_theme_mod( 'excerpt_archive_content_display', true ) ) { ?>
                    <div class="entry-summary">
						<?php
						the_excerpt();
						?>
                    </div><!-- .entry-summary -->
				<?php } ?>
				<?php if ( get_theme_mod( 'readmore_archive_content_display', true ) ) { ?>
                    <div class="readmore">
                        <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( 'Read More', 'course-builder' ); ?></a>
                    </div><!-- .read-more -->
				<?php } ?>

			<?php } elseif ( has_post_format( 'chat' ) ) { ?>
                <header class="entry-header">
                    <div class="entry-meta">
						<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
						<?php thim_entry_meta(); ?>
                    </div>
                </header><!-- .entry-header -->
				<?php if ( get_theme_mod( 'excerpt_archive_content_display', true ) ) { ?>
                    <div class="entry-summary">
						<?php the_excerpt(); ?>
                    </div><!-- .entry-summary -->
				<?php } ?>
				<?php if ( get_theme_mod( 'readmore_archive_content_display', true ) ) { ?>
                    <div class="readmore">
                        <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( 'Read More', 'course-builder' ); ?></a>
                    </div><!-- .read-more -->
				<?php } ?>

			<?php } else { ?>
                <header class="entry-header">
					<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                </header>
                <!-- .entry-header -->

				<?php thim_entry_meta(); ?>
				<?php if ( get_theme_mod( 'excerpt_archive_content_display', true ) ) { ?>
                    <div class="entry-summary">
						<?php
						the_excerpt();
						?>
                    </div><!-- .entry-summary -->
				<?php } ?>
				<?php if ( get_theme_mod( 'readmore_archive_content_display', true ) ) { ?>
                    <div class="readmore">
                        <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( 'Read More', 'course-builder' ); ?></a>
                    </div>
				<?php } ?>
			<?php }
			?>
        </div><!-- .entry-content -->
    </div> <!-- .content-inner -->
</article><!-- #post-## -->
