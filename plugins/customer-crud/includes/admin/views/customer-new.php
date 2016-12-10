<div class="wrap">
    <h1><?php _e( 'Add Customer', 'appzcoder' ); ?></h1>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                                        <tr class="row-name">
                            <th scope="row">
                                <label for="name"><?php _e( 'Name', 'appzcoder' ); ?></label>
                            </th>
                            <td>
                                <input type="text" name="name" id="name" class="regular-text" value="" required="required" />
                            </td>
                        </tr>                        <tr class="row-email">
                            <th scope="row">
                                <label for="email"><?php _e( 'Email', 'appzcoder' ); ?></label>
                            </th>
                            <td>
                                <input type="email" name="email" id="email" class="regular-text" value="" required="required" />
                            </td>
                        </tr>                        <tr class="row-address">
                            <th scope="row">
                                <label for="address"><?php _e( 'Address', 'appzcoder' ); ?></label>
                            </th>
                            <td>
                                <textarea name="address" id="address"  rows="5" cols="30" ></textarea>
                            </td>
                        </tr>                        <tr class="row-city">
                            <th scope="row">
                                <label for="city"><?php _e( 'City', 'appzcoder' ); ?></label>
                            </th>
                            <td>
                                <input type="text" name="city" id="city" class="regular-text" value=""  />
                            </td>
                        </tr>
            </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( 'ac_new_customer' ); ?>
        <?php submit_button( __( 'Add Customer', 'appzcoder' ), 'primary', 'submit_customer' ); ?>

    </form>
</div>