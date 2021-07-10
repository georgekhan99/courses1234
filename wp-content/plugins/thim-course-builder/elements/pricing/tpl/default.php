<?php

$column  = 'col-md-4';
$columns = empty( $params["columns"] ) ? '3' : $params["columns"];
$column  = 'col-md-' . ( 12 / $columns );

?>

<div class="thim-sc-pricing <?php echo esc_attr( $params["el_class"] ); ?>">
    <div class="pricing-wrapper">
        <div class="row">
            <?php foreach ($params['pricing'] as $key => $pricing) : ?>

                <div class="pricing-item <?php echo esc_attr($column); ?>">
	                <div class="package"><?php echo $pricing['package']; ?></div>
                    <div class="content">
                        <div class="price">
                            <span class="amount">
                                 <?php if (isset($pricing['price'])) {
                                     echo esc_html($pricing['price']);
                                 } ?>
                            </span>
                            <span class="interval">
                                 <?php if (isset($pricing['unit'])) {
                                     echo esc_html($pricing['unit']);
                                 } ?>
                            </span>
                        </div>

	                    <div class="features">
		                    <?php if (isset($pricing['features'])) {
			                    echo $pricing['features'];
		                    } ?>
	                    </div>


                        <?php if (isset($pricing['button_link']) && isset($pricing['button_text'])): ?>
                            <div class="select">
                                <a target="_blank"
                                   href="<?php echo esc_url($pricing['button_link']) ?>"><?php echo esc_html($pricing['button_text']); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
