<?php
    /*
    Plugin Name: MK Postmeta Cleaner
    Plugin URI: /mk-postmeta-cleaner
    Description: Advanced Postmeta Cleaner
    Version: 1.0
    Author: Adem Mert Kocakaya
    Author URI: http://www.pigasoft.com
    License: GNU
    */
    
     if ( ! defined( 'ABSPATH' ) ) exit; 
    
        add_action('admin_menu', 'mk_postmeta_cleaner');
        
            function mk_postmeta_cleaner() {
                add_menu_page('MK Postmeta Cleaner', 'MK Postmeta Cleaner', 'manage_options', 'mk-postmeta-cleaner', 'mk_postmeta_celaner_plugin', plugin_dir_url(__FILE__) .'mk-postmeta-cleaner-icon.png');
            }
 
            function mk_postmeta_celaner_plugin() {
                
	        wp_enqueue_style( 'mk_postmeta_celaner_custom_styles', plugins_url( 'assets/css/style.css', __FILE__ ), '', '1.0' );
	        wp_enqueue_style( 'bootstrap_styles', plugins_url( 'assets/css/bootstrap.min.css', __FILE__ ), '', '1.0' ); ?>
            
                <html>
                    <head>
                        <meta name="author" content="Adem Mert Kocakaya">
                        <meta name="description" content="Pigasoft - MK Postmeta Cleaner">
                        <meta http-equiv="content" content-type="text/html; charset=iso-8859-9">
                        <title>MK Postmeta Cleaner - Pigasoft INC.</title>
                    </head>
                    <body>
                        <? include (plugin_dir_path(__FILE__) . 'includes/admin.php');  ?>
                    </body>
                </html>
                
<?php } ?>