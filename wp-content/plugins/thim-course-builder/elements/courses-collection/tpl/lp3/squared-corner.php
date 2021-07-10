<?php
/**
 * Template for displaying Course collection shortcode layout squared corner for Learnpress v3.
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
 * @var $limit
 * @var $nav
 * @var $visible
 */
extract( $params );

$arr_collection = array(
	'post_type'      => 'lp_collection',
	'posts_per_page' => $params['limit'],
	'post_status'    => 'publish',
);

$query_collection = new WP_Query( $arr_collection ); ?>

    <div class="thim-courses-collection-wrapper">
		<?php if ( $title || $description ) { ?>
            <div class="thim-collection-info squared-colection-info">
				<?php if ( $title ): ?>
                    <h3 class="title"><?php echo esc_html( $title ); ?></h3>
				<?php endif; ?>
				<?php if ( $description ) : ?>
                    <div class="description"><?php echo ent2ncr( $description ); ?></div>
				<?php endif; ?>
            </div>
		<?php } ?>

		<?php if ( $query_collection->have_posts() ): ?>
            <div class="thim-courses-collection squared-courses-collection"
                 data-img="<?php echo esc_url( THIM_CB_URL . 'courses-collection/assets/images/group-3.jpg' ); ?>">
                <div class="collection-frame items-<?php echo esc_attr( $visible ); ?>">
                    <ul class="slidee">
						<?php while ( $query_collection->have_posts() ) : $query_collection->the_post(); ?>
                            <li class="collection-item">
                                <div class="thumbnail">
                                    <a href="<?php echo esc_url( get_the_permalink() ); ?>" class="collection-link"></a>
									<?php if ( has_post_thumbnail() ) {
										thim_thumbnail( get_the_ID(), '310x278', 'post', false );
									}
									?>
                                    <div class="wrapper">
                                        <span class="ion-qr-scanner"></span>
                                        <span class="view"><?php echo esc_html__( 'view courses', 'course-builder' ); ?></span>
                                    </div>
                                </div>

                                <div class="collection-wrapper">
                                    <h4 class="name"><a
                                                href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo get_the_title(); ?></a>
                                    </h4>
									<?php thim_course_number( get_the_ID() ); ?>
                                </div>
                            </li>
						<?php endwhile; ?>
                    </ul>

					<?php if ( $nav === 'yes' ): ?>
						<?php if ( $limit > 5 || $query_collection->post_count > 5 ): ?>
                            <div class="controls">
                                <span class="prev page-controls ion-ios-arrow-thin-left"></span>
                                <span class="next page-controls ion-ios-arrow-thin-right"></span>
                            </div>
						<?php endif; ?>
					<?php endif; ?>
                </div>
            </div>
		<?php endif; ?>
    </div>
<?php wp_reset_postdata();