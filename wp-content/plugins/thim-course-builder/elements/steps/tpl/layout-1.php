<?php
$unique_id = uniqid( 'thim_' );

$html_nav = $html_tab_content = $icon = '';

if ( $params['steps'] ):

	$active = 'active';
	foreach ( $params['steps'] as $key => $step ) {

		if ( $key != 0 ) {
			$active = '';
		}
		$tab_id    = $unique_id . '-step-' . $key;
		$step_text = ( strtolower( $params['circle-text'] ) == 'step' ) ? ( $key + 1 ) . '<span>' . $params['circle-text'] . '</span>' : '<span>' . $params['circle-text'] . '</span>' . ( $key + 1 );

		if ( isset( $step['icon'] ) ) {
			switch ( $step['icon'] ) {
				case 'upload_icon':
					if ( ! empty( $step['icon_upload'] ) ) {
						$id_icon_image = isset( $step['icon_upload']['id'] ) ? intval( $step['icon_upload']['id'] ) : intval( $step['icon_upload'] );
						if ( $id_icon_image ) {
							$icon_upload = wp_get_attachment_image_src( $id_icon_image, 'full' );
							$alt         = isset( $params['icon_title'] ) ? $params['icon_title'] : esc_attr__( 'Icon', 'course-builder' );
							$icon        = '<img class="image-upload" src="' . $icon_upload[0] . '" width="' . $icon_upload[1] . '" height="' . $icon_upload[2] . '" alt="' . $alt . '">';
						}
					}
					break;
				case 'font_ionicons':
					if ( ! empty( $step['font_ionicons'] ) ) {
						$icon = '<i class="step-icon icon-ionicons ' . $step['font_ionicons'] . '" aria-hidden="true"></i>';
					}
					break;
				default:
					if ( ! empty( $step['font_awesome'] ) ) {
						$icon = '<i class="step-icon icon-fontawesome ' . $step['font_awesome'] . '" aria-hidden="true"></i>';
					}
			}
		}

		if ( ! empty( $icon ) ) {
			$step_text = $icon;
		}

		if ( isset( $step['readmore'] ) ) {
			$step_link = '<a href="' . $step['readmore'] . '" class="readmore">' . esc_attr__( 'Read More', 'course-builder' ) . '</a>';
		}
		$html_nav         .= '<li class="nav-item"><a class="nav-link ' . $active . '" data-toggle="tab" href="#' . $tab_id . '" role="tab">' . $step_text . '</a></li>';
		$html_tab_content .= '<div class="tab-pane ' . $active . '" id="' . $tab_id . '" role="tabpanel">';
		if ( isset( $step['title_step'] ) ) {
			$html_tab_content .= '<h4 class="tab-title">' . $step['title_step'] . '</h4>';
		} elseif ( isset( $step['title'] ) ) {
			$html_tab_content .= '<h4 class="tab-title">' . $step['title'] . '</h4>';
		}
		if ( ! empty( $step['description_step'] ) ) {
			$html_tab_content .= '<p class="description">' . $step['description_step'] . '</p>';
		} elseif ( ! empty( $step['description'] ) ) {
			$html_tab_content .= '<p class="description">' . $step['description'] . '</p>';
		}
		if ( isset( $step_link ) ) {
			$html_tab_content .= $step_link;
		}
		$html_tab_content .= '</div>';
	}
endif;
?>
<div class="row">
    <div class="col-md-6 content-box">
        <div class="steps-wrapper">
			<?php if ( ! empty( $params['title'] ) ): ?>
                <h3 class="sc-title">
					<?php
					$title = wp_kses( $params['title'], array( 'br' => array() ) );
					echo( $title );
					?>
                </h3>
			<?php endif; ?>
			<?php if ( $params['description'] && ( $params['style_layout'] == 'style-02' ) ): ?>
                <div class="sub-title">
					<?php echo esc_html( $params['description'] ); ?>
                </div>
			<?php endif; ?>
            <div class="steps">
                <ul class="nav" role="tablist">
					<?php echo ent2ncr( $html_nav ); ?>
                </ul>
                <div class="tab-content">
					<?php echo ent2ncr( $html_tab_content ); ?>
                </div>
            </div>
        </div>
    </div>
	<?php if ( $params['image'] ): ?>
        <div class="col-md-6 media-box">
            <div class="media-wrapper">
				<?php
				$thumbnail_id = isset( $params['image']['id'] ) ? $params['image']['id'] : $params['image'];
				thim_thumbnail( $thumbnail_id, 'full', 'attachment', false ); ?>
            </div>
        </div>
	<?php endif; ?>
</div>