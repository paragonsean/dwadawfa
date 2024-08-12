<?php
/**
 * GN Publisher
 * 
 * @copyright 2020 Chris Andrews
 * 
 * Plugin Name: GN Publisher
 * Plugin URI: https://gnpublisher.com/
 * Description: GN Publisher: The easy way to make Google News Publisher compatible RSS feeds.
 * Version: 1.5.16
 * Author: Chris Andrews
 * Author URI: https://gnpublisher.com/
 * Text Domain: gn-publisher
 * Domain Path: /languages
 * License: GPL v3 or later
 * 
 * GN Publisher is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * GN Publisher is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GN Publisher. If not, see <http://www.gnu.org/licenses/>.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//gn publisher----------

function gnpub_feed_bootstrap() {
	
	if ( defined( 'GNPUB_VERSION' ) ) {
		return;
	}
 
	define( 'GNPUB_VERSION', '1.5.16' );
	define( 'GNPUB_PATH', plugin_dir_path( __FILE__ ) );
    define( 'GNPUB_URL', plugins_url( '', __FILE__) );
	define( 'GNPUB_PLUGIN_FILE', __FILE__ );

	add_action( 'plugins_loaded', 'gnpub_load_textdomain' );

	require_once GNPUB_PATH . 'utilities.php';
	require_once GNPUB_PATH . 'controllers/class-gnpub-feed.php';
	require_once GNPUB_PATH . 'controllers/class-gnpub-posts.php';
	require_once GNPUB_PATH . 'controllers/class-gnpub-websub.php';
	require_once GNPUB_PATH . 'class-gnpub-compat.php';
	require_once GNPUB_PATH . 'class-gnpub-rss-url.php';


	new GNPUB_Feed();
	new GNPUB_Posts();
	new GNPUB_Websub();
	GNPUB_Compat::init();
	Gnpub_Rss_Url::on_load();

	if ( is_admin() ) {
		require_once GNPUB_PATH . 'class-gnpub-installer.php';
		require_once GNPUB_PATH . 'class-gnpub-notices.php';
		require_once GNPUB_PATH . 'controllers/admin/class-gnpub-menu.php';
		require_once GNPUB_PATH . 'includes/mb-helper-function.php';
		require_once GNPUB_PATH . 'controllers/admin/class-gnpub-settings.php';		
		require_once GNPUB_PATH . 'controllers/admin/newsletter.php';


		register_activation_hook( __FILE__, array( 'GNPUB_Installer', 'install' ) );
		register_deactivation_hook( __FILE__, array( 'GNPUB_Installer', 'uninstall' ) );
		add_action('wp_ajax_gn_send_query_message', 'gn_send_query_message');

		$admin_notices = new GNPUB_Notices();

		new GNPUB_Menu( $admin_notices );
		new GNPUB_Settings( $admin_notices );
	}

}

gnpub_feed_bootstrap();

function gnpub_load_textdomain() {
	load_plugin_textdomain( 'gn-publisher', false, basename( dirname( GNPUB_PLUGIN_FILE ) ) . '/languages/' );
}

function gnpub_admin_style($hook_suffix ) {
	if($hook_suffix=="settings_page_gn-publisher-settings")
	{
		wp_enqueue_style('gn-admin-styles', GNPUB_URL .'/assets/css/gn-admin.css', array(),GNPUB_VERSION);
		wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');
        wp_enqueue_style('gn-admin-promo-style', GNPUB_URL .'/assets/css/promotional-popup.css', array(),GNPUB_VERSION);
		
		wp_enqueue_script('gn-admin-script', GNPUB_URL . '/assets/js/gn-admin.js', array('jquery'), GNPUB_VERSION, 'true' );
		
		wp_localize_script('gn-admin-script', 'gn_script_vars', array(
			'nonce' => wp_create_nonce( 'gn-admin-nonce' ),
		)
		);
		wp_enqueue_script('gn-admin-promo-script', GNPUB_URL . '/assets/js/promotional-popup.js', array(), GNPUB_VERSION);
	}
}


add_action('admin_enqueue_scripts', 'gnpub_admin_style');

function gnpub_admin_newsletter_script($hook_suffix ) {
	if($hook_suffix=="settings_page_gn-publisher-settings")
	{
		wp_enqueue_script('gn-admin-newsletter-script', GNPUB_URL . '/assets/js/gn-admin-newsletter.js', array('jquery'), GNPUB_VERSION, 'true' );
		
		$current_screen = get_current_screen(); 
       
        if(isset($current_screen->post_type)){                  
            $post_type = $current_screen->post_type;                
        }

		$post_id = get_the_ID();
        if(isset($_GET['tag_ID'])){
                $post_id = intval($_GET['tag_ID']);
        }

		

		$data = array(     
			'current_url'                  => gnpub_get_current_url(), 
			'post_id'                      => $post_id,
			'ajax_url'                     => admin_url( 'admin-ajax.php' ),            
			'post_type'                    => $post_type,   
			'page_now'                     => $hook_suffix,
			'gnpub_security_nonce'         => wp_create_nonce('gnpub_ajax_check_nonce'),
		);
						
		$data = apply_filters('gnpub_localize_filter',$data,'gnpub_localize_data');		
	
		wp_localize_script( 'gn-admin-newsletter-script', 'gnpub_localize_data', $data );
		
	}	

}
add_action('admin_enqueue_scripts', 'gnpub_admin_newsletter_script');


register_activation_hook(__FILE__, 'gnpub_activate');

add_action('admin_init', 'gnpub_redirect');

function gnpub_activate() {
    add_option('gnpub_activation_redirect', true);
}

function gnpub_redirect() {
    if (get_option('gnpub_activation_redirect', false)) {
        delete_option('gnpub_activation_redirect');
        if(!isset($_GET['activate-multi']))
        {
            wp_redirect("options-general.php?page=gn-publisher-settings&tab=welcome");
        }
    }
}

/**
 * gnpub_htmlToPlainText function
 *
 * @since 1.5.8 
 * 
 * @param string|mixed $str
 * @return string|mixed
 */
