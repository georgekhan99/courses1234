<?php
$number_events = !empty( $params['number_post'] ) ? $params['number_post'] : 1;
$args          = array(
    'post_type'      => 'post',
    'posts_per_page' => $number_events,
);

if ( $params['cat_post'] ) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'category',
            'field'    => 'id',
            'terms'    => array( $params['cat_post'] ),
        ),
    );
}

$events = new WP_Query( $args );
$params['query'] = $events;

?>
<div class="row thim-sc-events owl-carousel owl-theme events-layer-2 <?php echo esc_attr( $params['el_class'] ); ?> " data-cols="1">
	<?php if ( $params['query']->have_posts() ) : ?>
		<?php while ( $params['query']->have_posts() ) : $params['query']->the_post(); ?>
			<div class="events">
				<div class="events-before">
					<div class="content-inner">
						<h4 class="title"><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<div class="time-location">
								<span class="time">
                                    <span><i class="ion-android-alarm-clock"></i><?php echo get_the_date(get_option('date_format')); ?></span>
                                    <span style="margin-left: 10px"><i class="fa fa-comments-o"></i><?php thim_entry_meta_comment_number(); ?></span>
								</span>
						</div>
						<div class="line"></div>
						<p class="description">
							<?php echo wp_trim_words( get_the_content(), 15, '...' ); ?>
						</p>
						<div class="author">
							<?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
							<div class="author-contain">
								<span class="jobTitle"><?php esc_html_e( 'Host', 'course-builder' ); ?></span>
								<span class="name">
											<a href="<?php echo esc_url( learn_press_user_profile_link( $params['query']->post->post_author ) ); ?>">
												<?php echo get_the_author(); ?>
											</a>
										</span>
							</div>
						</div>
					</div>
				</div>

				<div class="events-after">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="thumbnail">
							<?php thim_thumbnail( get_the_ID(), '342x381', 'post', true ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endwhile; ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'course-builder' ); ?></p>
	<?php endif; ?>
</div>
