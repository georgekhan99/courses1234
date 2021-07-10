<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 */

/**
 * author meta
 *
 * @return void
 */
function thim_entry_meta_author() {
	echo thim_get_entry_meta_author();
}

/**
 * Get author meta
 *
 * @return string
 */
function thim_get_entry_meta_author() {
	$html = '<span class="author vcard">';
	$html .= sprintf( '<a href="%1$s" rel="author">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ) ) . '';
	$html .= '</span>';

	return $html;
}


/**
 * Get date meta
 *
 * @return string
 */
function thim_get_entry_meta_date() {
	$html =
		'<div class="entry-day">' . get_the_date( 'd' ) . '</div>'
		. '<div class="entry-month">' . get_the_date( 'M' ) . '</div>';


	return $html;
}


/**
 * Get category meta
 *
 * @return void
 */
function thim_entry_meta_category() {
	echo thim_get_entry_meta_category();
}

/**
 * Get category meta
 *
 * @return string
 */
function thim_get_entry_meta_category( $post_id = null ) {
	if ( is_single() ) {
		$html       = '<span class="meta-category">';
		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			$html .= '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
		}
		$html .= '</span>';

		return $html;
	} else {
		$html       = '<span class="meta-category">';
		$categories = get_the_category( $post_id );
		if ( ! empty( $categories ) ) {
			$html .= '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
		}
		$html .= '</span>';

		return $html;
	}
}

/**
 * Get tags meta
 *
 * @return void
 */
function thim_entry_meta_tags() {
	echo thim_get_entry_meta_tags();
}


/**
 * Get tags meta
 *
 * @return string
 */
function thim_get_entry_meta_tags() {
	$tags_list = get_the_tag_list( '', esc_html__( ', ', 'course-builder' ) );
	if ( $tags_list ) {
		return
			sprintf( '<span class="tags-links">' . '<span class="tag">' . esc_html__( 'Tag: ', 'course-builder' ) . '</span>' . esc_html__( '%1$s', 'course-builder' ) . '</span>', $tags_list ); // WPCS: XSS OK.
	}

	return '';
}

/**
 * comment number
 *
 * @return void
 */