function gnpub_htmlToPlainText($str) 
{
	$resultStr = $str;
	if( null !== $str && !empty( $str ) )
	{
		$resultStr = str_replace( '&nbsp;', ' ', $str );
		$resultStr = html_entity_decode( $resultStr, ENT_QUOTES | ENT_COMPAT, 'UTF-8' );
		$resultStr = html_entity_decode( $resultStr, ENT_HTML5, 'UTF-8' );
		$resultStr = html_entity_decode( $resultStr );
		$resultStr = htmlspecialchars_decode( $resultStr );
		$resultStr = strip_tags( $resultStr );
	}
    return $resultStr;
}

/**
 * gnpub_wp_title_rss function
 *
 * @since 1.5.8 
 * 
 * @return string|mixed
 */
function gnpub_wp_title_rss() 
{
	ob_start();
	wp_title_rss();
	$wp_title_rss = ob_get_contents();
	ob_end_clean();

	if( false !== strpos(gnpub_htmlToPlainText($wp_title_rss), '-') && function_exists( 'gnpub_pp_translate' ) ) {
    	$wp_title_rss_explode = explode("-", gnpub_htmlToPlainText($wp_title_rss));
		
    	$wp_title_rss = gnpub_pp_translate( trim( $wp_title_rss_explode[0] ) ) . ' - ' . gnpub_pp_translate( trim( $wp_title_rss_explode[1] ) );
	}
	echo $wp_title_rss;
}

/**
 * gnpub_bloginfo_rss function
 *
 * @since 1.5.8 
 * 
 * @param string|mixed $attr
 * @return string|mixed
 */
function gnpub_bloginfo_rss( $attr )
{
	ob_start();
	bloginfo_rss( $attr );
	$bloginfo_rss = ob_get_contents();
	ob_end_clean();
	if( function_exists( 'gnpub_pp_translate' ) )
		echo gnpub_pp_translate($bloginfo_rss);
	else
		echo $bloginfo_rss;
}

/**
 * gnpub_the_title_rss function
 *
 * @since 1.5.8 
 * 
 * @return string|mixed
 */
