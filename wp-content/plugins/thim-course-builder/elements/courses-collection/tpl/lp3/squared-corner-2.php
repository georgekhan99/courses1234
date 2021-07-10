<?php
/**
 * Template for displaying Course collection shortcode layout squared corner 2 for Learnpress v3.
 *
 * @author  ThimPress
 * @package Course Builder/Templates
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

/**
 * Extract $params to parameters
 * @var $layout
 * @var $title
 * @var $description
 * @var $button_text
 * @var $visible
 */
extract( $params );

$arr_collection = array(
	'post_type'      => 'lp_collection',
	'posts_per_page' => $visible,
	'post_status'    => 'publish',
);

$columns = ( $visible != 5 ) ? ( 12 / $visible ) : '5c';
$archive_collection_url = get_post_type_archive_link( 'lp_collection' ) ? get_post_type_archive_link( 'lp_collection' ) : '#';

$query_collection = new WP_Query( $arr_collection );
?>

<div class="course-collection-squared-2">
	<?php if ( $title || $description ): ?>
        <div class="section-title-wrapper">
			<?php if ( $description ): ?>
                <div class="description"><?php echo ent2ncr( $description ); ?></div>
			<?php endif; ?>
			<?php if ( $title ) : ?>
                <h3 class="title"><?php echo esc_html( $title ); ?></h3>
			<?php endif; ?>
        </div>
	<?php endif; ?>

	<?php if ( $query_collection->have_posts() ): ?>
        <div class="section-content-wrapper">
            <div class="frame">
                <ul class="wrap-items items-<?php echo esc_attr( $visible ); ?> clearfix">
					<?php while ( $query_collection->have_posts() ) : $query_collection->the_post(); ?>
                        <li class="collection-item col-md-<?php echo esc_attr( $columns ); ?>">
                            <div class="collection-content">
								<?php if ( ! has_post_thumbnail() ): ?>
                                    <div class="no-thumbnail"></div>
								<?php else: ?>
                                    <div class="thumbnail">
										<?php thim_thumbnail( get_the_ID(), '318x256' ); ?>
                                    </div>
								<?php endif; ?>

                                <div class="collection-wrapper">
                                    <a href="<?php echo esc_url( get_the_permalink() ); ?>">
                                        <h4 class="name"><?php echo get_the_title(); ?></h4>
                                    </a>
									<?php thim_course_number( get_the_ID() ); ?>
                                </div>
                            </div>
                        </li>
					<?php endwhile; ?>

                </ul>
            </div>
        </div>

		<?php if ( $button_text ): ?>
            <div class="view-all-collections">
                <a href="<?php echo esc_url( $archive_collection_url ); ?>"><?php echo esc_html( $params['button_text'] ); ?></a>
            </div>
		<?php endif; ?>
	<?php endif; ?>
</div>
