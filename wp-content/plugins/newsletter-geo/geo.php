<?php

/*
  Plugin Name: Newsletter - Geolocation
  Plugin URI: https://www.thenewsletterplugin.com/documentation/addons/extended-features/geolocation-extension/
  Description: Adds gelocation targeting to your campatigns
  Version: 1.3.0
  Requires PHP: 7.4
  Requires at least: 5.6
  Author: The Newsletter Team
  Author URI: https://www.thenewsletterplugin.com
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 */

add_action('newsletter_loaded', function ($version) {
    if (version_compare($version, '8.3.6') < 0) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>Newsletter plugin upgrade required by <strong>Newsletter - Geolocation Addon</strong>.</p></div>';
        });
    } else {
        require_once __DIR__ . '/plugin.php';
        new NewsletterGeo('1.3.0');
    }
});

