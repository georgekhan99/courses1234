<?php

$layout      = $params['layout'];
$title       = $params['title'];
$des         = $params['description'];
$button_text = $params['button_text'];
$limit       = $params['limit'];
$visible     = $params['visible'];
$scrollbar   = $params['scrollbar'];

$arr_collection = array(
	'post_type'      => 'lp_collection',
	'posts_per_page' => $params['limit'],
	'post_status'    => 'publish',
);


$query_collection = new WP_Query( $arr_collection );
?>
	<div class="thim-courses-collection-wrapper">
		<?php
		if ( $title !== '' || $des !== '' || $button_text !== '' ) {
			?>
			<div class="thim-collection-info rounded-colection-info">
				<?php if ( $title !== '' ): ?>
					<h3 class="title"><?php echo esc_html( $params['title'] ); ?></h3>
				<?php endif; ?>

				<?php if ( $des !== '' ) : ?>
					<div class="description"><?php echo ent2ncr( $params['description'] ); ?> </div>
				<?php endif; ?>

			</div>
			<?php
		}

		?>
		<?php if ( $query_collection->have_posts() ): ?>
			<div class="thim-courses-collection rounded-courses-collection" data-img="<?php echo esc_url( THIM_CB_ELEMENTS_URL . 'courses-collection/assets/images/group-3.jpg' ); ?>">
				<?php if ( $limit > 5 || $query_collection->post_count > 5 ): ?>
					<?php if ( $scrollbar === 'yes' ): ?>
						<div class="scrollbar">
							<div class="handle"></div>
						</div>
					<?php endif; ?>
				<?php endif; ?>

				<div class="collection-frame items-<?php echo esc_attr( $visible ); ?>">
					<ul class="slidee">
						<?php while ( $query_collection->have_posts() ) : $query_collection->the_post(); ?>
							<li class="collection-item">
								<?php
								if ( has_post_thumbnail() ) {
									thim_thumbnail( get_the_ID(), '271x177', 'post', false );
								}
								?>
								<a class="collection-wrapper" href="<?php echo esc_url( get_the_permalink() ); ?>">
									<h4 class="name"><?php echo get_the_title(); ?></h4>
									<?php thim_course_number( get_the_ID() ); ?>
								</a>
							</li>
						<?php endwhile; ?>
					</ul>
				</div>
			</div>

		<?php endif; ?>
		<?php wp_reset_postdata(); ?>

		<?php
		if ( $button_text ) :
			$archive_collection_url = get_post_type_archive_link( 'lp_collection' ) ? get_post_type_archive_link( 'lp_collection' ) : '#';
			?>
			<div class="rounded-view-all-button">
				<a href="<?php echo esc_url( $archive_collection_url ); ?>"><?php echo esc_html( $params['button_text'] ); ?></a>
			</div>
		<?php endif; ?>
	</div>
<?php
