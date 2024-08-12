<?php

class NewsletterLeads extends NewsletterAddon {

    /**
     * @return NewsletterLeads
     */
    static $instance;
    static $leads_colors = array(
        'autumn' => array('#db725d', '#5197d5'),
        'winter' => array('#38495c', '#5197d5'),
        'summer' => array('#eac545', '#55ab68'),
        'spring' => array('#80c99d', '#ee7e33'),
        'sunset' => array('#d35400', '#ee7e33'),
        'night' => array('#204f56', '#ee7e33'),
        'sky' => array('#5197d5', '#55ab68'),
        'forest' => array('#55ab68', '#5197d5'),
    );
    var $labels;
    var $popup_test = false;
    var $topbar_test = false;
    var $inject_test = false;
    var $popup_enabled = false;
    var $bar_enabled = false;
    var $inject_bottom_enabled = false;

    function __construct($version) {
        self::$instance = $this;
        parent::__construct('leads', $version);

        $this->setup_options();
        $this->popup_test = isset($_GET['newsletter_leads_popup']);
        $this->topbar_test = isset($_GET['newsletter_leads_topbar']);
        $this->inject_test = isset($_GET['newsletter_leads_inject']);
        $this->popup_enabled = !empty($this->options['popup-enabled']);
        $this->bar_enabled = !empty($this->options['bar-enabled']);
        $this->inject_bottom_enabled = !empty($this->options['inject_bottom_enabled']);
    }

    function upgrade($first_install = false) {
        parent::upgrade($first_install);

        $this->merge_defaults([
            'width' => 650,
            'height' => '',
            'delay' => 2,
            'count' => 0,
            'days' => 30,
            'theme_subscribe_label' => 'Subscribe',
            'theme_popup_color' => 'winter',
            'theme_bar_color' => 'winter',
            'inject_labels' => '1'
        ]);
    }

    function init() {

        parent::init();

        if (!is_admin()) {
            if ($this->popup_enabled || $this->bar_enabled || $this->topbar_test || $this->popup_test) {
                add_action('wp_footer', [$this, 'hook_wp_footer'], 99);
                add_action('wp_enqueue_scripts', [$this, 'hook_wp_enqueue_scripts']);
            }

            if ($this->inject_bottom_enabled) {
                add_filter('the_content', [$this, 'hook_the_content']);
            }
        } else {
            if ($this->is_allowed()) {
                add_action('admin_menu', [$this, 'hook_admin_menu'], 100);
                add_filter('newsletter_menu_subscription', [$this, 'hook_newsletter_menu_subscription']);
            }
        }

        add_action('newsletter_action', [$this, 'hook_newsletter_action']);
    }

    function weekly_check() {
        parent::weekly_check();
        $license_key = Newsletter::instance()->get_license_key();
        $response = wp_remote_post('https://www.thenewsletterplugin.com/wp-content/addon-check.php?k=' . urlencode($license_key)
                . '&a=' . urlencode($this->name) . '&d=' . urlencode(home_url()) . '&v=' . urlencode($this->version)
                . '&ml=' . (Newsletter::instance()->is_multilanguage() ? '1' : '0'));
    }

    function hook_newsletter_action($action) {
        switch ($action) {
            case 'leads-popup':
                include __DIR__ . '/modal.php';
                die();
        }
    }

    function hook_newsletter_menu_subscription($entries) {
        $entries[] = array('label' => 'Leads', 'url' => '?page=newsletter_leads_index', 'description' => 'Simple subscription systems');
        return $entries;
    }

    function hook_admin_menu() {
        add_submenu_page('newsletter_main_index', 'Leads', '<span class="tnp-side-menu">Leads</span>', 'exist', 'newsletter_leads_index', function () {
            include __DIR__ . '/admin/index.php';
        });
        add_submenu_page('admin.php', 'Topbar', '<span class="tnp-side-menu">Topbar</span>', 'exist', 'newsletter_leads_topbar',
                function () {
                    include __DIR__ . '/admin/topbar.php';
                }
        );
        add_submenu_page('admin.php', 'Injection', '<span class="tnp-side-menu">Injection</span>', 'exist', 'newsletter_leads_inject',
                function () {
                    include __DIR__ . '/admin/inject.php';
                }
        );
    }

