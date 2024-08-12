<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$wtnShowMessage = false;
if ( isset( $_POST['updateSettings'] ) ) {
    $wtnShowMessage = $this->wtn_delete_transients_with_prefix( 'wtn_api_cached_data_' );
}

if ( isset( $_POST['updateCachingTime'] ) ) {
    $wtn_caching_time = ( isset( $_POST['wtn_caching_time'] ) ? sanitize_text_field( $_POST['wtn_caching_time'] ) : '24' );
    $wtnShowMessage = update_option( 'wtn_caching_time', $wtn_caching_time );
}

$wtn_caching_time = get_option( 'wtn_caching_time' );
?>
<div id="wph-wrap-all" class="wrap">
    
    <div class="settings-banner">
        <h2><i class="fa fa-hdd-o" aria-hidden="true"></i>&nbsp;<?php 
_e( 'Manage Cache', WTN_TXT_DMN );
?></h2>
    </div>

    <?php 
if ( $wtnShowMessage ) {
    $this->wtn_display_notification( 'success', __( 'Cache Cleared Successfully', WTN_TXT_DMN ) );
}
?>

    <div class="wtn-wrap">

            <div class="wtn_personal_wrap wtn_personal_help" style="width: 75%; float: left; margin-top: 5px;">
                <?php 

if ( wtn_fs()->is_not_paying() ) {
    ?>
                    <span><?php 
    echo  '<a href="' . wtn_fs()->get_upgrade_url() . '">' . __( 'Please Upgrade Now to Clear Cache!', WTN_TXT_DMN ) . '</a>' ;
    ?></span>
                    <?php 
}

?>
                <form name="wpre-table" role="form" class="form-horizontal" method="post" action="" id="wtn-caching-time-form">
                    <table class="wtn-general-settings">
                    <tr>
                        <th scope="row">
                            <label><?php 
_e( 'Caching Time', WTN_TXT_DMN );
?>:</label>
                        </th>
                        <td>
                        <?php 

if ( wtn_fs()->is_not_paying() ) {
    ?>
                            <span><?php 
    echo  '<a href="' . wtn_fs()->get_upgrade_url() . '">' . __( 'Please Upgrade Now!', WTN_TXT_DMN ) . '</a>' ;
    ?></span>
                            <?php 
}

?>
                        </td>
                    </tr>
                    </table>
                    <code><?php 
_e( 'For free API users we recommend to set caching time to 24 Hours', WTN_TXT_DMN );
?></code>
                    <p class="submit"><button id="updateCachingTime" name="updateCachingTime" class="button button-primary wtn-button"><?php 
_e( 'Save Caching Time', WTN_TXT_DMN );
?></button></p>
                </form>
            </div>

            <?php 
$this->wtn_admin_sidebar();
?>

    </div>
</div>