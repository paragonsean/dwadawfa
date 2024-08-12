<?php

/*
  Plugin Name: Newsletter - SMTP Addon
  Plugin URI: https://www.thenewsletterplugin.com/documentation/addons/delivery-addons/smtp-extension/
  Description: Enable the use of an SMTP to send newsletters
  Version: 1.1.3
  Requires at least: 5.6
  Requires PHP: 7.4
  Author: The Newsletter Team
  Author URI: https://www.thenewsletterplugin.com
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 */

defined('ABSPATH') || exit;

add_action('newsletter_loaded', function ($version) {
    if (version_compare($version, '8.3.6', '<')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>Newsletter plugin upgrade required by <strong>Newsletter - SMTP Addon</strong>.</p></div>';
        });
    } else {
        require_once __DIR__ . '/plugin.php';
        new NewsletterSmtp('1.1.3');
    }
});