function thim_entry_meta_comment_number() {
	if ( comments_open() ) { ?>
		<span class="comment-total">
			<?php comments_popup_link( __('No Comment', 'course-builder'), __('1 Comment','course-builder'), __('% Comments','course-builder'), 'comments-link', __('Comments are off for this post','course-builder' )); ?>
		</span>
		<?php
	}
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @return string HTML for meta tags
 */
if ( ! function_exists( 'thim_entry_meta' ) ) :
	function thim_entry_meta() {
		echo '<div class="entry-meta">';

		echo thim_get_entry_meta_author();
		echo thim_get_entry_meta_category();
		echo thim_entry_meta_comment_number();

		echo '</div>';
	}
endif;


if ( ! function_exists( 'thim_entry_meta_date' ) ) :
	function thim_entry_meta_date() {
		echo '<div class="entry-meta-date">';
		echo thim_get_entry_meta_date();
		echo '</div>';
	}
endif;

/**
 * Get social share
 *
 * @return string
 */
if ( ! function_exists( 'thim_social_share' ) ) {
	function thim_social_share( $prefix = 'blog_single_' ) {
		$socials = get_theme_mod( $prefix . 'group_sharing' );

		if ( $socials ) {
			$html = '<div class="text share-text">' . esc_html__( 'Share', 'course-builder' ) . '</div>';
			$html .= '<div class="thim-social-share popup" data-link="' . get_permalink() . '">';
			$html .= '<ul class="links">';
			foreach ( $socials as $key => $social ) {
				$html .= thim_render_social_share_link( $social );
			}
			$html .= '</ul>';
			$html .= '</div>';

			echo ent2ncr( $html );
		}

	}
}

add_action( 'thim_social_share', 'thim_social_share' );

/**
 * Render social share
 *
 * @param $social_name
 *
 * @return string
 */
function thim_render_social_share_link( $social_name ) {
	switch ( $social_name ) {
		case 'facebook':
			return '<li><a class="link facebook" title="' . esc_html__( 'Facebook', 'course-builder' ) . '" href="http://www.facebook.com/sharer/sharer.php?u=' . urlencode( get_permalink() ) . '" rel="nofollow" onclick="window.open(this.href,this.title,\'width=600,height=600,top=200px,left=200px\');  return false;" target="_blank"><i class="ion-social-facebook"></i></a></li>';
			break;

		case 'twitter':
			return '<li><a class="link twitter" title="' . esc_html__( 'Twitter', 'course-builder' ) . '" href="https://twitter.com/intent/tweet?url=' . urlencode( get_permalink() ) . '&amp;text=' . esc_attr( urlencode( get_the_title() ) ) . '" rel="nofollow" onclick="window.open(this.href,this.title,\'width=600,height=600,top=200px,left=200px\');  return false;" target="_blank"><i class="ion-social-twitter"></i></a></li>';
			break;

		case 'pinterest':
			global $post;
			$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );

			return '<li><a class="link pinterest" title="' . esc_html__( 'Pinterest', 'course-builder' ) . '" href="http://pinterest.com/pin/create/button/?url=' . urlencode( get_permalink() ) . '&amp;media=' . ( ! empty( $src[0] ) ? $src[0] : '' ) . '&description=' . esc_attr( urlencode( get_the_title() ) ) . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="ion-social-pinterest" aria-hidden="true"></i></a></li>';
			break;

		case 'linkedin':
			return '<li><a title="' . esc_html__( 'LinkedIn', 'course-builder' ) . '" target="_blank" class="link linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode( get_permalink() ) . '&title=' . rawurlencode( esc_attr( get_the_title() ) ) . '&summary=&source=' . rawurlencode( esc_attr( get_the_excerpt() ) ) . '" onclick="window.open(this.href,this.title,\'width=600,height=600,top=200px,left=200px\');  return false;"><i class="fa fa-linkedin-square"></i></a></li>';
			break;


		case 'google':
			return '<li><a target="_blank" title="' . esc_html__( 'Google', 'course-builder' ) . '" class="link google" href="https://plus.google.com/share?url=' . urlencode( get_permalink() ) . '&amp;title=' . rawurlencode( esc_attr( get_the_title() ) ) . '" title="' . esc_attr__( 'Google Plus', 'course-builder' ) . '" onclick=\'javascript:window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;\'><i class="fa fa-google"></i></a></li>';
			break;

        case 'whatsapp':
            return '<li><a target="_blank" title="' . esc_html__( 'Whatsapp', 'course-builder' ) . '" class="link  whatsapp" href="whatsapp://send?text=' . urlencode( get_permalink() ) . '&amp;title=' . rawurlencode( esc_attr( get_the_title() ) ) . '" data-action="share/whatsapp/share" title="' . esc_attr__( 'Google Plus', 'course-builder' ) . '" onclick=\'javascript:window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;\'><i class="fa fa-whatsapp"></i></a></li>';
            break;

		default:
			return '';
			break;
	}
}

/**
 * Get pagination
 *
 * @return string
 */

if ( ! function_exists( 'thim_paging_nav' ) ) :

	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function thim_paging_nav() {
		global $wp_rewrite;
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}
		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = esc_url( remove_query_arg( array_keys( $query_args ), $pagenum_link ) );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';
		// Set up paginated links.
		$links = paginate_links( array(
			'base'      => $pagenum_link,
			'format'    => $format,
			'total'     => $GLOBALS['wp_query']->max_num_pages,
			'current'   => $paged,
			'mid_size'  => 2,
			'add_args'  => array_map( 'urlencode', $query_args ),
			'prev_text' => '<i class="fa fa-angle-left"></i>',
			'next_text' => '<i class="fa fa-angle-right"></i>',
			'type'      => 'array'
		) );

		if ( $links ) : ?>
			<ul class="loop-pagination">
				<?php foreach ( $links as $link ) {
					echo '<li>' . $link . '</li>';
				} ?>
			</ul><!-- .pagination -->
		<?php endif;
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function thim_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'thim_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'thim_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so thim_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so thim_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in thim_categorized_blog.
 *
 * @return bool
 */
if ( ! function_exists( 'thim_category_transient_flusher' ) ) {
	function thim_category_transient_flusher() {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Like, beat it. Dig?
		delete_transient( 'thim_categories' );
	}
}
add_action( 'edit_category', 'thim_category_transient_flusher' );
add_action( 'save_post', 'thim_category_transient_flusher' );

/**
 * Change default comment fields
 *
 * @param $fields
 *
 * @return string
 */
if ( ! function_exists( 'thim_new_comment_fields' ) ) {
	function thim_new_comment_fields( $fields ) {
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? 'aria-required=true' : '' );

		$fields = array(
			'author' => '<p class="comment-form-author">' . '<input placeholder="' . esc_attr__( 'Name...', 'course-builder' ) . ( $req ? '' : '' ) . '" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" ' . $aria_req . ' /></p>',
			'email'  => '<p class="comment-form-email">' . '<input placeholder="' . esc_attr__( 'Email...', 'course-builder' ) . ( $req ? '' : '' ) . '" id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" ' . $aria_req . ' /></p>',
		);

		return $fields;
	}
}
add_filter( 'comment_form_default_fields', 'thim_new_comment_fields' );