function gnpub_the_title_rss()
{
	ob_start();
	the_title_rss();
	$the_title_rss = ob_get_contents();
	ob_end_clean();
	if( function_exists( 'gnpub_pp_translate' ) )
		echo gnpub_pp_translate($the_title_rss);
	else
		echo $the_title_rss;
}

/**
 * gnpub_remove_potentially_dangerous_tags function
 *
 * @since 1.5.8 
 * 
 * @param string|mixed $content
 * @return string|mixed
 */
function gnpub_remove_potentially_dangerous_tags( $content ) {
	$removeTags = array(
		'iframe' => 'iframe',
		'script' => 'script',
		'style'=>'style',
		'ins'=>'ins',
		'frameset'=>'frameset',
		'applet'=>'applet',
		'object'=>'object',
		'embed'=>'embed',
		'form'=>'form',
	);

	foreach ( $removeTags as $tag )	{
		if( false !== strpos($content, "<$tag") )
        	$content = preg_replace("/<$tag.*?\/$tag>/i",'', $content);
	}
	
	if( false !== stripos( $content, "style='" ) )
		$content = preg_replace("/style=\'.*?\'/i", '', $content);
	if( false !== stripos( $content, 'style="' ) )
		$content = preg_replace("/style=\".*?\"/i", '', $content);

	return $content;
}

/**
 * gnpub_get_requested_feedid function
 *
 * @since 1.5.9 
 * 
 * @param string|mixed $content
 * @return string|mixed
 */

 function gnpub_get_requested_feedid() {
	return get_query_var( 'feed','');
}

/**
 * gnpub_flipboard function
 *
 * @since 1.5.9 
 * 
 * @param string|mixed $content
 * @return string|mixed
 */
function gnpub_flipboard( $content ) {
	$gnpub_options = get_option( 'gnpub_new_options' );
	
	if(!empty($gnpub_options) && isset( $gnpub_options['gnpub_pp_flipboard_com'] ) && true == $gnpub_options['gnpub_pp_flipboard_com'] && function_exists( 'trp_translate' ) ) {
		$content = trp_translate( $content, null, false );
	}
	return $content;
}

function gnpub_revenue_snippet(){
	$default_options=array('gnpub_enable_google_revenue_manager'=>false, 'gnpub_enable_google_revenue_manager' => '');
	$gnpub_options = get_option( 'gnpub_new_options', $default_options );
	$gnpub_enable_google_revenue_manager = isset($gnpub_options['gnpub_enable_google_revenue_manager'])?$gnpub_options['gnpub_enable_google_revenue_manager']:false;
	$gnpub_google_rev_snippet = isset($gnpub_options['gnpub_google_rev_snippet'])?$gnpub_options['gnpub_google_rev_snippet']:'';
	if($gnpub_enable_google_revenue_manager){
		if(!empty($gnpub_google_rev_snippet)){
			echo $gnpub_google_rev_snippet;
		}
	}
}
add_action( 'wp_head', 'gnpub_revenue_snippet' );

/**
 * Prevent duplicate video explosure tag to feed
 * @since 1.5.12
 * */
function gnpub_rss_enclosure()
{
	if ( post_password_required() ) {
		return;
	}
	$enclosure_cnt = 1;
	foreach ( (array) get_post_custom() as $key => $val ) {
		if ( 'enclosure' === $key ) {
			foreach ( (array) $val as $enc ) {
				if($enclosure_cnt == 1){
					$enclosure = explode( "\n", $enc );

					// Only get the first element, e.g. 'audio/mpeg' from 'audio/mpeg mpga mp2 mp3'.
					$t    = preg_split( '/[ \t]/', trim( $enclosure[2] ) );
					$type = $t[0];

					/**
					 * Filters the RSS enclosure HTML link tag for the current post.
					 *
					 * @since 2.2.0
					 *
					 * @param string $html_link_tag The HTML link tag with a URI and other attributes.
					 */
					echo apply_filters( 'gnpub_rss_enclosure', '<enclosure url="' . esc_url( trim( $enclosure[0] ) ) . '" length="' . absint( trim( $enclosure[1] ) ) . '" type="' . esc_attr( $type ) . '" />' . "\n" );
				}
				$enclosure_cnt++;
			}
		}
	}
}