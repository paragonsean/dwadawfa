<?php

/*
  Plugin Name: Newsletter - Google Analytics
  Plugin URI: https://www.thenewsletterplugin.com/documentation/addons/extended-features/analytics-extension/
  Description: Adds Google Analytics tracking to the newsletter links
  Version: 1.2.5
  Requires at least: 5.6
  Requires PHP: 7.0
  Author: The Newsletter Team
  Author URI: https://www.thenewsletterplugin.com
  Update URI: false
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 */

add_action('newsletter_loaded', function ($version) {
        if (version_compare($version, '8.3.6', '<')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>Newsletter plugin upgrade required by <strong>Newsletter - Google Analytics Addon</strong>.</p></div>';
        });
    } else {
        include_once __DIR__ . '/plugin.php';
        new NewsletterAnalytics('1.2.5');
    }
});