if ( ! function_exists( 'thim_new_comment_submit_button' ) ) {
	function thim_new_comment_submit_button( $button ) {
		$button = '<input name="submit" type="submit" id="submit" class="submit" value="' . esc_html__( 'Submit', 'course-builder' ) . '">';

		return $button;
	}
}
add_filter( 'comment_form_submit_button', 'thim_new_comment_submit_button' );

/**
 * Show list comments
 *
 * @return string
 */
if ( ! function_exists( 'thim_comment' ) ) {
	function thim_comment( $comment, $args, $depth ) {
		if ( 'div' == $args['style'] ) {
			$tag       = 'div ';
			$add_below = 'comment';
		} else {
			$tag       = 'li ';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo esc_attr( $tag ) ?><?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
			<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
		<div class="content-comment">
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'course-builder' ) ?></em>
			<?php endif; ?>
			<div class="author">
				<?php
				if ( $args['avatar_size'] != 0 ) {
					echo '<a href="' . get_comment_author_url() . '">';
					echo get_avatar( $comment, 84 );
					echo '</a>';
				} ?>
			</div>
			<div class="message-wrapper">
				<div class="author-info">
					<div class="inner-info">
						<?php
						printf( '<h5 class="author-name">%s</h5>', get_comment_author_link() );
						printf( '<div class="comment-date">%s</div>', get_comment_date() )
						?>
					</div>
					<div class="comment-links">
						<?php
						comment_reply_link( array_merge( $args, array(
							'reply_text' => esc_html__( 'Reply', 'course-builder' ),
							'add_below'  => $add_below,
							'depth'      => $depth,
							'max_depth'  => $args['max_depth']
						) ) ); ?>
						<?php edit_comment_link( esc_html__( 'Edit', 'course-builder' ), '', '' ); ?>
					</div>
				</div>
				<div class="message"><?php comment_text() ?></div>
			</div>

		</div>
		<?php if ( 'div' != $args['style'] ) : ?>
			</div>
		<?php endif; ?>
		<?php
	}
}
/**
 * Show list comments single course
 *
 * @return string
 */

