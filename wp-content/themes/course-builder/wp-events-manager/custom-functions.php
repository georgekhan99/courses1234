<?php

//Filter post_status tp_event
if ( ! function_exists( 'thim_get_upcoming_events' ) ) {
    function thim_get_upcoming_events( $args = array() ) {
        if ( is_tax( 'tp_event_category' ) ) {
            if ( version_compare( WPEMS_VER, '2.1.5', '>=' ) ) {
                $args = wp_parse_args(
                    $args,
                    array(
                        'post_type'  => 'tp_event',
                        'meta_query' => array(
                            array(
                                'key'     => 'tp_event_status',
                                'value'   => 'upcoming',
                                'compare' => '=',
                            ),
                        ),
                        'tax_query'  => array(
                            array(
                                'taxonomy' => 'tp_event_category',
                                'field'    => 'slug',
                                'terms'    => get_query_var( 'term' ),
                            )
                        ),
                    )
                );
            } else {
                $args = wp_parse_args(
                    $args,
                    array(
                        'post_type'   => 'tp_event',
                        'post_status' => 'tp-event-upcoming',
                        'tax_query'   => array(
                            array(
                                'taxonomy' => 'tp_event_category',
                                'field'    => 'slug',
                                'terms'    => get_query_var( 'term' ),
                            )
                        ),
                    )
                );
            }
        } else {
            if ( version_compare( WPEMS_VER, '2.1.5', '>=' ) ) {
                $args = wp_parse_args(
                    $args,
                    array(
                        'post_type'  => 'tp_event',
                        'meta_query' => array(
                            array(
                                'key'     => 'tp_event_status',
                                'value'   => 'upcoming',
                                'compare' => '=',
                            ),
                        ),
                    )
                );
            } else {
                $args = wp_parse_args(
                    $args,
                    array(
                        'post_type'   => 'tp_event',
                        'post_status' => 'tp-event-upcoming',
                    )
                );
            }
        }


        return new WP_Query( $args );
    }
}

if ( ! function_exists( 'thim_get_expired_events' ) ) {
    function thim_get_expired_events( $args = array() ) {
        if ( is_tax( 'tp_event_category' ) ) {
            if ( version_compare( WPEMS_VER, '2.1.5', '>=' ) ) {
                $args = wp_parse_args(
                    $args,
                    array(
                        'post_type'  => 'tp_event',
                        'meta_query' => array(
                            array(
                                'key'     => 'tp_event_status',
                                'value'   => 'expired',
                                'compare' => '=',
                            ),
                        ),
                        'tax_query'  => array(
                            array(
                                'taxonomy' => 'tp_event_category',
                                'field'    => 'slug',
                                'terms'    => get_query_var( 'term' ),
                            )
                        ),
                    )
                );
            } else {
                $args = wp_parse_args(
                    $args,
                    array(
                        'post_type'   => 'tp_event',
                        'post_status' => 'tp-event-expired',
                        'tax_query'   => array(
                            array(
                                'taxonomy' => 'tp_event_category',
                                'field'    => 'slug',
                                'terms'    => get_query_var( 'term' ),
                            )
                        ),
                    )
                );
            }
        } else {
            if ( version_compare( WPEMS_VER, '2.1.5', '>=' ) ) {
                $args = wp_parse_args(
                    $args,
                    array(
                        'post_type'  => 'tp_event',
                        'meta_query' => array(
                            array(
                                'key'     => 'tp_event_status',
                                'value'   => 'expired',
                                'compare' => '=',
                            ),
                        ),
                    )
                );
            } else {
                $args = wp_parse_args(
                    $args,
                    array(
                        'post_type'   => 'tp_event',
                        'post_status' => 'tp-event-expired',
                    )
                );
            }
        }

        return new WP_Query( $args );
    }
}

if ( ! function_exists( 'thim_get_happening_events' ) ) {
    function thim_get_happening_events( $args = array() ) {
        if ( is_tax( 'tp_event_category' ) ) {
            if ( version_compare( WPEMS_VER, '2.1.5', '>=' ) ) {
                $args = wp_parse_args(
                    $args,
                    array(
                        'post_type'  => 'tp_event',
                        'meta_query' => array(
                            array(
                                'key'     => 'tp_event_status',
                                'value'   => 'happening',
                                'compare' => '=',
                            ),
                        ),
                        'tax_query'  => array(
                            array(
                                'taxonomy' => 'tp_event_category',
                                'field'    => 'slug',
                                'terms'    => get_query_var( 'term' ),
                            )
                        ),
                    )
                );
            } else {
                $args = wp_parse_args(
                    $args,
                    array(
                        'post_type'   => 'tp_event',
                        'post_status' => 'tp-event-happenning',
                        'tax_query'   => array(
                            array(
                                'taxonomy' => 'tp_event_category',
                                'field'    => 'slug',
                                'terms'    => get_query_var( 'term' ),
                            )
                        ),
                    )
                );
            }
        } else {
            if ( version_compare( WPEMS_VER, '2.1.5', '>=' ) ) {
                $args = wp_parse_args(
                    $args,
                    array(
                        'post_type'  => 'tp_event',
                        'meta_query' => array(
                            array(
                                'key'     => 'tp_event_status',
                                'value'   => 'happening',
                                'compare' => '=',
                            ),
                        ),
                    )
                );
            } else {
                $args = wp_parse_args(
                    $args,
                    array(
                        'post_type'   => 'tp_event',
                        'post_status' => 'tp-event-happenning',
                    )
                );
            }
        }

        return new WP_Query( $args );
    }
}

/**
 * Hook get template archive event
 */
if ( ! function_exists( 'thim_archive_event_template' ) ) {
    function thim_archive_event_template( $template ) {
        if ( get_post_type() == 'tp_event' && is_post_type_archive( 'tp_event' ) || is_tax( 'tp_event_category' ) ) {
            $GLOBALS['thim_happening_events'] = thim_get_happening_events();
            $GLOBALS['thim_upcoming_events']  = thim_get_upcoming_events();
            $GLOBALS['thim_expired_events']   = thim_get_expired_events();
        }

        return $template;
    }
}
add_action( 'template_include', 'thim_archive_event_template' );
/**
 * Add navigation
 */
add_action( 'tp_event_after_event_loop', 'thim_paging_nav' );

// Set posts_per_page for Event archive
function thim_set_event_per_page( $query ) {

	if ( is_post_type_archive( 'tp_event' ) ) {
		$posts_per_page = 1000;
		$query->set( 'posts_per_page', $posts_per_page );

		return;
	}
}

add_action( 'pre_get_posts', 'thim_set_event_per_page', 1 );