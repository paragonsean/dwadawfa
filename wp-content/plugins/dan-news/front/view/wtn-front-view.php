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
$wtnDesc = '';
$wtn_news_arr = $this->wtn_get_api_data( 'news', $wtn_select_source, '' );
$wtn_news_init_stdclass = ( !empty($wtn_news_arr) ? $wtn_news_arr : [] );
//print_r($wtn_news_init_stdclass);
?>
<style>
.wtn-main-wrapper {
    grid-template-columns: repeat(<?php 
esc_html_e( $wtn_grid_columns );
?>, 1fr);
}
@media(max-width:500px) {
    .wtn-main-wrapper {
       grid-template-columns: repeat(1, 1fr);
    }
}
</style>
<?php 

if ( !empty($wtn_news_init_stdclass) ) {
    
    if ( 'error' === $wtn_news_init_stdclass['status'] ) {
        echo  $wtn_news_init_stdclass['message'] ;
    } else {
        if ( 'list' === $wtn_layout ) {
            include WTN_PATH . 'view/list.php';
        }
        if ( 'grid' === $wtn_layout ) {
            include WTN_PATH . 'view/grid.php';
        }
        if ( 'ticker' === $wtn_layout ) {
            include WTN_PATH . 'view/ticker.php';
        }
    }

} else {
    _e( 'No Data Available', WTN_TXT_DMN );
}
