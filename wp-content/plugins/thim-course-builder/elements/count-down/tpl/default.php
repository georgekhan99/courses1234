<?php $data = esc_attr( $params['time'] ); ?>
<div class="thim-sc-count-down <?php echo esc_attr( $params['el_class'] ); ?>" data-countdown="<?php echo date_format( date_create( esc_attr( $data ) ), ( 'Y/m/d H:i' ) ); ?>">
	<div class="title"><?php echo ( isset( $params['title'] ) ) ? esc_attr( $params['title'] ) : '' ?><?php echo ' ' . date_format( date_create( esc_attr( $data ) ), ( 'D M jS H:i' ) ); ?> </div>
	<div class="counter <?php echo esc_attr($params['style']) ?>">
		<?php
			if ( $params['style'] == 'style2') {?>
				<div class="days count-item">
					<span class="label"><?php esc_html_e( 'Day(s)', 'course-builder' ); ?></span>
					<span class="number"></span>
				</div>
				<div class="hours count-item">
					<span class="label"><?php esc_html_e( 'Hour(s)', 'course-builder' ); ?></span>
					<span class="number"></span>
				</div>
				<div class="minutes count-item">
					<span class="label"><?php esc_html_e( 'Minute(s)', 'course-builder' ); ?></span>
					<span class="number"></span>
				</div>
				<div class="seconds count-item">
					<span class="label"><?php esc_html_e( 'Second(s)', 'course-builder' ); ?></span>
					<span class="number"></span>
				</div>
		<?php } else { ?>
				<div class="days count-item">
					<span class="number"></span>
					<span class="label"><?php esc_html_e( 'Day(s)', 'course-builder' ); ?></span>
				</div>
				<div class="hours count-item">
					<span class="number"></span>
					<span class="label"><?php esc_html_e( 'Hour(s)', 'course-builder' ); ?></span>
				</div>
				<div class="minutes count-item">
					<span class="number"></span>
					<span class="label"><?php esc_html_e( 'Minute(s)', 'course-builder' ); ?></span>
				</div>
				<div class="seconds count-item">
					<span class="number"></span>
					<span class="label"><?php esc_html_e( 'Second(s)', 'course-builder' ); ?></span>
				</div>
			<?php }
		?>
	</div>
</div>

