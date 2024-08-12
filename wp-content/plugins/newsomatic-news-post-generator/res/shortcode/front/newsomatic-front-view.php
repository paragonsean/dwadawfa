<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$newsomatic_news_arr = newsomatic_get_api_data( $query_string, $query_string_title, $sources, $country, $language, $sort_results, $only_domains, $remove_domains, $from_date, $to_date, $newsomatic_news_number, $newsomatic_caching_time );
$newsomatic_news_init_stdclass = ( !empty($newsomatic_news_arr) ? $newsomatic_news_arr : [] );
$reg_css_code2 = '';
?>
<?php 
if ( !empty($newsomatic_news_init_stdclass) ) {
    if(!isset($newsomatic_news_init_stdclass['articles']))
    {
        esc_html_e( 'No Data Found', 'newsomatic-news-post-generator' );
    }
    else 
    {
        if ( 'plain' === $newsomatic_layout ) 
        {          
            ?>
            <div class="newsomatic-plain-container">
                <ul class= "newsomatic-ul-shortcode">
                <?php
                for( $i = 0; $i < $newsomatic_news_number; $i++ ) 
                {
                    $newsomatic_news = isset( $newsomatic_news_init_stdclass['articles'][ $i ] ) ? (array) $newsomatic_news_init_stdclass['articles'][ $i ] : [];
                    if ( isset( $newsomatic_news['title'] ) && ( '' != $newsomatic_news['title'] ) ) 
                    {
                        ?>
                        <li class="newsomatic-plain-container"> 
                            <a href="<?php echo esc_url( $newsomatic_news['url'] ); ?>" target="_blank" class="newsomatic-feeds-title">
                                <?php echo esc_html( wp_trim_words( $newsomatic_news['title'], $newsomatic_title_length, '...' ) ); ?>
                            </a>
                        </li>
                        <?php
                    } 
                }
                ?>
                </ul>
            </div>
            <?php
        }
        elseif ( 'list' === $newsomatic_layout ) 
        {          
            ?>
            <div class="newsomatic-main-container">
                <?php 
                for( $i = 0; $i < $newsomatic_news_number; $i++ ) {
                    $newsomatic_news = isset( $newsomatic_news_init_stdclass['articles'][ $i ] ) ? (array) $newsomatic_news_init_stdclass['articles'][ $i ] : [];
                    if ( isset( $newsomatic_news['urlToImage'] ) && ( '' != $newsomatic_news['urlToImage'] ) ) {
                        ?>
                        <div class="newsomatic-feed-container">
                            <?php
                            if ( ! $newsomatic_enable_rtl ) {
                                ?>
                                <div class="newsomatic-img-container"><?php $reg_css_code2 .= '#newsomatic-img' . $i .'{background-image: url(\'' . esc_attr( $newsomatic_news['urlToImage'] ) . '\');}';?>
                                    <div class="newsomatic-img" id="newsomatic-img<?php echo esc_html($i);?>"></div>
                                </div>
                                <?php
                            }
                            ?>    
                            <div class="newsomatic-feeds">
                                <a href="<?php echo esc_url( $newsomatic_news['url'] ); ?>" target="_blank" class="newsomatic-feeds-title">
                                    <?php echo esc_html( wp_trim_words( $newsomatic_news['title'], $newsomatic_title_length, '...' ) ); ?>
                                </a>
                                <?php
                                    if ( $show_description !== false ) {
                                        ?>
                                        <p class="newsomatic-feeds-description">
                                            <?php echo esc_html( wp_trim_words( $newsomatic_news['description'], $newsomatic_desc_length, '...' ) ); ?>
                                        </p>
                                        <?php
                                    }
                                ?>
                                <span>
                                    <?php
                                    if ( true == $newsomatic_display_news_source ) {
                                        $newsomatic_source = (array) $newsomatic_news['source'];
                                        echo '<i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;&nbsp;' . esc_html( $newsomatic_source['name'] );
                                    }
                                    if ( true == $newsomatic_display_date ) {
                                        echo '&nbsp;&nbsp;<i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp;&nbsp;' . date( 'd M, Y', strtotime( $newsomatic_news['publishedAt'] ) ); 
                                    }
                                    ?>
                                </span>
                            </div>
                            <?php
                            if ( $newsomatic_enable_rtl ) {
                                ?>
                                <div class="newsomatic-img-container"><?php $reg_css_code2 .= '#newsomatic-img' . $i .'{background-image: url(\'' . esc_attr( $newsomatic_news['urlToImage'] ) . '\');}';?>
                                    <div class="newsomatic-img" id="newsomatic-img<?php echo esc_html($i);?>"></div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="newsomatic-clear-both"></div>
                        </div>
                        <?php
                    } 
                }
                ?>
            </div>
            <?php
        }
        elseif ( 'grid' === $newsomatic_layout ) 
        {
            ?>
            <div class="newsomatic-main-wrapper">
                <?php 
            for ( $i = 0 ;  $i < $newsomatic_news_number ;  $i++ ) {
                $newsomatic_news = ( isset( $newsomatic_news_init_stdclass['articles'][$i] ) ? (array) $newsomatic_news_init_stdclass['articles'][$i] : [] );
                
                if ( isset( $newsomatic_news['urlToImage'] ) && '' != $newsomatic_news['urlToImage'] ) {
                    ?>
                        <div class="newsomatic-item">
                            <div class="newsomatic-img-container"><?php $reg_css_code2 .= '#newsomatic-img' . $i .'{background-image: url(\'' . esc_attr( $newsomatic_news['urlToImage'] ) . '\');}';?>
                                <div class="newsomatic-img" id="newsomatic-img<?php echo esc_html($i);?>"></div>
                            </div>
                            <a href="<?php 
                    printf( '%s', esc_url( $newsomatic_news['url'] ) );
                    ?>" target="_blank">
                                <?php 
                    echo  esc_html( wp_trim_words( $newsomatic_news['title'], $newsomatic_title_length, '...' ) ) ;
                    ?>
                            </a>

                            <?php 
                    
                    if ( $show_description !== false ) {
                        ?>
                                    <p class="newsomatic-item-description">
                                        <?php 
                        echo  wp_trim_words( esc_html( $newsomatic_news['description'] ), esc_html( $newsomatic_desc_length ), '...' ) ;
                        ?>
                                    </p>
                                    <?php 
                    }
                    
                    ?>
                            <span>
                                <?php 
                    
                    if ( true == $newsomatic_display_news_source ) {
                        $newsomatic_source = (array) $newsomatic_news['source'];
                        
                        if ( $newsomatic_enable_rtl ) {
                            echo  esc_html( $newsomatic_source['name'] ) . '&nbsp;&nbsp;<i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;&nbsp;' ;
                        } else {
                            echo  '<i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;&nbsp;' . esc_html( $newsomatic_source['name'] ) ;
                        }
                    
                    }
                    
                    if ( true == $newsomatic_display_date ) {
                        
                        if ( $newsomatic_enable_rtl ) {
                            echo  date( 'd M, Y', strtotime( $newsomatic_news['publishedAt'] ) ) . '&nbsp;&nbsp;<i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp;&nbsp;' ;
                        } else {
                            echo  '&nbsp;&nbsp;<i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp;&nbsp;' . date( 'd M, Y', strtotime( $newsomatic_news['publishedAt'] ) ) ;
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
            <?php
        }
        elseif ( 'ticker' === $newsomatic_layout ) 
        {
            $newsomatic_rtl_class = '';
            if ( $newsomatic_enable_rtl ) 
            {
                $newsomatic_rtl_class = 'rtl';
            }
            ?>
            <div class="acme-news-ticker">
                <div class="acme-news-ticker-label"><?php 
                if($show_source_name == true)
                {
                    echo ( '' != $sources ) ? ucfirst( esc_html( $sources ) ) : esc_html__('Breaking News', 'newsomatic-news-post-generator');
                }
                ?></div>
                <div class="acme-news-ticker-box">
                    <ul class="newsomatic-news-ticker newsomatic-news-ticker-<?php esc_attr_e( $newsomatic_ticker_type ); ?>" data-rtl-type="<?php esc_attr_e( $newsomatic_rtl_class ); ?>">
                        <?php 
                        for ( $i = 0; $i < $newsomatic_news_number; $i++ ) {
                            $newsomatic_news = isset( $newsomatic_news_init_stdclass['articles'][ $i ] ) ? (array) $newsomatic_news_init_stdclass['articles'][ $i ] : [];
                            if(empty($newsomatic_news))
                            {
                                continue;
                            }
                            ?>
                            <li class="<?php echo ( 'marquee' !== $newsomatic_ticker_type ) ? 'newsomatic-no-marquee' : ''; ?>">
                                <a href="<?php echo esc_url( $newsomatic_news['url'] ); ?>" target="_blank" class="newsomatic-feeds-title">
                                    <?php
                                    if ( 'marquee' === $newsomatic_ticker_type ) 
                                    {
                                        if($enable_font_awesome == true)
                                        {
                                            echo '<i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;&nbsp;';
                                        }
                                        else
                                        {
                                            echo '&nbsp;&nbsp;&#8226;&nbsp;';
                                        }
                                    }
                                    esc_html_e( $newsomatic_news['title'] ); ?>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
        }
    }

} else {
    esc_html_e( 'No Data Available', 'newsomatic-news-post-generator' );
}
if($reg_css_code2 != '')
{
    wp_add_inline_style( 'newsomatic-shortcode-front', $reg_css_code2 );
}
?>