if ( ! function_exists( 'thim_comment_single_course' ) ) {
	function thim_comment_single_course( $comment, $args, $depth ) {
		$user = get_user_by( 'email', get_comment_author_email() );

		if ( 'div' == $args['style'] ) {
			$tag       = 'div ';
			$add_below = 'comment';
		} else {
			$tag       = 'li ';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo esc_attr( $tag ) ?><?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
			<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
		<div class="content-comment">
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'course-builder' ) ?></em>
			<?php endif; ?>
			<div class="author">
				<?php
				if ( $args['avatar_size'] != 0 ) {
					echo '<a href="">';
					echo get_avatar( $comment, 84 );
					echo '</a>';
				} ?>
			</div>
			<div class="message-wrapper">
				<div class="author-info">
					<div class="inner-info">
						<h5 class="author-name">
							<a href="<?php echo learn_press_user_profile_link( $user->ID ); ?>">
								<?php
								printf( '%s', get_comment_author_link() );
								?>
							</a>
						</h5>
						<span class="role">
							<?php if ( ! empty( $user->roles ) ) {
								if ( $user->roles[0] == 'lp_teacher' ) {
									echo esc_html( "Instructor" );
								} else if ( $user->roles[0] == 'shop_manager' ) {
									echo esc_html( "Shop manager" );
								} else {
									echo esc_html( $user->roles[0] );
								}
							} ?>
						</span>
						<?php printf( '<span class="date">%s</span>', get_comment_date() ) ?>
					</div>
					<div class="comment-links">
						<?php
						comment_reply_link( array_merge( $args, array(
							'reply_text' => esc_html__( 'Reply', 'course-builder' ),
							'add_below'  => $add_below,
							'depth'      => $depth,
							'max_depth'  => $args['max_depth']
						) ) ); ?>
						<?php edit_comment_link( esc_html__( 'Edit', 'course-builder' ), '', '' ); ?>
					</div>
				</div>
				<div class="message"><?php comment_text() ?></div>
			</div>
		</div>
		<?php if ( 'div' != $args['style'] ) : ?>
			</div>
		<?php endif; ?>
		<?php
	}
}
/**
 *
 * Excerpt Length
 * @return string
 */
function thim_excerpt_length() {
	$thim_options = get_theme_mods();

	if ( isset( $thim_options['excerpt_archive_content'] ) ) {
		$length = get_theme_mod( 'excerpt_archive_content' );
	} else {
		$length = '50';
	}

	return $length;
}

add_filter( 'excerpt_length', 'thim_excerpt_length', 99999 );

/**
 * Change excerpt more
 * @return string
 */
function thim_excerpt_more() {
	return '...';
}

add_filter( 'excerpt_more', 'thim_excerpt_more' );

/**
 * Get related posts
 *
 * @return WP_Query
 */
function thim_get_related_posts() {
    global $post;
    $query = new WP_Query();
    $args  = '';
	$number_posts  = (int) get_theme_mod( 'blog_single_related_post_number', 5 );

    if ( $number_posts == 0 ) {
        return $query;
    }

    $args  = wp_parse_args( $args, array(
        'posts_per_page'      => $number_posts,
        'post__not_in'        => array( $post->ID ),
        'ignore_sticky_posts' => 0,
        'category__in'        => wp_get_post_categories( $post->ID )
    ) );
    $query = new WP_Query( $args );

    return $query;

}

/**
 * Get group chat content for post format chat
 *
 * @todo Should move function thim_meta to theme.
 *
 * @return string
 */
function thim_get_list_group_chat() {
	$group_chat = thim_meta( 'thim_group_chat' );
	foreach ( $group_chat as $key => $value ) {
		echo '<ul class="group-chat"><li>';
		echo '<span class="chat-name">' . esc_attr( $value['thim_chat_name'] ) . ':</span><span class="chat-message">' . esc_attr( $value['thim_chat_content'] ) . '</span>';
		echo '</li></ul>';
	}
}

/**
 * Get archive title
 *
 * Display the archive title based on the queried object.
 *
 * @return string
 */
