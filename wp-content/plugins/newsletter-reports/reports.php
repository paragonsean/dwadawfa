<?php

/*
  Plugin Name: Newsletter - Reports and Retargeting
  Plugin URI: https://www.thenewsletterplugin.com/documentation/addons/extended-features/reports-extension/
  Description: Extends the statistic viewer adding graphs, link clicks, export and many other data. Automatic updates available setting the license key on Newsletter configuration panel.
  Version: 4.5.9
  Requires at least: 6.1
  Requires PHP: 7.0
  Author: The Newsletter Team
  Author URI: https://www.thenewsletterplugin.com
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 */

add_action('newsletter_loaded', function ($version) {
    if (version_compare($version, '8.3.6', '<')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>Newsletter plugin upgrade required by <strong>Newsletter - Reports Addon</strong>.</p></div>';
        });
    } else {
        require_once __DIR__ . '/plugin.php';
        new NewsletterReports('4.5.9');
    }
});
