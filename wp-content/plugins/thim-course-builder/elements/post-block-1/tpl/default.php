<?php
$post_number = isset( $params['post_number'] ) ? $params['post_number'] : 2;
$columns     = 'col-md-' . ( 12 / $params['post_columns'] );
$args_post = array(
	'post_type'      => 'post',
	'posts_per_page' => $post_number,
	'post_status'    => 'publish',
	'category_name'  => $params['cat_post'],
	'orderby'        => $params['list_post'],
);

$loop = new WP_Query( $args_post );
?>
<div class="thim-sc-post-block-1 <?php echo esc_attr( $params['el_class'] ); ?>">
	<div class="row">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<div class="item <?php echo esc_attr( $columns ); ?> ">
				<div class="inner-item">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="thumbnail">
							<?php
								if($params['post_columns'] == '1'){
									echo thim_thumbnail( get_the_ID(), 'full' );
								}else{
									echo thim_thumbnail( get_the_ID(), '510x600' );
								}
							?>
							<span class="cat-post">
							<?php
							echo get_the_category()[0]->name; ?>
							</span>
						</div>
					<?php endif; ?>
					<div class="information">
						<a href="<?php the_permalink() ?>">
							<div class="date"><?php echo get_the_date(); ?> </div>
						</a>
						<h4 class="title"><a href="<?php esc_url( the_permalink() ) ?>"><?php the_title(); ?></a></h4>
						<div class="data-meta">
							<span class="cat-post">
							<?php
							echo thim_get_entry_meta_category(); ?>
						</span>
							<?php echo esc_html__( ' / ', 'course-builder' ); ?>
							<?php echo thim_entry_meta_comment_number() ?>
						</div>
						<?php
						if ( get_the_excerpt() ):?>
							<div class="content-post"><p><?php the_excerpt(); ?></p></div>
						<?php endif; ?>
						<div class="author-post">
							<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>">
								<span class="avatar"> <?php echo( get_avatar( get_the_author_meta( 'ID' ), 61 ) ); ?></span>
								<span class="author">
									<?php if ( get_the_author_meta( 'lp_info_major' ) ) : ?>
										<p class="description"><?php the_author_meta( 'lp_info_major' ); ?></p>
									<?php endif; ?>
									<p class="author-name"><?php the_author(); ?></p>
								</span>
							</a>
						</div>
					</div>
					<div class="sub-content">
						<h4 class="title"><?php the_title(); ?></h4>
						<div class="data-meta">
							<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a>
							<?php echo esc_html__( ' / ', 'course-builder' ); ?>
							<?php echo thim_entry_meta_comment_number() ?>
						</div>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	</div>
	<?php wp_reset_postdata(); ?>
</div>