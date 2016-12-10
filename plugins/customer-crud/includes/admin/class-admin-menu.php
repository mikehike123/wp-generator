<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Admin Menu
 */
class Admin_Menu {
    /**
     * Constructor.
     *
     * @param void
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'plugin_menu' ) );

        include dirname( __FILE__ ) . '/../class-customers-list-table.php';
        include dirname( __FILE__ ) . '/class-form-handler.php';
        new Form_Handler();
    }

    /**
     * Registering plugin menu.
     *
     * @return void
     */
    public function plugin_menu() {
        $hook = add_menu_page(
            'Customer Crud',
            'Customer Crud',
            'manage_options',
            'customer-crud',
            array( $this, 'plugin_settings_page' ),
            'dashicons-groups', null
        );
    }

    /**
     * Plugin settings page.
     *
     * @return void
     */
    public function plugin_settings_page() {
        $action     = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id         = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;
        $template   = '';

        switch ($action) {
            case 'view':
                $template = dirname( __FILE__ ) . '/views/customer-single.php';
                break;

            case 'edit':
                $template = dirname( __FILE__ ) . '/views/customer-edit.php';
                break;

            case 'new':
                $template = dirname( __FILE__ ) . '/views/customer-new.php';
                break;

            default:
                $template = dirname( __FILE__ ) . '/views/customers.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include( $template );
        }
    }
}