if ( ! function_exists( 'thim_archive_title' ) ) :
	function thim_archive_title( $before = '', $after = '' ) {
		if ( is_post_type_archive( ) ) {
			$title = sprintf( esc_html__( '%s', 'course-builder' ), post_type_archive_title( '', false ) );
		} elseif ( is_category() ) {
			$title = sprintf( esc_html__( '%s', 'course-builder' ), single_cat_title( '', false ) );
		} elseif ( is_tag() ) {
			$title = sprintf( esc_html__( '%s', 'course-builder' ), single_tag_title( '', false ) );
		} elseif ( is_author() ) {
			$title = sprintf( esc_html__( '%s', 'course-builder' ), '<span class="vcard">' . get_the_author() . '</span>' );
		} elseif ( is_year() ) {
			$title = sprintf( esc_html__( 'Year: %s', 'course-builder' ), get_the_date( 'Y' ) );
		} elseif ( is_month() ) {
			$title = sprintf( esc_html__( 'Month: %s', 'course-builder' ), get_the_date( 'F Y' ) );
		} elseif ( is_day() ) {
			$title = sprintf( esc_html__( 'Day: %s', 'course-builder' ), get_the_date( 'F j, Y' ) );
		} elseif ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = esc_html__( 'Asides', 'course-builder' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = esc_html__( 'Galleries', 'course-builder' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = esc_html__( 'Images', 'course-builder' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = esc_html__( 'Videos', 'course-builder' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = esc_html__( 'Quotes', 'course-builder' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = esc_html__( 'Links', 'course-builder' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = esc_html__( 'Statuses', 'course-builder' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = esc_html__( 'Audio', 'course-builder' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = esc_html__( 'Chats', 'course-builder' );
		} elseif ( is_tax() ) {
			$tax = get_taxonomy( get_queried_object()->taxonomy );
			/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
			$title = sprintf( esc_html__( '%s', 'course-builder' ), single_term_title( '', false ) );
		} elseif ( is_404() ) {
			$title = esc_html__( '404 Page', 'course-builder' );
		} elseif ( is_search() ) {
			$title = esc_html__( 'Search Results Page', 'course-builder' );
		} else {
			$title = esc_html__( 'Archives', 'course-builder' );
		}
		/**
		 * Filter the archive title.
		 *
		 * @param string $title Archive title to be displayed.
		 */
		if ( ! empty( $title ) ) {
			return ent2ncr( $before . $title . $after );
		}
	}
endif;
/**
 * Get author social link
 *
 * @return string
 */
function thim_get_author_social_link() {
	$user = new WP_User( get_the_author_meta( 'ID' ) );

	$link_facebook  = get_the_author_meta( 'lp_info_facebook', get_the_author_meta( 'ID' ) );
	$link_twitter   = get_the_author_meta( 'lp_info_twitter', get_the_author_meta( 'ID' ) );
	$link_skype     = get_the_author_meta( 'lp_info_skype', get_the_author_meta( 'ID' ) );
	$link_pinterest = get_the_author_meta( 'lp_info_pinterest', get_the_author_meta( 'ID' ) );
	$link_linkedin    = get_the_author_meta( 'lp_info_linkedin', get_the_author_meta( 'ID' ) );
	$link_instagram = get_the_author_meta( 'lp_info_instagram', get_the_author_meta( 'ID' ) );
	?>

	<ul class="thim-author-social">
		<?php if ( ! empty( $link_facebook ) ) { ?>
			<li>
				<a href="<?php echo esc_url( $link_facebook ); ?>" target="_blank" class="facebook"><i class="fa fa-facebook"></i></a>
			</li>
		<?php } ?>

		<?php if ( ! empty( $link_twitter ) ) { ?>
			<li>
				<a href="<?php echo esc_url( $link_twitter ); ?>" target="_blank" class="twitter"><i class="fa fa-twitter"></i></a>
			</li>
		<?php } ?>

		<?php if ( ! empty( $link_skype ) ) { ?>
			<li>
				<a href="<?php echo esc_attr( $link_skype ); ?>" target="_blank" class="skype"><i class="fa fa-skype"></i></a>
			</li>
		<?php } ?>

		<?php if ( ! empty( $link_pinterest ) ) { ?>
			<li>
				<a href="<?php echo esc_url( $link_pinterest ); ?>" target="_blank" class="pinterest"><i class="fa fa-pinterest"></i></a>
			</li>
		<?php } ?>

        <?php if ( ! empty( $link_linkedin ) ) { ?>
            <li>
                <a href="<?php echo esc_url( $link_linkedin ); ?>" target="_blank" class="linkedin"><i class="fa fa-linkedin"></i></a>
            </li>
        <?php } ?>

        <?php if ( ! empty( $link_instagram ) ) { ?>
            <li>
                <a href="<?php echo esc_url( $link_instagram ); ?>" target="_blank" class="instagram"><i class="fa fa-instagram"></i></a>
            </li>
        <?php } ?>

	</ul>
<?php }

/**
 * Get about the author
 *
 * @return string
 */
if ( ! function_exists( 'thim_about_author' ) ) {
	function thim_about_author() {
		$user = new WP_User( get_the_author_meta( 'ID' ) );
		$link = get_author_posts_url( get_the_author_meta( 'ID' ) );
		if ( get_the_author_meta( 'description' ) ) :
			?>
			<div class="thim-about-author">
				<div class="author-wrapper left">
					<div class="author-avatar">
						<a class="name" href="<?php echo esc_url( $link ); ?>">
							<?php echo get_avatar( get_the_author_meta( 'ID' ), 147 ); ?>
						</a>
					</div>
					<?php thim_get_author_social_link(); ?>
				</div>
				<div class="author-wrapper right">
					<div class="author-top">
						<a class="name" href="<?php echo esc_url( $link ); ?>"> <?php echo get_the_author(); ?> </a>
						<?php if ( ! empty( $user->roles ) ) {
							echo '<div class="role">' . esc_html( $user->roles[0] ) . '</div>';
						} ?>
					</div>
					<div class="author-bio">
						<div class="author-description">
							<?php echo get_the_author_meta( 'description' ); ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif;
	}
}

add_action( 'thim_about_author', 'thim_about_author' );

/**
 * Move field comment bellow input fields
 *
 * @param $fields
 *
 * @return mixed
 */
function thim_move_comment_field_to_bottom( $fields ) {

	$comment_field = $fields['comment'];

	unset( $fields['comment'] );

	$fields['comment'] = $comment_field;

	return $fields;
}

add_filter( 'comment_form_fields', 'thim_move_comment_field_to_bottom' );

// Ajax data handler

function thim_loadmore_ajax_handler() {
	$thim_options = get_theme_mods();
	// prepare our arguments for the query
	$args                = unserialize( stripslashes( $_POST['query'] ) );
	$args['paged']       = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';

	// it is always better to use WP_Query but not here
	query_posts( $args );

	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
			get_template_part( 'templates/template-parts/content' );
		endwhile;
	endif;
	die; // here we exit the script and even no wp_reset_query() required!
}

add_action( 'wp_ajax_loadmore', 'thim_loadmore_ajax_handler' ); // wp_ajax_{action}
add_action( 'wp_ajax_nopriv_loadmore', 'thim_loadmore_ajax_handler' ); // wp_ajax_nopriv_{action}

/**
 * Get Search
 *
 * @return string
 */
if ( ! function_exists( 'thim_get_top_box' ) ) {
	function thim_get_top_box() {
		?>
		<div class="top-box row">
			<div class="title-text col">
				<h3 class="title"><?php echo esc_attr__( 'Recent Post', 'course-builder' ); ?></h3>
			</div>
			<div class="filter-search-right col">
				<div class="pull-right">
					<?php echo get_search_form(); ?>
					<div class="blog-filter">
						<i class="icon grid fa fa-th"></i>
						<i class="icon list  fa fa-list"></i>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}