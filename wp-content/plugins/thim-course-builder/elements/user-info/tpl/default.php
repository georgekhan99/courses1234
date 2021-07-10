<?php
$user_exits = get_userdata( $params['id_user'] );
$user_id    = ( $user_exits == true ) ? $params['id_user'] : 1;
$user       = ( $user_exits == true ) ? get_user_by( 'id', $params['id_user'] ) : get_user_by( 'id', 1 );
?>
<div class="thim-sc-about-author-course <?php echo esc_attr( $params['el_class'] ); ?>">
	<h3 class="title">
		<?php echo esc_html__( 'Your Instructor', 'course-builder' ) ?>
	</h3>
	<div class="author-wrapper">
		<div class="author-avatar">
			<a href="<?php echo esc_url( learn_press_user_profile_link( $user_id ) ); ?>">
				<?php echo( get_avatar( $user_id, 147 ) ); ?>
			</a>
			<?php if ( get_the_author_meta( 'lp_info_facebook', $user_id ) || get_the_author_meta( 'lp_info_twitter', $user_id ) || get_the_author_meta( 'lp_info_pinterest', $user_id ) || get_the_author_meta( 'lp_info_skype', $user_id ) ) : ?>
				<ul class="social">
					<?php if ( get_the_author_meta( 'lp_info_facebook', $user_id ) ): ?>
						<li>
							<a href="<?php echo esc_url( get_the_author_meta( 'lp_info_facebook', $user_id ) ); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
						</li>
					<?php endif; ?>
					<?php if ( get_the_author_meta( 'lp_info_twitter', $user_id ) ): ?>
						<li>
							<a href="<?php echo esc_url( get_the_author_meta( 'lp_info_twitter', $user_id ) ); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
						</li>
					<?php endif; ?>
					<?php if ( get_the_author_meta( 'lp_info_pinterest', $user_id ) ): ?>
						<li>
							<a href="<?php echo esc_url( get_the_author_meta( 'lp_info_pinterest', $user_id ) ); ?>"><i class="fa fa-pinterest" aria-hidden="true"></i>
							</a>
						</li>
					<?php endif; ?>
					<?php if ( get_the_author_meta( 'lp_info_skype', $user_id ) ): ?>
						<li>
							<a href="<?php echo esc_url( get_the_author_meta( 'lp_info_skype', $user_id ) ); ?>"><i class="fa fa-skype" aria-hidden="true"></i>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			<?php endif; ?>
		</div>
		<div class="author-bio">
			<?php if ( get_the_author_meta( 'description', $user_id ) ) : ?>
				<div class="author-description">
					<?php echo ( get_the_author_meta( 'description', $user_id ) ); ?>
				</div>
			<?php endif; ?>
			<div class="author-name">
				<a href="<?php echo esc_url( learn_press_user_profile_link( $user_id ) ); ?>">
					<?php echo esc_attr( $user->display_name ); ?>
				</a>
				<?php if ( get_the_author_meta( 'major', $user_id ) ) : ?>
					<div class="author-major">
						<p><?php the_author_meta( 'major' ); ?></p>
					</div>
				<?php endif; ?>
			</div>
		</div>

	</div>
</div>