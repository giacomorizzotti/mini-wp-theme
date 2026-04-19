<?php
if ( ! post_type_exists( 'course' ) ) {
    return;
}

if ( function_exists( 'get_courses_callback' ) ) {
    $count    = isset( $attributes['count'] )    ? absint( $attributes['count'] ) : 6;
    $cols_map = [ '100' => 1, '50' => 2, '33' => 3 ];
    $cols_str = isset( $attributes['columns'] )  ? (string) $attributes['columns'] : '33';
    $cols     = isset( $cols_map[ $cols_str ] )  ? $cols_map[ $cols_str ] : 3;
    echo get_courses_callback( $count, $cols, [
        'categoryId'   => isset( $attributes['categoryId'] )   ? absint( $attributes['categoryId'] )   : 0,
        'order'        => isset( $attributes['order'] )        ? $attributes['order']                  : 'ASC',
        'showLocation' => isset( $attributes['showLocation'] ) ? (bool) $attributes['showLocation']    : true,
        'showLessons'  => isset( $attributes['showLessons'] )  ? (bool) $attributes['showLessons']     : false,
    ] );
}
