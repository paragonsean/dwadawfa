<?php

class NewsletterArchive extends NewsletterAddon {

    /**
     * @var NewsletterArchive
     */
    static $instance;

    function __construct($version) {
        self::$instance = $this;
        parent::__construct('archive', $version, __DIR__);
        $this->setup_options();
    }

    function init() {
        parent::init();

        if (is_admin()) {
            if (Newsletter::instance()->is_allowed()) {
                add_action('admin_menu', array($this, 'hook_admin_menu'), 100);
                add_filter('newsletter_menu_newsletters', array($this, 'hook_newsletter_menu_newsletters'));
            }
        } else {
            add_shortcode('newsletter_archive', array($this, 'shortcode_archive'));
        }

        add_action('newsletter_action', array($this, 'hook_newsletter_action'));
    }

    function weekly_check() {
        parent::weekly_check();
        $license_key = Newsletter::instance()->get_license_key();
        $response = wp_remote_post('https://www.thenewsletterplugin.com/wp-content/addon-check.php?k=' . rawurlencode($license_key)
                . '&a=' . rawurlencode($this->name) . '&d=' . rawurlencode(home_url()) . '&v=' . rawurlencode($this->version)
                . '&ml=' . (Newsletter::instance()->is_multilanguage() ? '1' : '0'));
    }

    function hook_newsletter_action($action) {
        global $wpdb;
        if ($action === 'archive') {
            $email_id = (int) $_GET['email_id'] ?? 0;
            if (empty($email_id)) {
                die('Wronf email ID');
            }

            $email = $wpdb->get_row($wpdb->prepare("select id, subject, message from " . NEWSLETTER_EMAILS_TABLE . " where private=0 and id=%d and type<>'followup' and status in ('sent', 'sending') limit 1", $email_id));

            if (empty($email)) {
                die('Email not found');
            }

            // Force the UTF-8 charset
            header('Content-Type: text/html;charset=UTF-8');
            $message = do_shortcode($this->replace($email->message), true);

            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo $message;
            die();
        }
    }

    function hook_newsletter_menu_newsletters($entries) {
        $entries[] = array('label' => '<i class="fa fa-archive"></i> Archive', 'url' => '?page=newsletter_archive_index', 'description' => 'Publish your sent newsletters');
        return $entries;
    }

    function shortcode_archive($attrs, $content) {
        global $wpdb;
        static $email_shown = false;

        if ($email_shown)
            return '';


        if (!is_array($attrs))
            $attrs = [];
        $attrs = array_merge(['type' => 'message', 'url' => get_permalink(), 'max' => 10000, 'separator' => '-', 'title' => '', 'list'=>0], $attrs);

        $type = $attrs['type'];
        $max = (int) $attrs['max'];

        // ?
        $show_date = isset($this->options['date']);
        if (isset($attrs['show_date'])) {
            $show_date = true;
        }

        $buffer = '';

        if (isset($_GET['email_id'])) {
            $email_shown = true;
            $email = $wpdb->get_row($wpdb->prepare("select id, subject, message, send_on from " . NEWSLETTER_EMAILS_TABLE . " where id=%d and private=0 and type=%s and status='sent' limit 1", (int) $_GET['email_id'], $type));
            if (!$email) {
                return 'Invalid email identifier';
            }
            $buffer .= '<h2>' . esc_html($this->replace($email->subject, $email)) . '</h2>';
            $buffer .= '<iframe class="tnp-archive-iframe" style="width: 100%; height: 800px; border:1px solid #ddd" framborder="0" ';
            $buffer .= 'src="' . home_url() . '?na=archive&email_id=' . $email->id . '"></iframe>';
        } else {
            $buffer .= '<div class="tnp-archive">';
            if (!empty($attrs['title'])) {
                $buffer .= '<h2>' . $attrs['title'] . '</h2>';
            }
            $emails = $wpdb->get_results($wpdb->prepare("select id, subject, send_on, options from " . NEWSLETTER_EMAILS_TABLE . " where private=0 and type=%s and status='sent' order by send_on desc limit %d", $type, $max));

            $buffer .= $content;

            $buffer .= '<ul>';

            $date_format = get_option('date_format');
            $time_format = get_option('time_format');
            $gmt_offset = get_option('gmt_offset') * 3600;
            if (empty($this->options['show'])) {
                $base_url = $attrs['url'];
            } else {
                $base_url = home_url();
            }

            foreach ($emails as $email) {

                $options = maybe_unserialize($email->options);

                if ($attrs['list'] && (!$options['lists'] || !in_array($attrs['list'], $options['lists']))) {
                    continue;
                }


                // TODO: Other replacements
                $subject = $this->replace($email->subject);

                $buffer .= '<li>';
                if ($show_date) {
                    $d = date_i18n($date_format, $email->send_on + $gmt_offset);
                    $buffer .= ' <span class="tnp-archive-date">' . esc_html($d) . '</span> ';
                    $buffer .= ' <span class="tnp-archive-separator">' . wp_strip_all_tags($attrs['separator']) . '</span> ';
                }
                if (empty($this->options['show'])) {
                    $url = NewsletterModule::add_qs($base_url, 'email_id=' . $email->id);
                    $buffer .= '<a href="' . $url . '">' . esc_html($this->replace($subject, $email)) . '</a>';
                } else {
                    $target = $this->options['show'] === 'self' ? '_self' : '_blank';
                    $url = NewsletterModule::add_qs($base_url, 'na=view&id=' . $email->id);
                    $buffer .= '<a href="' . $url . '" target="' . $target . '">' . esc_html($this->replace($subject, $email)) . '</a>';
                }


                $buffer .= '</li>';
            }

            $buffer .= '</ul></div>';
        }
        return $buffer;
    }

    function replace($text, $email = null) {
        $text = str_replace('{name}', '', $text);
        $text = str_replace('{surname}', '', $text);
        $text = str_replace('{email_url}', '#', $text);
        $text = str_replace('{profile_url}', '#', $text);
        $text = str_replace('%7dprofile_url%7d', '#', $text);
        $text = str_replace('{unsubscription_url}', '#', $text);
        $text = str_replace('{unsubscription_confirm_url}', '#', $text);
        $text = str_replace('%7bemail_url%7d', '#', $text);
        if ($email && $email->send_on) {
                $text = Newsletter::instance()->replace_date($text, $email->send_on);
        }
        return $text;
    }

    function hook_admin_menu() {
        add_submenu_page('newsletter_main_index', 'Archive', '<span class="tnp-side-menu">Archive</a>', 'manage_options', 'newsletter_archive_index', array($this, 'menu_page_index'));
    }

    function menu_page_index() {
        global $wpdb;
        require __DIR__ . '/admin/index.php';
    }
}
