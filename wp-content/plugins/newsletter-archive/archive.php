<?php

/*
  Plugin Name: Newsletter - Archive
  Plugin URI: https://www.thenewsletterplugin.com/documentation/addons/extended-features/archive-extension/
  Description: Enables a special short code which can be used in a WordPress page to show the sent newsletter archives.
  Version: 4.1.5
  Requires PHP: 7.4
  Requires at least: 5.6
  Author: The Newsletter Team
  Author URI: https://www.thenewsletterplugin.com
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 */

add_action('newsletter_loaded', function ($version) {
    if (version_compare($version, '8.3.6', '<')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>Newsletter plugin upgrade requiredby <strong>Newsletter - Archive Addon</strong>.</p></div>';
        });
    } else {
        include_once __DIR__ . '/plugin.php';
        new NewsletterArchive('4.1.5');
    }
});
