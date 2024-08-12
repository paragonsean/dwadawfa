<?php

/*
  Plugin Name: Newsletter - Autoresponder
  Plugin URI: https://www.thenewsletterplugin.com/documentation/addons/extended-features/autoresponder-extension/
  Description: Build email series for your customers and keep them engaged
  Version: 1.5.6
  Requires PHP: 7.4
  Requires at least: 5.6
  Author: The Newsletter Team
  Author URI: https://www.thenewsletterplugin.com
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 */

add_action('newsletter_loaded', function ($version) {
    if (version_compare($version, '8.4.1', '<')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>Newsletter plugin upgrade required by <strong>Newsletter - Autoresponder Addon</strong>.</p></div>';
        });
    } else {
        require_once __DIR__ . '/plugin.php';
        new NewsletterAutoresponder('1.5.6');
    }
});


