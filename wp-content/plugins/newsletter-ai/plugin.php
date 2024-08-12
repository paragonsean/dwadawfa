<?php

class NewsletterAI extends NewsletterAddon {

    /**
     * @var NewsletterAI
     */
    static $instance;

    function __construct($version) {
        self::$instance = $this;
        parent::__construct('ai', $version, __DIR__);
        $this->setup_options();
    }

    function init() {
        parent::init();
        if (Newsletter::instance()->is_allowed()) {
            add_action('admin_menu', [$this, 'hook_admin_menu'], 100);
            add_filter('newsletter_menu_newsletters', [$this, 'hook_newsletter_menu_newsletters']);
            add_action('wp_ajax_newsletter_ai_subjects', [$this, 'ajax_ai_subjects']);
            add_action('wp_ajax_newsletter_ai_generate', [$this, 'ajax_ai_generate']);
            add_action('newsletter_composer_subject', [$this, 'hook_newsletter_composer_subject']);
            add_action('newsletter_composer_footer', [$this, 'hook_newsletter_composer_footer']);
        }

        if (is_admin()) {
            add_action('newsletter_register_blocks', function () {
                $dir = __DIR__ . '/blocks/ai';
                TNP_Composer::register_block($dir);
            });
        }
    }

    function weekly_check() {
        parent::weekly_check();
        $license_key = Newsletter::instance()->get_license_key();
        $response = wp_remote_post('https://www.thenewsletterplugin.com/wp-content/addon-check.php?k=' . urlencode($license_key)
                . '&a=' . urlencode($this->name) . '&d=' . urlencode(home_url()) . '&v=' . urlencode($this->version)
                . '&ml=' . (Newsletter::instance()->is_multilanguage() ? '1' : '0'));
    }

    function hook_newsletter_composer_subject() {
        //echo '&nbsp;<i id="tnpc-subject-ai-button" class="fas fa-brain"></i>';
        echo '&nbsp;&nbsp;<a href="#" id="tnpc-subject-ai-button"><i class="fas fa-user-astronaut"></i></a>';
    }

    function hook_newsletter_composer_footer() {
        echo '
        <div id="tnpc-subject-ai" title="AI help" style="display: none">
            <div id="tnpc-subject-ai-content"></div>
        </div>';
        echo '<script>';
        echo 'var tnp_ai_nonce = \'', esc_js(wp_create_nonce('tnp-ai')), '\';';
        include __DIR__ . '/admin/ai.js';
        echo '</script>';
    }

    function ajax_ai_subjects() {
        check_ajax_referer('tnp-ai');

        require_once ABSPATH . 'wp-admin/includes/translation-install.php';
        $translations = wp_get_available_translations();
        $language = 'English';
        if (isset($translations[get_locale()])) {
            $language = $translations[get_locale()]['english_name'];
        }

        $url = 'https://api.thenewsletterplugin.com/api/subjects';

        $response = wp_remote_post($url, ['timeout' => 60,
            'body' => [
                'language' => $language,
                'subject' => stripslashes($_POST['subject']),
                'site_title' => get_bloginfo('name'),
                'site_description' => get_bloginfo('description'),
                'site_domain' => home_url(),
                'api_key' => Newsletter::instance()->get_license_key()]
        ]);

        if (is_wp_error($response)) {
            $this->get_logger()->error($response);
            wp_send_json_error($response);
            die();
        }

        if (wp_remote_retrieve_response_code($response) !== 200) {
            $this->get_logger()->error($response);
            return wp_send_json_error(wp_remote_retrieve_response_message($response), wp_remote_retrieve_response_code($response));
            die();
        }

        $json = wp_remote_retrieve_body($response);
        $data = json_decode($json);
        $data = array_map('esc_html', $data);
        $html = '<h3>Here some ideas for your subject</h3>';
        $html .= implode('<br>', $data);
        echo $html;
        die();

//foreach ($translations as $t) {
//    //echo $t['language'];
//    if ($t['language'] === $locale) {
//        echo $t['native_name'];
//    }
//}
//["ta_LK"]=>
//  array(8) {
//    ["language"]=>
//    string(5) "ta_LK"
//    ["version"]=>
//    string(6) "4.2.36"
//    ["updated"]=>
//    string(19) "2015-12-03 01:07:44"
//    ["english_name"]=>
//    string(17) "Tamil (Sri Lanka)"
//    ["native_name"]=>
//    string(15) "தமிழ்"
//    ["package"]=>
//    string(65) "https://downloads.wordpress.org/translation/core/4.2.36/ta_LK.zip"
//    ["iso"]=>
//    array(2) {
//      [1]=>
//      string(2) "ta"
//      [2]=>
//      string(3) "tam"
//    }
//    ["strings"]=>
//    array(1) {
//      ["continue"]=>
//      string(18) "தொடர்க"
//    }
//  }
    }

    function ajax_ai_generate() {
        check_ajax_referer('tnp-ai');

        require_once ABSPATH . 'wp-admin/includes/translation-install.php';
        $translations = wp_get_available_translations();
        $language = 'English';
        if (isset($translations[get_locale()])) {
            $language = $translations[get_locale()]['english_name'];
        }

        $url = 'https://api.thenewsletterplugin.com/api/generate';

        $response = wp_remote_post($url, ['timeout' => 60,
            'body' => [
                'language' => $language,
                'prompt' => stripslashes($_POST['prompt']),
                'site_title' => get_bloginfo('name'),
                'site_description' => get_bloginfo('description'),
                'site_domain' => home_url(),
                'api_key' => Newsletter::instance()->get_license_key()]
        ]);

        if (is_wp_error($response)) {
            $this->get_logger()->error($response);
            wp_send_json_error($response);
            die();
        }

        if (wp_remote_retrieve_response_code($response) !== 200) {
            $this->get_logger()->error($response);
            return wp_send_json_error(wp_remote_retrieve_response_message($response), wp_remote_retrieve_response_code($response));
            die();
        }

        $json = wp_remote_retrieve_body($response);
        $data = json_decode($json);
        $data = array_map('esc_html', $data);
        $html = implode('<br>', $data);
        echo $html;
        die();
    }

    function hook_admin_menu() {
        add_submenu_page('newsletter_main_index', 'AI', '<span class="tnp-side-menu">AI</span>', 'exist', 'newsletter_ai_index', function () {
            require __DIR__ . '/admin/index.php';
        });
    }

    function hook_newsletter_menu_newsletters($entries) {
        $entries[] = ['label' => 'AI', 'url' => '?page=newsletter_ai_index'];
        return $entries;
    }
}
