<?php

/**
 * @author  khoapq
 * @created 8/9/2017
 *
 *          Display tab on landing page.
 *          overwrite path: learnpress/addons/tabs/landing-tab.php
 */

?>

<div class="custom-tab">
	<h3 class="tab-title">
		<?php echo esc_html( $args[0]['title'] ); ?>
	</h3>
	<div class="tab-content">
		<?php echo do_shortcode( $args[0]['tab_content'] ); ?>
	</div>
</div>
