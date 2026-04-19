<?php
if ( ! post_type_exists( 'match' ) ) {
    return;
}

if ( function_exists( 'get_next_match_callback' ) ) {
    echo get_next_match_callback( 3, 3 );
}
