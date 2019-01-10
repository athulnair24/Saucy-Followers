<?php

function fdfp_update_user_table( $column ) {
    $column['followers'] = 'Followers';
    $column['following'] = 'Following';
    return $column;
}
add_filter( 'manage_users_columns', 'fdfp_update_user_table' );

function fdfp_update_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'followers' :
            return fdfp_get_follower_count( $user_id );
            break;
        case 'following' :
            return fdfp_get_following_count( $user_id );
            break;
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'fdfp_update_user_table_row', 10, 3 );