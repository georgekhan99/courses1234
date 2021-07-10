<?php
/**
 * Footer template: Default
 *
 * @package Thim_Starter_Theme
 */

$class_default = '';
$thim_options  = get_theme_mods();

if ( ! is_active_sidebar( 'footer_sticky' ) ) {
	$class_default .= 'no-footer-sticky ';
}
?>

<div class="footer <?php echo esc_attr( $class_default ); ?>">
	<div class="container">
		<div class="row footer-columns footer-sidebars">
			<?php thim_footer_widgets() ?>
		</div>
	</div>
</div>

<?php if ( is_active_sidebar( 'footer_sticky' ) ) : ?>
	<div class="footer-fixed">
		<div class="container">
			<?php thim_footer_sticky_widgets(); ?>
		</div>
	</div>
<?php endif; ?>


<div class="copyright-area <?php echo esc_attr( $class_default ); ?>">
	<div class="container">
		<div class="copyright-content">
			<div class="row">
				<div class="<?php if ( get_theme_mod( 'copyright_menu', true ) ) { ?>col-sm-6<?php } else { ?>col-sm-12<?php } ?>">
					<?php thim_copyright_bar(); ?>
				</div>
				<?php if ( get_theme_mod( 'copyright_menu', true ) ) : ?>
					<div class="col-sm-6 text-right">
						<?php thim_copyright_menu(); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>