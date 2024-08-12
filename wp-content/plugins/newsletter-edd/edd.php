<?php

/*
 * Plugin Name: Newsletter - Easy Digital Downloads
 * Plugin URI: https://www.thenewsletterplugin.com/documentation/addons/integrations/edd-extension/
 * Text Domain: newsletter-edd
 * Domain Path: /languages
 * Description: Integrates Newsletter with Easy Digital Downloads. Automatic updates available with the license key.
 * Version: 1.0.9
 * Requires PHP: 7.0
 * Requires at least: 5.6
 * Author: The Newsletter Team
 * Author URI: https://www.thenewsletterplugin.com/
 *
 * Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 */

add_action('newsletter_loaded', function ($version) {
    if (version_compare($version, '8.3.6') < 0) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>Newsletter plugin upgrade required <strong>Newsletter - Easy Digital Downloads Addon</strong>.</p></div>';
        });
    } if (!class_exists('EDD_Download')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>Easy Digital Downloads plugin required by <strong>Newsletter - Easy Digital Downloads Addon</strong></p></div>';
        });
    } else {
        include_once __DIR__ . '/plugin.php';
        new NewsletterEdd('1.0.9');
    }
});
