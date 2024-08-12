<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="wtn-wrap" style="padding-top:20px;">
    <div class="wtn_personal_wrap wtn_personal_help" style="width: 75%; float: left; margin-top: 5px; text-align: center;">
        <h1>WP Top News Video Tutorial</h1>
        <div class="help-link">
            <iframe width="800" height="450" src="https://www.youtube.com/embed/hfwet1ID0-A" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div style="width: 100%; text-align:left; padding-bottom:50px;">
            <hr>
            <h2><?php _e('Available Shortcoded Options For Pro Version', WTN_TXT_DMN); ?></h2>
            <hr>
            <h3>1. <?php _e('Display Grid View', WTN_TXT_DMN); ?></h3>
            <code>[wp_top_news layout='grid']</code>
            <br><br>
            <h3>2. <?php _e('Display List View', WTN_TXT_DMN); ?></h3>
            <code>[wp_top_news layout='list']</code>
            <br><br>
            <h3>3. <?php _e('Display News Ticker', WTN_TXT_DMN); ?></h3>
            <code>[wp_top_news layout='ticker']</code>
            <br><br>
            <h3>4. <?php _e('Control Display Number', WTN_TXT_DMN); ?></h3>
            <code>[wp_top_news display=10]</code>
            <br><br>
            <h3>5. <?php _e('Display With News Source', WTN_TXT_DMN); ?></h3>
            <code>[wp_top_news category='news' source='cnn']</code>
            <br><br>
            <div style="width: 500px; height:300px; overflow:scroll; text-align:left;">
                <span>There are 128 sources available. You can apply any of these sources.</span>
                <table width="100%" style="border: 1px solid #999;">
                <tr>
                    <td style="border: 1px solid #999;">#</td>
                    <td style="border: 1px solid #999; font-weight:600; font-size:16px;"><?php _e('Source', WTN_TXT_DMN); ?></td>
                    <td style="border: 1px solid #999; font-weight:600; font-size:16px;"><?php _e('Name', WTN_TXT_DMN); ?></td>
                    <td style="border: 1px solid #999; font-weight:600; font-size:16px;"><?php _e('Url', WTN_TXT_DMN); ?></td>
                </tr>
                    <?php
                    $sourcesJson = json_decode( file_get_contents( WTN_PATH . 'core/sources.json' ), true );
                    $sources = $sourcesJson['sources'];
                    //echo '<pre>';
                    //print_r( $sources );
                    $sc = 1;
                    foreach ( $sources as $source ) {
                        ?>
                        <tr>
                            <td style="border: 1px solid #999;"><?php printf('%d', $sc); ?></td>
                            <td style="border: 1px solid #999;"><?php esc_html_e( $source['id'] ); ?></td>
                            <td style="border: 1px solid #999;"><?php esc_html_e( $source['name'] ); ?></td>
                            <td style="border: 1px solid #999;"><?php esc_html_e( $source['url'] ); ?></td>
                        </tr>
                        <?php
                        $sc++;
                    }
                    ?>
                </table>
            </div>
            <h3>6. <?php _e('Display With Country', WTN_TXT_DMN); ?></h3>
            <code>[wp_top_news category='country' country='us']</code>
            <br><br>
            <div style="width: 500px; height:300px; overflow:scroll; text-align:left;">
                <span>There are 54 countries available. You can apply any of these countries.</span>
                <table width="100%" style="border: 1px solid #999;">
                <tr>
                    <td style="border: 1px solid #999;">#</td>
                    <td style="border: 1px solid #999; font-weight:600; font-size:16px;"><?php _e('Country', WTN_TXT_DMN); ?></td>
                    <td style="border: 1px solid #999; font-weight:600; font-size:16px;"><?php _e('Name', WTN_TXT_DMN); ?></td>
                </tr>
                    <?php
                    $countries = $this->wtn_news_countries();
                    $cc = 1;
                    foreach ( $countries as $code => $name ) {
                        ?>
                        <tr>
                            <td style="border: 1px solid #999;"><?php printf('%d', $cc); ?></td>
                            <td style="border: 1px solid #999;"><?php esc_html_e( $code ); ?></td>
                            <td style="border: 1px solid #999;"><?php esc_html_e( $name ); ?></td>
                        </tr>
                        <?php
                        $cc++;
                    }
                    ?>
                </table>
            </div>
            <h3>7. <?php _e('Hide Description', WTN_TXT_DMN); ?></h3>
            <code>[wp_top_news description='hide']</code>
            <br><br>
            <h3>8. <?php _e('Control Description Length', WTN_TXT_DMN); ?></h3>
            <code>[wp_top_news desc_length=12]</code>
        </div>
    </div>
    
    <?php $this->wtn_admin_sidebar(); ?>   
</div>