<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*
@ Admin Panel Parent Class
*/
class WTN_Admin 
{
	use Wtn_API, Wtn_Core, Wtn_Country, Wtn_General_Settings, Wtn_Cache;
	protected $wtn_version;
	protected $wtn_assets_prefix;

	function __construct( $version ){
		$this->wtn_version = $version;
		$this->wtn_assets_prefix = substr(WTN_PRFX, 0, -1) . '-';
	}
	
	/*
	@	Loading the admin menu
	*/
	function wtn_admin_menu(){
		
		add_menu_page(  
			__('Dan News', WTN_TXT_DMN),
			__('Dan News', WTN_TXT_DMN),
			'manage_options',
			'wp-top-news',
			array( $this, 'wtn_get_help' ),
			'dashicons-admin-site-alt',
			100 
		);
		
		add_submenu_page( 	
			'wp-top-news', 
			__('API Settings', WTN_TXT_DMN), 
			__('API Settings', WTN_TXT_DMN), 
			'manage_options', 
			'wtn-api-settings', 
			array( $this, WTN_PRFX . 'api_settings' )
		);

		add_submenu_page( 	
			'wp-top-news', 
			__('Settings', WTN_TXT_DMN), 
			__('General Settings', WTN_TXT_DMN), 
			'manage_options', 
			'wtn-settings', 
			array( $this, WTN_PRFX . 'settings' )
		);

		add_submenu_page(
			'wp-top-news',
			__( 'Usage & Tutorial', WTN_TXT_DMN ),
			__( 'Usage & Tutorial', WTN_TXT_DMN ),
			'manage_options',
			'wtn-get-help',
			array( $this, 'wtn_get_help' )
		);

		add_submenu_page(
			'wp-top-news',
			__( 'Manage Cache', WTN_TXT_DMN ),
			__( 'Manage Cache', WTN_TXT_DMN ),
			'manage_options',
			'wtn-clear-cache',
			array( $this, 'wtn_manage_cache' )
		);
    }
	
	/*
	@	Loading admin panel styles
	*/
	function wtn_enqueue_assets() {
		
		wp_enqueue_style( 'wp-color-picker');
		wp_enqueue_script( 'wp-color-picker');

		wp_enqueue_style(
			$this->wtn_assets_prefix . 'font-awesome', 
			WTN_ASSETS .'css/font-awesome/css/font-awesome.min.css',
			array(),
			$this->wtn_version,
			FALSE
		);

		wp_enqueue_style('wtn-admin', WTN_ASSETS . 'css/wtn-admin.css', array(), $this->wtn_version, FALSE );
		
		if ( !wp_script_is( 'jquery' ) ) {
			wp_enqueue_script('jquery');
		}

		wp_enqueue_script('wtn-admin', WTN_ASSETS . 'js/wtn-admin.js', array('jquery'), $this->wtn_version, true );
	}
	
	/**
	*	Loading admin panel view/forms
	*/
	function wtn_settings() {

		$wtnShowMessage = false;
        
		if ( isset( $_POST['updateGeneralSettings'] ) ) {
            $wtnShowMessage = $this->wtn_set_general_settings( $_POST );
        }

        $wtnGeneralSettings = $this->wtn_get_general_settings();

		require_once WTN_PATH . 'admin/view/' . $this->wtn_assets_prefix . 'settings.php';
	}
	
	function wtn_api_settings() {

		require_once WTN_PATH . 'admin/view/' . $this->wtn_assets_prefix . 'api-settings.php';
    }

	protected function wtn_display_notification( $type, $msg ) { 
		?>
		<div class="wtn-alert <?php esc_attr_e( $type ); ?>">
			<span class="wtn-closebtn">&times;</span> 
			<strong><?php esc_html_e( ucfirst( $type ), WTN_TXT_DMN ); ?>!</strong> <?php esc_html_e($msg, WTN_TXT_DMN); ?>
		</div>
		<?php 
	}

	function wtn_get_help() {
        require_once WTN_PATH . 'admin/view/' . $this->wtn_assets_prefix . 'help-usage.php';
    }

	function wtn_manage_cache() {
		require_once WTN_PATH . 'admin/view/manage-cache.php';
	}
}
?>