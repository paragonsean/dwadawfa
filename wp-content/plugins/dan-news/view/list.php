<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wtn-main-container">
    <?php 
    for( $i = 0; $i < $wtn_news_number; $i++ ) {
        $wtn_news = isset( $wtn_news_init_stdclass['articles'][ $i ] ) ? (array) $wtn_news_init_stdclass['articles'][ $i ] : [];
        //print_r($wtn_news);
        if ( isset( $wtn_news['urlToImage'] ) && ( '' != $wtn_news['urlToImage'] ) ) {
            ?>
            <div class="wtn-feed-container">
                <?php
                if ( ! $wtn_enable_rtl ) {
                    ?>
                    <div class="wtn-img-container">
                        <div class="wtn-img" style="background-image: url('<?php esc_attr_e( $wtn_news['urlToImage'] ); ?>');" ></div>
                    </div>
                    <?php
                }
                ?>    
                <div class="wtn-feeds">
                    <a href="<?php echo esc_url( $wtn_news['url'] ); ?>" target="_blank" class="wtn-feeds-title">
                        <?php echo esc_html( wp_trim_words( $wtn_news['title'], $wtn_title_length, '...' ) ); ?>
                    </a>
                    <?php
                        if ( $wtnDesc !== 'hide' ) {
                            ?>
                            <p class="wtn-feeds-description">
                                <?php echo esc_html( wp_trim_words( $wtn_news['description'], $wtn_desc_length, '...' ) ); ?>
                            </p>
                            <?php
                        }
                    ?>
                    <span>
                        <?php
                        if ( '1' === $wtn_display_news_source ) {
                            $wtn_source = (array) $wtn_news['source'];
                            echo '<i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;&nbsp;' . esc_html( $wtn_source['name'] );
                        }
                        if ( '1' === $wtn_display_date ) {
                            echo '&nbsp;&nbsp;<i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp;&nbsp;' . date( 'd M, Y', strtotime( $wtn_news['publishedAt'] ) ); 
                        }
                        ?>
                    </span>
                </div>
                <?php
                if ( $wtn_enable_rtl ) {
                    ?>
                    <div class="wtn-img-container">
                        <div class="wtn-img" style="background-image: url('<?php esc_attr_e( $wtn_news['urlToImage'] ); ?>');" ></div>
                    </div>
                    <?php
                }
                ?>
                <div style="clear:both"></div>
            </div>
            <?php
        } 
    }
    ?>
</div>