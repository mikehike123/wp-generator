<?php
/**
 * Retrieve customer data from the database.
 *
 * @param int $id
 *
 * @return object
 */
function ac_get_customer( $id = 0 ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}customers WHERE id = %d", $id ) );
}

/**
 * Retrieve customers data from the database.
 *
 * @param int $per_page
 * @param int $page_number
 *
 * @return array
 */
function ac_get_customers( $args = null ) {
    global $wpdb;

    $defaults = [
        'number'  => 20,
        'offset'  => 0,
        'orderby' => 'id',
        'order'   => 'DESC',
        'count'   => false,
    ];

    $args = wp_parse_args( $args, $defaults );

    if ( $args['count'] ) {
        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}customers";
    } else {
        $sql = "SELECT * FROM {$wpdb->prefix}customers";
    }

    if ( ! empty( $args['s'] ) ) {
        $sql .= ' WHERE name LIKE "%' . esc_sql( $args['s'] ) . '%"' ;
    }

    if ( ! empty( $args['orderby'] ) ) {
        $sql .= ' ORDER BY ' . esc_sql( $args['orderby'] );
        $sql .= ! empty( $args['order'] ) ? ' ' . esc_sql( $args['order'] ) : ' ASC';
    }

    if ( $args['number'] != '-1' && ! $args['count'] ) {
        $sql .= ' LIMIT ' . $args['number'];
        $sql .= ' OFFSET ' . $args['offset'];
    }

    if ( $args['count'] ) {
        $result = $wpdb->get_var( $sql );
    } else {
        $result = $wpdb->get_results( $sql);
    }

    return $result;
}

/**
 * Delete a customer record.
 *
 * @param  int $id customer id
 *
 * @return boolean
 */
function ac_delete_customer( $id ) {
    global $wpdb;

    return $wpdb->delete(
        "{$wpdb->prefix}customers",
        [ 'id' => $id ],
        [ '%d' ]
    );
}

/**
 * Insert a new customers.
 *
 * @param boolean
 */
function ac_insert_customer( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'id' => null,
        'name' => '',
'email' => '',
'address' => '',
'city' => '',

    );

    $args       = wp_parse_args( $args, $defaults );
    $table_name = $wpdb->prefix . 'customers';

    // remove row id to determine if new or update
    $row_id = (int) $args['id'];
    unset( $args['id'] );

    if ( ! $row_id ) {
        $args['date'] = current_time( 'mysql' );

        // insert a new
        if ( $wpdb->insert( $table_name, $args ) ) {
            return $wpdb->insert_id;
        }
    } else {
        // do update method here
        if ( $wpdb->update( $table_name, $args, array( 'id' => $row_id ) ) ) {
            return $row_id;
        }
    }

    return false;
}