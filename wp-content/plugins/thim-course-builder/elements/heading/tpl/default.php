<?php
/**
 * Shortcode Heading
 *
 * @param $atts
 *
 * @return string
 */

$heading_icon_url      = '';
$primary_heading_style = 'color: ' . $params['font_color'] . '; font-size: ' . $params['font_size'] . 'px; font-weight: ' . $params['font_weight'] . '; font-style: ' . $params['font_style'] . ';';

switch ( $params['heading_style'] ) {
	case 'layout-2':
		$underline = $params['separator'];
		$separator = false;
		break;
	default:
		$separator = $params['separator'];
		$underline = false;
		if ( ! empty( $params['heading_icon'] ) ) {
			$id_heading_icon = isset( $params['heading_icon']['id'] ) ? intval( $params['heading_icon']['id'] ) : intval( $params['heading_icon'] );
			if ( $id_heading_icon ) {
				$heading_icon_url = wp_get_attachment_image_src( $id_heading_icon, 'full', true );
				$heading_icon_url = $heading_icon_url[0];
			}
		} else {
			$heading_icon_url = get_template_directory_uri() . '/assets/images/icon-heading.png';
		}
		break;
}

?>
<div
        class="thim-sc-heading <?php echo 'text-' . esc_attr( $params['heading_position'] ); ?> <?php echo esc_attr( $params['heading_style'] ); ?> <?php echo esc_attr( $params['el_class'] ); ?>">
    <div class="heading-content">

		<?php
		if ( $params['heading_style'] == 'default' ) {
			if ( $separator ) {
				?>
                <div class="border border-top"></div>
                <img src="<?php echo esc_url( $heading_icon_url ); ?>" alt="separator"></span>
                <div class="border border-bottom"></div>
				<?php
			} else {
				?>
                <img src="<?php echo esc_url( $heading_icon_url ); ?>" alt="separator"></span>
				<?php
			}
		}
		?>

		<?php
		// Primary Heading
		if ( $params['primary_heading'] ) {
			if ( $params['heading_custom'] != 'yes' ) {
				echo '<' . $params['tag'] . ' class="primary-heading">' . ent2ncr( $params['primary_heading'] ) . '</' . $params['tag'] . '>';
			} else {
				echo '<' . $params['tag'] . ' class="primary-heading" style="' . esc_attr( $primary_heading_style ) . '">' . ent2ncr( $params['primary_heading'] ) . '</' . $params['tag'] . '>';
			}
		}

		if ( $params['primary_heading_2'] && $params['heading_style'] == 'layout-kit' ) {
			if ( $params['heading_custom'] != 'custom' ) {
				echo '<' . $params['tag'] . ' class="primary-heading-2">' . ent2ncr( $params['primary_heading_2'] ) . '</' . $params['tag'] . '>';
			} else {
				echo '<' . $params['tag'] . ' class="primary-heading-2" style="' . esc_attr( $primary_heading_style ) . '">' . ent2ncr( $params['primary_heading_2'] ) . '</' . $params['tag'] . '>';
			}
		}
		?>
    </div>
	<?php if ( $params['secondary_heading'] ) : ?>
        <p class="secondary-heading">
			<?php echo $params['secondary_heading']; ?>
        </p>
	<?php endif; ?>
	<?php if ( $underline ): ?>
        <span class="underline"></span>
	<?php endif; ?>
</div>
