<?php
if ( ! post_type_exists( 'match' ) || ! function_exists( 'get_next_match_callback' ) ) {
    return;
}

$count   = ! empty( $attributes['count'] )      ? absint( $attributes['count'] )         : 6;
$columns = ! empty( $attributes['columns'] )    ? sanitize_key( $attributes['columns'] ) : '33';
$opts    = [
    'order'      => ( isset( $attributes['order'] ) && $attributes['order'] === 'ASC' ) ? 'ASC' : 'DESC',
    'categoryId' => ! empty( $attributes['categoryId'] ) ? absint( $attributes['categoryId'] ) : 0,
];

echo get_next_match_callback( $count, $columns, $opts );
