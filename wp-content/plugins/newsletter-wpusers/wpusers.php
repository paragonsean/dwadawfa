<?php

/*
  Plugin Name: Newsletter - WP Users Addon
  Plugin URI: https://www.thenewsletterplugin.com/documentation/addons/extended-features/wpusers-extension/
  Description: Integrates the WP user registration with Newsletter subscription
  Text Domain: newsletter-wpusers
  Domain Path: /languages
  Version: 1.4.5
  Requires PHP: 7.0
  Requires at least: 5.6
  Author: The Newsletter Team
  Author URI: https://www.thenewsletterplugin.com
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 */

add_action('newsletter_loaded', function ($version) {
    if (version_compare($version, '8.3.6') < 0) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>Newsletter plugin upgrade required by <strong>Newsletter - WP User Addon</strong>.</p></div>';
        });
    } else {
        include_once __DIR__ . '/plugin.php';
        new NewsletterWpUsers('1.4.5');
    }
});