    function hook_the_content($content) {

        if (!$this->inject_test) {
            if (!is_single()) {
                return $content;
            }

            if ('post' !== get_post_type()) {
                return $content;
            }

            // Check excluded categories
            if (!empty($this->options['inject_exclude_categories'])) {
                $categories = array_map('intval', $this->options['inject_exclude_categories']);
                if ($categories && has_category($categories)) {
                    return $content;
                }
            }
        }

        // Check excluded tags

        $style = '';
        if (!empty($this->options['inject_bottom_background']['id'])) {
            $src = wp_get_attachment_image_src($this->options['inject_bottom_background']['id'], 'full');
            $style .= 'background-image: url(\'' . $src[0] . '\'); background-size: cover; background-repeat: no-repeat;';
        }

        $options = $this->get_options($this->get_current_language());

        $form_attrs = [];
        switch ($this->options['inject_bottom_color']) {
            case 'custom':
                $style .= 'background-color: ' . sanitize_hex_color($this->options['inject_bottom_color_1']) . ';';
                $style .= 'color: ' . sanitize_hex_color($this->options['inject_bottom_color_3']) . ';';
                $form_attrs['button_color'] = sanitize_hex_color($this->options['inject_bottom_color_2']);
                break;
            case 'default':
                break;
            case 'winter':
            case 'night':
            case 'sunset':
                $colors = NewsletterLeads::$leads_colors[$this->options['inject_bottom_color']];
                $style .= 'background-color: ' . sanitize_hex_color($colors[0]) . ';';
                $style .= 'color: #fff !important;';
                $form_attrs['button_color'] = sanitize_hex_color($colors[1]);
            default:
                $colors = NewsletterLeads::$leads_colors[$this->options['inject_bottom_color']];
                $style .= 'background-color: ' . sanitize_hex_color($colors[0]) . ';';
                $form_attrs['button_color'] = sanitize_hex_color($colors[1]);
        }

        $form_attrs['show_labels'] = empty($this->options['inject_labels']) ? 'false' : 'true';

        return $content
                . '<div class="tnp-subscription-posts" id="newsletter-leads-bottom"'
                . ' style="' . esc_attr($style) . '"'
                . '>'
                . $options['inject_bottom_pre']
                . NewsletterSubscription::instance()->get_subscription_form('posts_bottom', null, $form_attrs)
                . $options['inject_bottom_post']
                . '</div>';
    }

    function hook_wp_enqueue_scripts() {

        wp_enqueue_style('newsletter-leads', plugins_url('newsletter-leads') . '/css/leads.css', [], $this->version);
        if (is_rtl()) {
            wp_enqueue_style('newsletter-leads-rtl', plugins_url('newsletter-leads') . '/css/leads-rtl.css', [], $this->version);
        }

        if ($this->popup_enabled || $this->popup_test) {

            $background_color = '';
            $font_color = '';
            $button_color = '';

            switch ($this->options['theme_popup_color']) {
                case 'custom':
                    $background_color = sanitize_hex_color($this->options['theme_popup_color_1']);
                    $font_color = sanitize_hex_color($this->options['theme_popup_color_3'] ?? '#ffffff');
                    $button_color = sanitize_hex_color($this->options['theme_popup_color_2']);
                    break;
                case 'default':
                    break;
                case 'winter':
                case 'night':
                case 'sunset':
                    $colors = NewsletterLeads::$leads_colors[$this->options['theme_popup_color']];
                    $background_color = $colors[0];
                    $font_color = '#ffffff';
                    $button_color = $colors[1];
                default:
                    $colors = NewsletterLeads::$leads_colors[$this->options['theme_popup_color']];
                    $background_color = $colors[0];
                    $font_color = '#ffffff';
                    $button_color = $colors[1];
            }

            if ($this->options['theme_popup_color'] == 'custom') {
                $theme_popup_color = array($this->options['theme_popup_color_1'], $this->options['theme_popup_color_2']);
            } else {
                $theme_popup_color = NewsletterLeads::$leads_colors[$this->options['theme_popup_color']];
            }

            $background_image = 'none';
            if (!empty($this->options['theme_background']['id'])) {
                $src = wp_get_attachment_image_src($this->options['theme_background']['id'], 'full');
                $background_image = 'url(\'' . $src[0] . '\')';
            }

            ob_start();
            ?>
            #tnp-modal-content {
            height:<?php echo (empty($this->options['height']) ? 'auto' : (int) $this->options['height']); ?>px;
            width:<?php echo (int) $this->options['width']; ?>px;
            background-color: <?php echo $background_color ?> !important;
            background-image: <?php echo $background_image ?>;
            background-repeat: no-repeat;
            background-size: cover;
            color: <?php echo $font_color ?>;
            }

            #tnp-modal-body {
            color: <?php echo $font_color ?>;
            }

