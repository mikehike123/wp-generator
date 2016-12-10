<?php

/**
 * Admin Form Handler.
 *
 * Handle all form's submissions
 */
class Form_Handler {
    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'admin_init', [ $this, 'handle_customers_form_submit' ] );
        add_action( 'admin_init', [ $this, 'handle_customers_bulk_action' ] );
    }

    /**
     * Handles form data when submitted.
     *
     * @return void
     */
    public function handle_customers_form_submit() {
        if ( ! isset( $_POST['submit_customer'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'ac_new_customer' ) ) {
            wp_die( __( 'Go get a life script kiddies', 'appzcoder' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', 'appzcoder' ) );
        }

        $errors   = array();
        $page_url = menu_page_url( 'customer-crud', false );
        $field_id = isset( $_POST['field_id'] ) ? absint( $_POST['field_id'] ) : 0;

        $name = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
$email = isset( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : '';
$address = isset( $_POST['address'] ) ? wp_kses_post( $_POST['address'] ) : '';
$city = isset( $_POST['city'] ) ? sanitize_text_field( $_POST['city'] ) : '';


        $fields = array(
            'name' => $name,
'email' => $email,
'address' => $address,
'city' => $city,

        );

        // New or edit?
        if ( ! $field_id ) {
            $insert_id = ac_insert_customer( $fields );
        } else {
            $fields['id'] = $field_id;

            $insert_id = ac_insert_customer( $fields );
        }

        if ( is_wp_error( $insert_id ) ) {
            $redirect_to = add_query_arg( array( 'message' => 'error' ), $page_url );
        } else {
            $redirect_to = add_query_arg( array( 'message' => 'success' ), $page_url );
        }

        // Redirect
        wp_redirect( $redirect_to );
        exit;
    }

    /**
     * Handles bulk action and delete.
     *
     * @return void
     */
    public function handle_customers_bulk_action() {
        $page_url = menu_page_url( 'customer-crud', false );

        // Detect when a bulk action is being triggered...
        if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'delete' ) {
            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST['_wpnonce'] );

            if ( ! wp_verify_nonce( $nonce, 'ac_delete_customer' ) ) {
                die( 'Go get a life script kiddies' );
            } else {
                ac_delete_customer( absint( $_REQUEST['id'] ) );

                // Redirect
                $query = array( 'message' => 'deleted');
                $redirect_to = add_query_arg( $query, $page_url );
                wp_redirect( $redirect_to );
                exit;
            }
        }

        // If the delete bulk action is triggered
        if ( ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'bulk-delete' )
             || ( isset( $_REQUEST['action2'] ) && $_REQUEST['action2'] == 'bulk-delete' )
        ) {
            $delete_ids = esc_sql( $_REQUEST['bulk-delete'] );

            // loop over the array of record ids and delete them
            foreach ( $delete_ids as $id ) {
                ac_delete_customer( $id );
            }

            // Redirect
            $query = array( 'message' => 'deleted');
            $redirect_to = add_query_arg( $query, $page_url );
            wp_redirect( $redirect_to );
            exit;
        }
    }
}