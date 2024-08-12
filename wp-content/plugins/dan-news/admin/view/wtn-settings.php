<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
//print_r( $wtnGeneralSettings );
foreach ( $wtnGeneralSettings as $option_name => $option_value ) {
    if ( isset( $wtnGeneralSettings[$option_name] ) ) {
        ${"" . $option_name} = $option_value;
    }
}
?>
<div id="wph-wrap-all" class="wrap">

     <div class="settings-banner">
          <h2><i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;&nbsp;<?php 
_e( 'General Settings', WTN_TXT_DMN );
?></h2>
     </div>
     
     <?php 
if ( $wtnShowMessage ) {
    $this->wtn_display_notification( 'success', 'Your information updated successfully.' );
}
?>

     <div class="wtn-wrap">

          <div class="wtn_personal_wrap wtn_personal_help" style="width: 75%; float: left; margin-top: 5px;">

               <form name="wpre-table" role="form" class="form-horizontal" method="post" action="" id="wtn-settings-form">
                    <table class="wtn-general-settings">
                    <tr>
                         <th scope="row" style="vertical-align:top ;">
                              <label><?php 
_e( 'News Source', WTN_TXT_DMN );
?>:</label>
                         </th>
                         <td>
                              <div class="wtn-template-selector">
                                   <?php 
$wtnNewsSourceArray = $this->wtn_news_sources();
$i = 1;
foreach ( $wtnNewsSourceArray as $source => $name ) {
    ?>
                                        <div class="wtn-template-item">
                                             <input type="radio" name="wtn_select_source" id="<?php 
    esc_attr_e( $name );
    ?>" value="<?php 
    esc_attr_e( $source );
    ?>" <?php 
    echo  ( $wtn_select_source === $source ? 'checked' : '' ) ;
    ?>>
                                             <label for="<?php 
    esc_attr_e( $name );
    ?>" class="wtn-template">
                                                  <?php 
    esc_html_e( $name );
    ?>
                                             </label>
                                        </div>
                                        <?php 
    $i++;
}
?>
                              </div>
                         </td>
                    </tr>
                    <tr>
                         <th scope="row">
                              <label><?php 
_e( 'Number of News', WTN_TXT_DMN );
?>:</label>
                         </th>
                         <td>
                              <input type="number" min="1" max="10" step="1" name="wtn_news_number" class="medium-text" min="1" max="10" value="<?php 
esc_attr_e( $wtn_news_number );
?>">
                         </td>
                    </tr>
                    <tr>
                         <th scope="row">
                                   <label><?php 
_e( 'Layout', WTN_TXT_DMN );
?>:</label>
                         </th>
                         <td>
                              <input type="radio" name="wtn_layout" id="wtn_layout_list" value="list" <?php 
if ( 'list' === $wtn_layout ) {
    echo  'checked' ;
}
?>>
                              <label for="wtn_layout_list"><span></span><?php 
_e( 'List', WTN_TXT_DMN );
?></label>
                              &nbsp;&nbsp;&nbsp;&nbsp;
                              <input type="radio" name="wtn_layout" id="wtn_layout_grid" value="grid" <?php 
if ( 'grid' === $wtn_layout ) {
    echo  'checked' ;
}
?>>
                              <label for="wtn_layout_grid"><span></span><?php 
_e( 'Grid', WTN_TXT_DMN );
?></label>
                              &nbsp;&nbsp;&nbsp;&nbsp;
                              <?php 

if ( wtn_fs()->is_not_paying() ) {
    ?>
                                   <span><?php 
    echo  '<a href="' . wtn_fs()->get_upgrade_url() . '">' . __( 'For Ticker Upgrade Now!', WTN_TXT_DMN ) . '</a>' ;
    ?></span>
                                   <?php 
}

?>
                         </td>
                    </tr>
                    <tr>
                         <th scope="row">
                              <label><?php 
_e( 'Grid View Columns', WTN_TXT_DMN );
?>:</label>
                         </th>
                         <td>
                              <input type="number" name="wtn_grid_columns" class="medium-text" min="1" max="3" step="1" value="<?php 
esc_attr_e( $wtn_grid_columns );
?>">
                         </td>
                    </tr>
                    <tr>
                         <th scope="row">
                              <label for="wtn_enable_rtl"><?php 
_e( 'Ticker Type', WTN_TXT_DMN );
?>?</label>
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
                    <tr>
                         <th scope="row">
                              <label><?php 
_e( 'Title Word Length', WTN_TXT_DMN );
?>:</label>
                         </th>
                         <td>
                              <input type="number" name="wtn_title_length" class="medium-text" min="1" max="50" step="1" value="<?php 
esc_attr_e( $wtn_title_length );
?>">
                         </td>
                    </tr>
                    <tr>
                         <th scope="row">
                              <label><?php 
_e( 'Description Word Length', WTN_TXT_DMN );
?>:</label>
                         </th>
                         <td>
                              <input type="number" name="wtn_desc_length" class="medium-text" min="1" max="100" step="1" value="<?php 
esc_attr_e( $wtn_desc_length );
?>">
                         </td>
                    </tr>
                    <tr>
                         <th scope="row">
                              <label for="wtn_display_news_source"><?php 
_e( 'Display Source', WTN_TXT_DMN );
?>:</label>
                         </th>
                         <td>
                              <input type="checkbox" name="wtn_display_news_source" id="wtn_display_news_source" value="1" <?php 
echo  ( '1' === $wtn_display_news_source ? 'checked' : '' ) ;
?> >
                         </td>
                    </tr>
                    <tr>
                         <th scope="row">
                              <label for="wtn_display_date"><?php 
_e( 'Display Date', WTN_TXT_DMN );
?>?</label>
                         </th>
                         <td>
                              <input type="checkbox" name="wtn_display_date" id="wtn_display_date" value="1" <?php 
echo  ( '1' === $wtn_display_date ? 'checked' : '' ) ;
?> >
                         </td>
                    </tr>
                    <tr>
                         <th scope="row">
                              <label for="wtn_enable_rtl"><?php 
_e( 'Enable RTL', WTN_TXT_DMN );
?>?</label>
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
                    <tr>
                         <th scope="row">
                              <label for="wtn_shortcode"><?php 
_e( 'Shortcode', WTN_TXT_DMN );
?>:</label>
                         </th>
                         <td>
                              <input type="text" name="wtn_shortcode" id="wtn_shortcode" class="regular-text" value="[wp_top_news]" readonly />
                         </td>
                    </tr>
                    </table>
                    <p class="submit"><button id="updateGeneralSettings" name="updateGeneralSettings" class="button button-primary wtn-button"><?php 
_e( 'Save Settings', WTN_TXT_DMN );
?></button></p>
               </form>

          </div>
          <?php 
$this->wtn_admin_sidebar();
?>

     </div>
</div>