            #tnp-modal-body .tnp-privacy-field {
            color: <?php echo $font_color ?>;
            }

            #tnp-modal-body .tnp-privacy-field label a {
            color: <?php echo $font_color ?>;
            }

            #tnp-modal-content input.tnp-submit {
            background-color: <?php echo $button_color ?>;
            border: none;
            background-image: none;
            color: #fff;
            cursor: pointer;
            }

            #tnp-modal-content input.tnp-submit:hover {
            filter: brightness(110%);
            }

            .tnp-modal {
            text-align: center;
            padding: 30px;
            }

            <?php
            $css = ob_get_clean();
            wp_add_inline_style('newsletter-leads', $css);
        }

        if ($this->bar_enabled || $this->topbar_test) {
            if (isset($this->options['theme_bar_color'])) {
                if ($this->options['theme_bar_color'] == 'custom') {
                    $theme_bar_color = array($this->options['theme_bar_color_1'], $this->options['theme_bar_color_2']);
                } else {
                    $theme_bar_color = NewsletterLeads::$leads_colors[$this->options['theme_bar_color']];
                }
            }
            ob_start();
            ?>
            #tnp-leads-topbar {
            <?php if ($this->options['position'] == "top") { ?>
                top: -200px;
                transition: top 1s;
            <?php } else { ?>
                bottom: -200px;
                transition: bottom 1s;
            <?php } ?>
            }
            #tnp-leads-topbar.tnp-leads-topbar-show {
            <?php if ($this->options['position'] == "top") { ?>
                <?php if (is_admin_bar_showing()) { ?>
                    top:32px;
                <?php } else { ?>
                    top:0px;
                <?php } ?>
            <?php } else { ?>
                bottom:0px;
            <?php } ?>
            }
            #tnp-leads-topbar {
            background-color: <?php echo $theme_bar_color[0] ?> !important;
            }
            #tnp-leads-topbar .tnp-subscription-minimal input.tnp-email {
            width: auto!important;
            }
            #tnp-leads-topbar .tnp-subscription-minimal input.tnp-submit {
            background-color: <?php echo $theme_bar_color[1] ?> !important;
            width: auto!important;
            }
            <?php
            $css = ob_get_clean();
            wp_add_inline_style('newsletter-leads', $css);
        }
    }

    function hook_wp_footer() {

        // If not in test mode and the current visitor is subscribed, do not activate
        if (!$this->popup_test && !$this->topbar_test) {
            $user = Newsletter::instance()->check_user();
            if ($user && $user->status == 'C') {
                return;
            }
        }

        $current_language = $this->get_current_language();

        if ($this->bar_enabled || $this->topbar_test) {
            ?>
            <div id="tnp-leads-topbar">
                <?php echo $this->getBarMinimalForm(); ?>
                <label id="tnp-leads-topbar-close" onclick="tnp_leads_close_topbar()"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24"><g  transform="translate(0, 0)"><circle fill="#fff" stroke="#fff" stroke-width="1" stroke-linecap="square" stroke-miterlimit="10" cx="12" cy="12" r="11" stroke-linejoin="miter"/><line data-color="color-2" fill="#fff" stroke="#343434" stroke-width="1" stroke-linecap="square" stroke-miterlimit="10" x1="16" y1="8" x2="8" y2="16" stroke-linejoin="miter"/><line data-color="color-2" fill="none" stroke="#343434" stroke-width="1" stroke-linecap="square" stroke-miterlimit="10" x1="16" y1="16" x2="8" y2="8" stroke-linejoin="miter"/></g></svg></label>
            </div>
            <script>
                var tnp_leads_restart = <?php echo (int) $this->options['days'] * 24 * 3600 * 1000 ?>;
                var tnp_leads_topbar_test = <?php echo $this->topbar_test ? 'true' : 'false' ?>;
                function tnp_leads_close_topbar() {
                    window.localStorage.setItem('tnp-leads-topbar', '' + (new Date().getTime()));
                    document.getElementById('tnp-leads-topbar').className = '';
                }
                document.addEventListener("DOMContentLoaded", function () {
                    let time = window.localStorage.getItem('tnp-leads-topbar');
                    if (!tnp_leads_topbar_test && time !== null && (new Date().getTime()) < parseInt(time) + tnp_leads_restart) {
                        document.getElementById('tnp-leads-topbar').style.display = 'none';
                    } else {
                        document.getElementById('tnp-leads-topbar').className = 'tnp-leads-topbar-show';
                    }
                });
            </script>
            <?php
        }

        if ($this->popup_enabled || $this->popup_test) {
            ?>
            <div id="tnp-modal">
                <div id="tnp-modal-content">
                    <div id="tnp-modal-close">&times;</div>
                    <div id="tnp-modal-body">
                    </div>
                </div>
            </div>

            <script>
                var tnp_leads_popup_test = <?php echo $this->popup_test ? 'true' : 'false' ?>;
                var tnp_leads_delay = <?php echo $this->options['delay'] * 1000 ?>; // milliseconds
                var tnp_leads_days = '<?php echo (int) $this->options['days'] ?>';
                var tnp_leads_count = <?php echo (int) $this->options['count']; ?>;
                var tnp_leads_url = '<?php echo Newsletter::add_qs(home_url('/'), 'na=leads-popup&language=' . $current_language) ?>';
                var tnp_leads_post = '<?php echo home_url('/') . '?na=ajaxsub' ?>';
            </script>
            <script src="<?php echo plugins_url('newsletter-leads') ?>/public/leads.js"></script>
            <?php
        }
    }

    private function getBarMinimalForm() {

        $subscription = NewsletterSubscription::instance();

        $language = $subscription->get_current_language();
        $options = $this->get_options($language);

        if (empty($options['bar_subscribe_label'])) {
            $options['bar_subscribe_label'] = $subscription->get_form_text('subscribe');
        }

        if (empty($options['bar_placeholder'])) {
            $options['bar_placeholder'] = $subscription->get_form_text('email');
        }

        $form = '<div class="tnp tnp-subscription-minimal">';
        $form .= '<form action="' . esc_attr($subscription->get_subscribe_url()) . '" method="post">';

        if (!empty($this->options['bar_list'])) {
            $form .= "<input type='hidden' name='nl[]' value='" . esc_attr($this->options['bar_list']) . "'>\n";
        }
        $form .= '<input type="hidden" name="nr" value="leads-bar">';
        $form .= '<input type="hidden" name="nlang" value="' . esc_attr($language) . '">' . "\n";
        $form .= '<input class="tnp-email" type="email" required name="ne" value="" placeholder="' . esc_attr($options['bar_placeholder']) . '">';
        $form .= '<input class="tnp-submit" type="submit" value="' . esc_attr($options['bar_subscribe_label']) . '">';

        // If SET it DISABLES the privacy field
        if (empty($options['bar_field_privacy'])) {
            $privacy_field = $subscription->get_privacy_field();
            if (!empty($privacy_field)) {
                $form .= '<div class="tnp-privacy-field">' . $privacy_field . '</div>';
            }
        }

        $form .= "</form></div>\n";

        return $form;
    }
}
