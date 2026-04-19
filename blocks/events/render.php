<?php
if ( ! post_type_exists( 'event' ) ) {
    return;
}

if ( function_exists( 'get_next_event_callback' ) ) {
    $count     = isset( $attributes['count'] )   ? absint( $attributes['count'] ) : 3;
    $cols_map  = [ '100' => 1, '50' => 2, '33' => 3, '25' => 4, '20' => 5, '16' => 6 ];
    $cols_str  = isset( $attributes['columns'] ) ? (string) $attributes['columns'] : '33';
    $cols      = isset( $cols_map[ $cols_str ] ) ? $cols_map[ $cols_str ] : 3;
    echo get_next_event_callback( $count, $cols, [
        'upcomingOnly' => isset( $attributes['upcomingOnly'] ) ? (bool) $attributes['upcomingOnly'] : true,
        'categoryId'   => isset( $attributes['categoryId'] )   ? absint( $attributes['categoryId'] )   : 0,
        'order'        => isset( $attributes['order'] )        ? $attributes['order']                  : 'ASC',
        'showLocation' => isset( $attributes['showLocation'] ) ? (bool) $attributes['showLocation']    : true,
    ] );
}
