<?php

/*
  Plugin Name: Newsletter - Office 365 Headers Removal
  Plugin URI: http://www.thenewsletterplugin.com/
  Description: Removes not mandatory headers from Newsletter emails to avoid Office365 SMTP blocks
  Version: 1.0.6
  Author: The Newsletter Team
  Author URI: http://www.thenewsletterplugin.com/
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
  Requires at least: 5.6
  Requires PHP: 7.4
 */

add_action('newsletter_loaded', function ($version) {
    if (version_compare($version, '8.3.6', '<')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>Newsletter plugin upgrade required for Office 365 Headers Removal Addon.</p></div>';
        });
    } else {
        add_filter('newsletter_message', function ($message) {
            /* @var $message TNP_Mailer_Message */
            $message->headers = [];
            return $message;
        }, 100);
    }
});
