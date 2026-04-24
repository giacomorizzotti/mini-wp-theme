<?php
if ( function_exists( 'mini_post_grid_callback' ) ) {
    $count    = isset( $attributes['count'] )   ? absint( $attributes['count'] )   : 6;
    $cols_map = [ '100' => 1, '50' => 2, '33' => 3, '25' => 4, '20' => 5, '16' => 6 ];
    $cols_str = isset( $attributes['columns'] ) ? (string) $attributes['columns']  : '33';
    $cols     = isset( $cols_map[ $cols_str ] ) ? $cols_map[ $cols_str ]            : 3;
    echo mini_post_grid_callback( $count, $cols, [
        'categoryId'     => isset( $attributes['categoryId'] )     ? absint( $attributes['categoryId'] )   : 0,
        'order'          => isset( $attributes['order'] )          ? $attributes['order']                  : 'DESC',
        'highlightFirst' => isset( $attributes['highlightFirst'] ) ? (bool) $attributes['highlightFirst'] : false,
    ] );
}
