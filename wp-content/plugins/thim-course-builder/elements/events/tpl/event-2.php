<?php
$number_events = !empty( $params['number_events'] ) ? $params['number_events'] : 1;

$args = array(
    'post_type'      => 'tp_event',
    'posts_per_page' => $number_events,
    'order'          => $params['order'] == 'asc' ? 'asc' : 'desc',
);
switch ( $params['status_events'] ) {
    case 'upcoming':
        $args['meta_query'] = array(
            array(
                'key'     => 'tp_event_status',
                'value'   => 'upcoming',
                'compare' => '=',
            ),
        );
        break;
    case 'happening':
        $args['meta_query'] = array(
            array(
                'key'     => 'tp_event_status',
                'value'   => 'happening',
                'compare' => '=',
            ),
        );
        break;
    case 'expired':
        $args['meta_query'] = array(
            array(
                'key'     => 'tp_event_status',
                'value'   => 'expired',
                'compare' => '=',
            ),
        );
        break;
    case 'not-expired':
        $args['meta_query'] = array(
            array(
                'key'     => 'tp_event_status',
                'value'   => array( 'upcoming', 'happening' ),
                'compare' => 'IN',
            ),
        );
        break;
    default:
        $args['meta_query'] = array(
            array(
                'key'     => 'tp_event_status',
                'value'   => array( 'upcoming', 'happening', 'expired' ),
                'compare' => 'IN',
            ),
        );
}


switch ( $params['orderby'] ) {
    case 'time' :
        $args['orderby']  = 'meta_value';
        $args['meta_key'] = 'tp_event_date_end';
        break;
    case 'recent' :
        $args['orderby'] = 'post_date';
        break;
    case 'title' :
        $args['orderby'] = 'post_title';
        break;
    case 'popular' :
        $args['orderby'] = 'comment_count';
        break;
    default : //random
        $args['orderby'] = 'rand';
}


if ( $params['cat_events'] ) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'tp_event_category',
            'field'    => 'id',
            'terms'    => array( $params['cat_events'] ),
        ),
    );
}

$events = new WP_Query( $args );

$params['query'] = $events;
?>
<div class="row thim-sc-events owl-carousel owl-theme events-layer-2 <?php echo esc_attr( $params['el_class'] ); ?> " data-cols="1">
    <?php if ( $params['query']->have_posts() ) : ?>
        <?php while ( $params['query']->have_posts() ) : $params['query']->the_post(); ?>
            <div class="events">
                <div class="events-before">
                    <div class="content-inner">
                        <div class="date">
                            <span class="date-start"><?php echo( wpems_event_start( 'd' ) ); ?></span>
                            <span class="month-start"><?php echo( wpems_event_start( 'M Y' ) ); ?></span>
                        </div>
                        <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <div class="time-location">
                                <span class="time">
                                    <i class="ion-android-alarm-clock"></i> <?php echo( wpems_event_start( get_option( 'date_format' ) ) ); ?> - <?php echo( wpems_event_end( get_option( 'date_format' ) ) ); ?>
                                </span>
                            <?php if ( wpems_event_location() ) { ?>
                                <span class="location">
                                        <i class="ion-ios-location"></i> <?php echo( wpems_event_location() ); ?>
                                    </span>
                            <?php } ?>
                        </div>
                        <div class="line"></div>
                        <a href="<?php the_permalink(); ?>"><p class="description">
                                <?php echo wp_trim_words( get_the_content(), 35 ); ?>
                            </p></a>
                        <div class="author">
                            <?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
                            <div class="author-contain">
                                <span class="jobTitle"><?php esc_html_e( 'Host', 'course-builder' ); ?></span>
                                <span class="name">
                                            <a href="<?php echo esc_url( get_author_posts_url( $params['query']->post->post_author ) ); ?>">
                                                <?php echo get_the_author(); ?>
                                            </a>
                                        </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="events-after">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="thumbnail">
                            <?php thim_thumbnail( get_the_ID(), '342x381', 'post', true ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>
