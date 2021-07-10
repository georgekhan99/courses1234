<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */

$thim_options = get_theme_mods();
if ( isset( $_POST['style'] )) {
	$thim_options['archive_post_layout']  =  $_POST['style'];
}
$layout        = isset( $thim_options['archive_post_layout'] ) ? $thim_options['archive_post_layout'] : 'list';
$show_excerpt  = get_theme_mod( 'excerpt_archive_content_display', true );
$show_readmore = get_theme_mod( 'readmore_archive_content_display', true );
$style         = 'list';
$column        = isset( $thim_options['archive_post_column'] ) && ( $thim_options['archive_post_layout'] == 'grid' ) ? 12 / get_theme_mod( 'archive_post_column' ) : 12;
if ( isset( $_GET['style'] ) ) {
	$layout = $_GET['style'];
}
if ( isset( $_GET['style'] ) && $_GET['style'] == 'grid' ) {
	$column        = 12 / get_theme_mod( 'archive_post_column' );
	$show_excerpt  = false;
	$show_readmore = false;
}

if ( $layout === 'grid') {
	$classes[] = 'col-xl-' . $column;
	$classes[] = 'col-lg-4';
} else {
	$classes[] = 'col-12';
}

if ( has_post_thumbnail() ) {
	$entry_content = "entry-content";
} else {
	$entry_content = "entry-content no-thumbnail";
}
?>


<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div class="content-inner">
		<div class="entry-top">
			<?php
			if ( has_post_thumbnail() || thim_meta('thim_gallery') ) {
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

		<div class="<?php echo esc_attr( $entry_content ); ?>">
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
				<?php if ( $show_excerpt ) { ?>
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div><!-- .entry-summary -->
				<?php } ?>
				<?php if ( $show_readmore ) { ?>
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
				<?php if ( $show_excerpt ) { ?>
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
				<?php if ( $show_readmore ) { ?>
					<div class="readmore">
						<a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( 'Read More', 'course-builder' ); ?></a>
					</div><!-- .read-more -->
				<?php } ?>
				<?php
			} elseif ( has_post_format( 'audio' ) ) { ?>
				<header class="entry-header">
					<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
					<?php
					if ( get_theme_mod( 'blog_archive_display_meta', true ) ) {
						thim_entry_meta();
					}
					?>
				</header><!-- .entry-header -->
				<?php if ( $show_excerpt ) { ?>
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div><!-- .entry-summary -->
				<?php } ?>
				<?php if ( $show_readmore ) { ?>
					<div class="readmore">
						<a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( 'Read More', 'course-builder' ); ?></a>
					</div><!-- .read-more -->
				<?php } ?>

			<?php } elseif ( has_post_format( 'chat' ) ) { ?>
				<header class="entry-header">
					<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
					<?php
					if ( get_theme_mod( 'blog_archive_display_meta', true ) ) {
						thim_entry_meta();
					}
					?>
				</header><!-- .entry-header -->
				<?php if ( $show_excerpt ) { ?>
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div><!-- .entry-summary -->
				<?php } ?>
				<?php if ( $show_readmore ) { ?>
					<div class="readmore">
						<a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( 'Read More', 'course-builder' ); ?></a>
					</div><!-- .read-more -->
				<?php } ?>

			<?php } else { ?>
				<header class="entry-header">
					<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
				</header>
				<!-- .entry-header -->

				<?php
				if ( get_theme_mod( 'blog_archive_display_meta', true ) ) {
					thim_entry_meta();
				}
				?>
				<?php if ( $show_excerpt ) { ?>
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div><!-- .entry-summary -->
				<?php } ?>
				<?php if ( $show_readmore ) { ?>
					<div class="readmore">
						<a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( 'Read More', 'course-builder' ); ?></a>
					</div><!-- .read-more -->
				<?php } ?>
			<?php }
			?>

		</div><!-- .entry-content -->
	</div> <!-- .content-inner -->
</article><!-- #post-## -->

