<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* Trait: Core
*/
trait Wtn_API
{
    //protected $fields, $settings, $options;
	protected $data, $transient;
    
    protected function wtn_news_sources() {

        return [ 
			'abc-news' 				=> 'ABC News',
			'abc-news-au' 			=> 'ABC News (AU)',
			'al-jazeera-english' 	=> 'Al Jazeera English',
			'ary-news' 				=> 'Ary News',
			'bbc-news' 				=> 'BBC News',
			'bbc-sport' 			=> 'BBC Sport',
			'bloomberg' 			=> 'Bloomberg',
			'business-insider' 		=> 'Business Insider',
			'business-insider-uk'	=> 'Business Insider (UK)',
			'cbc-news' 				=> 'CBC News',
			'cbs-news' 				=> 'CBS News',
			'cnbc'					=> 'CNBC',
			'cnn' 					=> 'CNN',
			'cnn-es' 				=> 'CNN Spanish',
			'daily-mail'			=> 'Daily Mail',
			'der-tagesspiegel'		=> 'Der Tagesspiegel', //Germany
			'el-mundo'				=> 'El Mundo',
			'espn'					=> 'ESPN',
			'fox-news' 				=> 'Fox News',
			'google-news' 			=> 'Google News',
			'marca'					=> 'Marca',
			'mirror'				=> 'Mirror',
			'nbc-news' 				=> 'NBC News',
			'rt'					=> 'RT',
			'the-huffington-post' 	=> 'The Huffington Post',
			'the-new-york-times' 	=> 'The New York Times',
			'the-guardian-uk' 		=> 'The Guardian (UK)',
			'the-economist' 		=> 'The Economist',
			'the-washington-post' 	=> 'The Washington Post',
			'the-washington-times' 	=> 'The Washington Times',
			'the-hindu' 			=> 'The Hindu'
        ];
    }

    private function wtn_get_api_data( $category, $source, $country ) {
        
		//echo $category;
        if ( 'country' === $category ) {
            $wQuery = "country={$country}";
			$this->transient = "wtn_api_cached_data_{$country}";
        }
        if ( 'country' != $category ) {
            $wQuery = "sources={$source}";
			$this->transient = "wtn_api_cached_data_{$source}";
        }

		if ( ( false === get_transient( $this->transient ) ) or ( empty( get_transient( $this->transient ) ) ) ) {
			
			$wtn_api_key = get_option('wtn_api_key');
        
        	//$urla = "https://newsapi.org/v2/top-headlines?apiKey={$wtn_api_key}&{$wQuery}";
          
            $urla = "https://gnews.io/api/v4/search?q=tenis&country=us&topic=sports&token=fd7b910cef4f800902d2e3fad328a355";
          
            $this->wtn_api = wp_remote_get( $urla );
        
        	$this->data = (array) json_decode( wp_remote_retrieve_body( $this->wtn_api ) );
			
			echo '<i class="fa fa-hdd-o" aria-hidden="true"></i>';
			
			delete_transient( $this->transient );

			$wtn_caching_time  = ( null !== get_option('wtn_caching_time') ) ? get_option('wtn_caching_time') : '24';
			
			set_transient( $this->transient , $this->data, 361 * $wtn_caching_time );
		}

		return get_transient( $this->transient );
	}
}