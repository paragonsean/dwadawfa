<?php

/*
  Plugin Name: Newsletter - Artificial Intelligence
  Plugin URI: https://www.thenewsletterplugin.com/documentation/addons/integrations/contact-form-7-extension/
  Description: Integrate AI into Newsletter
  Version: 1.0.5
  Requires PHP: 7.4
  Requires at least: 5.6
  Author: The Newsletter Team
  Author URI: https://www.thenewsletterplugin.com
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 */

add_action('newsletter_loaded', function ($version) {
    if (version_compare($version, '8.3.6') < 0) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>Newsletter plugin upgrade required by <strong>Newsletter - Artificial Intelligence Addon</strong>.</p></div>';
        });
    } else {
        include_once __DIR__ . '/plugin.php';
        new NewsletterAI('1.0.5');
    }
});
