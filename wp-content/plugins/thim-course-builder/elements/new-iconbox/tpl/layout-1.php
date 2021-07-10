<?php
$title       = $params['title'];
$link_before = $link_after = $link_detail = $icon = '';

if ( $params['icon_link'] ) {
	if ( isset( $params['icon_link']['url'] ) && ! empty( $params['icon_link']['url'] ) ) {
		$link_detail           = $params['icon_link'];
		$link_detail['target'] = ( $params['icon_link']['is_external'] == 'on' ) ? ' target="_blank"' : '';
		$link_detail['rel']    = ( $params['icon_link']['nofollow'] == 'on' ) ? ' rel="nofollow"' : '';
		$link_output           = $link_detail['target'] . $link_detail['rel'];
	} elseif ( ! is_array( $params['icon_link'] ) ) {
		$link_detail           = vc_build_link( $params['icon_link'] );
		$link_detail['target'] = $link_detail['target'] ? ' target="' . esc_attr( $link_detail['target'] ) . '"' : '';
		$link_detail['rel']    = $link_detail['rel'] ? ' rel="' . esc_attr( $link_detail['rel'] ) . '"' : '';
		$link_output           = $link_detail['target'] . $link_detail['rel'];
	}
}

if ( $link_detail ) {
	$link_before = '<a href="' . esc_attr( $link_detail['url'] ) . '"' . $link_output . '>';
	$link_after  = '</a>';
}

$color = 'style="color:' . $params['primary_color'] . ';"';

switch ( $params['icon'] ) {
	case 'upload_icon':
		if ( $params['icon_upload'] ) {
			$id_icon_upload = isset( $params['icon_upload']['id'] ) ? intval( $params['icon_upload']['id'] ) : intval( $params['icon_upload'] );
			if ( $id_icon_upload ) {
				$icon_upload = wp_get_attachment_image_src( $id_icon_upload, 'full' );
				if($icon_upload){
                    $img_src     = $icon_upload[0];
                    $img_size    = ' width="' . $icon_upload[1] . '" height="' . $icon_upload[2] . '"';
                    $alt         = isset( $params['title'] ) ? $params['title'] : esc_attr__( 'Icon', 'course-builder' );
                    $icon        = '<img class="image-upload" src="' . $img_src . '"' . $img_size . ' alt="' . $alt . '">';
                }

			}
		}
		break;
	case 'font_ionicons':
		if ( $params['font_ionicons'] ) {
			$icon = '<i ' . $color . ' class="icon-ionicons ' . $params['font_ionicons'] . '" aria-hidden="true"></i>';
		}
		break;
	default:
		if ( $params['font_awesome'] ) {
			$icon = '<i ' . $color . ' class="icon-fontawesome ' . $params['font_awesome'] . '" aria-hidden="true"></i>';
		}
}
?>

<?php echo( $link_before ); ?>
<div class="icon-box">
	<?php echo $icon; ?>
</div>
<div class="title">
    <p>
		<?php echo $title; ?>
    </p>
</div>
<?php echo( $link_after ); ?>
