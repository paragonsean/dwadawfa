<?php

/*
  Plugin Name: Newsletter - Webhooks
  Plugin URI: http://www.thenewsletterplugin.com
  Description: Adds webhook capabilities to connect to external systems
  Version: 1.1.0
  Author: The Newsletter Team
  Author URI: http://www.thenewsletterplugin.com
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
  Requires at least: 5.6
  Requires PHP: 7.4
 */

defined('ABSPATH') || exit;

add_action('newsletter_loaded', function ($version) {
    if (version_compare($version, '8.3.6', '<')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>Newsletter plugin upgrade required by <strong>Newsletter - Webhooks Addon</strong>.</p></div>';
        });
    } else {
        include_once __DIR__ . '/plugin.php';
        new NewsletterWebhooks('1.1.0');
    }
});

