<div class="wrap">
    <h2><?php _e( 'Customers', 'appzcoder' ); ?> <?php echo sprintf( '<a href="?page=%s&action=%s" class="add-new-h2">Add New</a>',  esc_attr( $_REQUEST['page'] ), 'new' ); ?></h2>

    <form method="post">
        <input type="hidden" name="page" value="customers">
        <?php
            $customers_list_table = new Customers_List_Table();
            $customers_list_table->prepare_items();
            $customers_list_table->search_box( __( 'Search', 'appzcoder' ), 'customers' );
            $customers_list_table->display();
        ?>
    </form>
</div>