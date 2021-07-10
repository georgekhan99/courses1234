<?php
/**
 * Created by PhpStorm.
 * User: khoapq
 * Date: 12/20/2016
 * Time: 4:07 PM
 */
?>
<?php if ( $params['title'] ) : ?>
	<h3 class="sc-title">
		<?php
		$category_link = $link_prefix = $link_sufix = '';
		if ( isset( $params['category'] ) && $params['category'] != '0' ) {
			$category_link = get_category_link( $params['category'] );
			if ( $category_link ) {
				$link_prefix .= '<a href="' . esc_url( $category_link ) . '">';
				$link_sufix .= '</a>';
			}
		}
		?>
		<span class="title">
			<?php echo ent2ncr( $link_prefix ); ?>
			<?php echo esc_html( $params['title'] ); ?>
			<?php echo ent2ncr( $link_sufix ); ?>
			<span class="line"></span>
		</span>
	</h3>
<?php endif; ?>