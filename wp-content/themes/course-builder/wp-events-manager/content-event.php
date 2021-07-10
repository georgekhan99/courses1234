<?php
$date_format  = get_option( 'date_format' );
$time_format  = get_option( 'time_format' );

$time_start   = wpems_event_start( $time_format );
$time_end     = wpems_event_end( $time_format );

$location   = wpems_event_location();
$date_show  = wpems_get_time( $date_format );
$month_show = wpems_get_time( $date_format );

?>
<div <?php post_class(); ?>>
    <div class="tm-flex">
        <div class="col-lg-2 col-md-2">
            <div class="time-from">
                <div class="date">
			        <?php echo esc_html( $date_show ); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-5">
            <div class="event-content">
                <h5 class="title">
                    <a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>"> <?php echo get_the_title(); ?></a>
                </h5>

                <div class="meta">
                    <span class="time">
                        <i class="fa fa-clock-o"></i>
				        <?php echo esc_html( $time_start ) . ' - ' . esc_html( $time_end ); ?>
                    </span>
                    <span class="location">
                        <i class="fa fa-map-marker"></i>
				        <?php echo ent2ncr( $location ); ?>
                    </span>
                </div>
                <div class="description">
			        <?php echo the_excerpt(); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-5">
	        <?php
	        if ( has_post_thumbnail() ) {
		        echo '<div class="image"><a href="'. esc_url( get_permalink( get_the_ID() ) ) .'">';
		        thim_thumbnail( get_the_ID(), '450x270' );
		        echo '</a></div>';
	        }
	        ?>
        </div>

    </div>
</div>
