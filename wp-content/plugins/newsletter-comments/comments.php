<?php

/*
  Plugin Name: Newsletter - Subscribe on Comments
  Plugin URI: https://www.thenewsletterplugin.com/documentation/addons/extended-features/comments-extension/
  Description: Add the subscription option to your blog comment form
  Version: 1.1.8
  Requires PHP: 7.4
  Requires at least: 5.6
  Author: The Newsletter Team
  Author URI: https://www.thenewsletterplugin.com
  Update URI: false
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 */
add_action('newsletter_loaded', function ($version) {
    if (version_compare($version, '8.3.6', '<')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>Newsletter plugin upgrade required by <strong>Newsletter - Subscribe on Comments</strong.</p></div>';
        });
    } else {
        include_once __DIR__ . '/plugin.php';
        new NewsletterComments('1.1.8');
    }
});

