<div class="thim-sc-skills-bar <?php echo esc_attr( $params['el_class'] ); ?>">
	<?php if ( $params['skills_bar'] ): ?>
		<?php foreach ( $params['skills_bar'] as $skills_bar ): ?>
			<?php
			$style_title       = $style_numbertitle = '';
			$style_title       .= 'color:' . $skills_bar['color'];
			$style_numbertitle .= 'color:' . $skills_bar['numbertitle'];
			?>

			<div class="circle" data-value="<?php echo esc_attr( $skills_bar['number'] ) ?>" data-color="<?php echo esc_attr( $skills_bar['color'] ) ?>" data-emptyfill="<?php echo esc_attr( $skills_bar['emptyfill'] ) ?>" >
				<p class="number" style="<?php echo esc_attr( $style_numbertitle ); ?>"> <?php echo esc_html( $skills_bar['number'] ) ?> </p>
				<p class="title" style="<?php echo esc_attr( $style_title ); ?>"><?php echo esc_html( $skills_bar['title'] ) ?></p>
                <?php if ( isset($skills_bar['sub_title']) ) { ?>
				    <p class="sub-title" style="<?php echo esc_attr( $style_numbertitle ); ?>"><?php echo esc_html( $skills_bar['sub_title'] ) ?></p>
                <?php }  ?>
			</div>
		<?php endforeach; ?>
	<?php endif ?>
</div>