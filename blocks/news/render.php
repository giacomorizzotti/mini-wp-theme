<?php
if ( ! post_type_exists( 'news' ) ) {
    return;
}

if ( function_exists( 'get_latest_news_callback' ) ) {
    echo get_latest_news_callback();
}
