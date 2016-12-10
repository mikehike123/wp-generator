<?php
// Exit if not defined uninstall
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
    exit();

function uninstall_customer_crud() {
    global $wpdb;

    $table_name = $wpdb->prefix . "customers";
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}

uninstall_customer_crud();