<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="wtn-main-wrapper">
    <?php 
for ( $i = 0 ;  $i < $wtn_news_number ;  $i++ ) {
    //$wtn_news = (array) $wtn_news_init_stdclass[ $i ];
    $wtn_news = ( isset( $wtn_news_init_stdclass['articles'][$i] ) ? (array) $wtn_news_init_stdclass['articles'][$i] : [] );
    
    if ( isset( $wtn_news['urlToImage'] ) && '' != $wtn_news['urlToImage'] ) {
        ?>
            <div class="wtn-item">
                <div class="wtn-img-container">
                    <div class="wtn-img" style="background-image: url('<?php 
        echo  esc_attr( $wtn_news['urlToImage'] ) ;
        ?>');" ></div>
                </div>
                <a href="<?php 
        printf( '%s', esc_url( $wtn_news['url'] ) );
        ?>" target="_blank">
                    <?php 
        echo  esc_html( wp_trim_words( $wtn_news['title'], $wtn_title_length, '...' ) ) ;
        ?>
                </a>

                <?php 
        
        if ( $wtnDesc !== 'hide' ) {
            ?>
                        <p class="wtn-item-description">
                            <?php 
            echo  wp_trim_words( esc_html( $wtn_news['description'] ), esc_html( $wtn_desc_length ), '...' ) ;
            ?>
                        </p>
                        <?php 
        }
        
        ?>
                <span>
                    <?php 
        
        if ( '1' === $wtn_display_news_source ) {
            $wtn_source = (array) $wtn_news['source'];
            
            if ( $wtn_enable_rtl ) {
                echo  esc_html( $wtn_source['name'] ) . '&nbsp;&nbsp;<i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;&nbsp;' ;
            } else {
                echo  '<i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;&nbsp;' . esc_html( $wtn_source['name'] ) ;
            }
        
        }
        
        if ( '1' === $wtn_display_date ) {
            
            if ( $wtn_enable_rtl ) {
                echo  date( 'd M, Y', strtotime( $wtn_news['publishedAt'] ) ) . '&nbsp;&nbsp;<i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp;&nbsp;' ;
            } else {
                echo  '&nbsp;&nbsp;<i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp;&nbsp;' . date( 'd M, Y', strtotime( $wtn_news['publishedAt'] ) ) ;
            }
        
        }
        ?>
                </span>
            </div>
            <?php 
    }

}
?>
</div>