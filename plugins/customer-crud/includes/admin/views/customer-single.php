<?php
$item = ac_get_customer( $id );
?>

<div class="wrap">
    <h1><?php _e( 'Customer', 'appzcoder' ); ?></h1>

        <table class="form-table">
            <tbody>
                <?php var_dump($item); ?>
            </tbody>
        </table>

    </form>
</div>