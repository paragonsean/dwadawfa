<?php

class NewsletterEdd extends NewsletterAddon {

    /**
     * @var NewsletterEdd
     */
    static $instance;

    function __construct($version) {
        self::$instance = $this;
        parent::__construct('edd', $version, __DIR__);
        $this->setup_options();
    }

    function init() {
        parent::init();

        add_action('newsletter_register_blocks', function() {
            TNP_Composer::register_block(__DIR__ . '/blocks/edd');
        });

        if (isset($this->options['enabled']) && $this->options['enabled']) {
            add_action('edd_purchase_form_before_submit', [$this, 'hook_edd_purchase_form_before_submit']);
            add_action('edd_complete_purchase', [$this, 'hook_edd_complete_purchase']);
        }

        if (is_admin()) {
            if (Newsletter::instance()->is_allowed()) {
                add_action('admin_menu', array($this, 'hook_admin_menu'), 100);
                add_filter('newsletter_menu_subscription', [$this, 'hook_newsletter_menu_subscription']);
            }
            add_filter('newsletter_lists_notes', [$this, 'hook_newsletter_lists_notes'], 20, 2);
        }
    }

    function weekly_check() {
        parent::weekly_check();
        $license_key = Newsletter::instance()->get_license_key();
        $response = wp_remote_post('https://www.thenewsletterplugin.com/wp-content/addon-check.php?k=' . urlencode($license_key)
                . '&a=' . urlencode($this->name) . '&d=' . urlencode(home_url()) . '&b=' . urlencode(site_url()) . '&v=' . urlencode($this->version)
                . '&ml=' . (Newsletter::instance()->is_multilanguage() ? '1' : '0'));
    }

    function hook_newsletter_menu_subscription($entries) {
        $entries[] = array('label' => 'Easy Digital Downloads', 'url' => '?page=newsletter_edd_index', 'description' => 'Easy Digital Downloads integration');
        return $entries;
    }

    function hook_newsletter_lists_notes($notes, $list_id) {
        for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {

            if (empty($this->options['rule_product_' . $i . '_id'])) {
                continue;
            }

            if ($this->options['rule_product_' . $i . '_list'] == $list_id) {
                $notes[] = 'Linked to specific download purchase';
                break;
            }
        }

        for ($i = 1; $i <= 20; $i++) {
            if (empty($this->options['rule_category_' . $i . '_id'])) {
                continue;
            }

            if ($this->options['rule_category_' . $i . '_list'] == $list_id) {
                $notes[] = 'Linked to download purchase in specific category';
                break;
            }
        }
        return $notes;
    }

    /**
     *
     * @global wpdb $wpdb
     * @param int $order_id
     * @return type
     */
    function edd_purchase_rules($order_id) {
        global $wpdb;

        $logger = $this->get_logger();

        $logger->debug('Processing order completed id ' . $order_id);

        $payment = new EDD_Payment($order_id);

        $items = $payment->downloads;
        $logger->debug('The order contains ' . count($items) . ' items');

        // User data to be updated
        $data = array();

        /* @var $item EDD_Download */
        foreach ($items as $item) {

            // Very object oriented
            $download_id = $item['id'];

            $logger->debug('Checking the product id ' . $download_id);

            // Product rules
            for ($i = 1; $i <= 20; $i++) {
                $logger->debug('Analyzing product rule ' . $i);
                if (empty($this->options['rule_product_' . $i . '_id'])) {
                    $logger->debug('Products not specified');
                    continue;
                }
                if (empty($this->options['rule_product_' . $i . '_list'])) {
                    $logger->debug('List not assigned');
                    continue;
                }

                $id = $this->options['rule_product_' . $i . '_id'];
                $list = (int) $this->options['rule_product_' . $i . '_list'];
                $list_value = empty($this->options['rule_product_' . $i . '_action']) ? 1 : 0;

                $product_ids = explode(',', $id);
                for ($j = 0; $j < count($product_ids); $j++) {
                    $product_ids[$j] = (int) $product_ids[$j];
                }
                $logger->debug('Product ids to check ' . print_r($product_ids, true));
                if (in_array($download_id, $product_ids)) {
                    $logger->debug('Match found');
                    $data['list_' . $list] = $list_value;
                } else {
                    $logger->debug('Match not found');
                }
            }

            // Category rules
            for ($i = 1; $i <= 20; $i++) {
                $logger->debug('Analyzing category rule ' . $i);
                if (empty($this->options['rule_category_' . $i . '_id'])) {
                    $logger->debug('Rule ' . $i . ' is empty');
                    continue;
                }
                if (empty($this->options['rule_category_' . $i . '_list'])) {
                    $logger->debug('List not assigned');
                    continue;
                }

                $id = $this->options['rule_category_' . $i . '_id'];
                $list = $this->options['rule_category_' . $i . '_list'];
                $list_value = empty($this->options['rule_category_' . $i . '_action']) ? 1 : 0;

                $logger->debug('Checking against the categories ' . print_r($id, true));

                if (has_term($id, 'download_category', $download_id)) {
                    $logger->debug('Match found');
                    $data['list_' . $list] = $list_value;
                } else {
                    $logger->debug('Match not found');
                }
            }
        }

        $logger->debug('User data: ' . print_r($data, true));

        // Se l'è el caso, aggiorna la sottoscrizione
        if (!empty($data)) {
            // Trova l'email del cliente, crea la query per il set delle liste
            $email = $payment->email;
            $r = $wpdb->update(NEWSLETTER_USERS_TABLE, $data, array('email' => $email));

            $logger->debug('Update result ' . print_r($r, true));
        }
    }

    /**
     *
     * @param array $posted
     */
    function hook_edd_complete_purchase($payment_id) {

        $logger = $this->get_logger();

        if (empty($payment_id)) {
            return;
        }

        // retrieve the email
        $payment = new EDD_Payment($payment_id);
        $customer = new EDD_Customer($payment->customer_id);

        $email = NewsletterModule::normalize_email($customer->email);

        if (!$email) {
            $logger->debug("Email not valid: " . $email);
            return;
        }

        $is_forced = !$this->options['ask'];
        $is_checked = isset($_POST['tnp-nl']);
        $language = $this->get_current_language();
        if (isset($_POST['tnp-nlang'])) {
            $language = $_POST['tnp-nlang'];
        }

        // If we already have this subscriber (by email) skip the subscription process but update list
        if ($user = Newsletter::instance()->get_user($email)) {
            $logger->info("Subscriber already registered");

            $user_current_status = $user->status;

            // Update user info
            $user = array(
                'id' => $user->id,
                'name' => $customer->name
            );

            $this->update_user_lists_from_addon_preferences($user);

            //If is checked or is forced then force subscription status
            if ($user_current_status != TNP_User::STATUS_CONFIRMED && ( $is_checked || $is_forced )) {
                if ($this->options['confirm'] == 0) {
                    $user['status'] = TNP_User::STATUS_CONFIRMED;
                } else {
                    //TODO not handled case
                }
            }

            Newsletter::instance()->save_user($user);

            return;
        }

        // New subscriber
        if ($is_checked || $is_forced) {
            $logger->info("Subscribing: " . $email);

            $subscription_module = NewsletterSubscription::instance();

            $subscription = $subscription_module->get_default_subscription($language);
            $subscription->optin = $this->options['confirm'] == 0 ? 'single' : 'double';
            $subscription->send_emails = $this->options['confirm'] == 0 ? false : true;

            $subscription->data->email = $email;
            $subscription->data->name = isset($customer->name) ? $customer->name : null;
            $subscription->data->referrer = 'edd-checkout';
            $this->add_addon_lists_preference_to($subscription->data->lists);

            NewsletterSubscription::instance()->subscribe2($subscription);
        }

        $this->edd_purchase_rules($payment_id);
    }

    private function add_addon_lists_preference_to(&$lists) {

        for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
            if (!empty($this->options['preferences_' . $i])) {
                $lists[$i] = 1;
            }
        }
    }

    private function update_user_lists_from_addon_preferences(&$user) {
        // Update the lists set on woocommerce integration preferences
        for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
            if (!empty($this->options['preferences_' . $i])) {
                $user['list_' . $i] = 1;
            }
        }
    }

    function hook_edd_purchase_form_before_submit() {

        //Don't show checkbox if email is already subscribed and confirmed
        if ($this->is_billing_email_already_subscribed_and_confirmed()) {
            if (current_user_can('administrator') && ( $this->options['ask'] == 1 )) {
                echo "<p>The newsletter subscription checkbox is not visible because you are already subscribed. This message is visible only to administrators.</p>";
            }

            return;
        }

        $language = $this->get_current_language();
        echo '<input type="hidden" name="tnp-nlang" value="' . esc_attr($language) . '">';

        if ($this->options['ask'] == 1) {

            $ask_text = $this->get_label('ask_text');

            echo "<p class='tnp-nl-checkout form-row'>
                    <label for='tnp-nl-checkout-checkbox' class='tnp-nl-checkout-label checkbox'>
                        <input type='checkbox' name='tnp-nl' id='tnp-nl-checkout-checkbox' class='input-checkbox' " . ( $this->options['checked'] ? "checked" : "" ) . " />
                        <span>$ask_text</span>
                    </label>
                </p>";
        }
    }

    private function is_billing_email_already_subscribed_and_confirmed() {
        //Don't show checkbox if email is already subscribed and confirmed
        try {
            $customer = new EDD_Customer(get_current_user_id());
            $subscriber = Newsletter::instance()->get_user($customer->email);
            if ($subscriber && $subscriber->status == TNP_User::STATUS_CONFIRMED) {
                return true;
            }
        } catch (Exception $e) {
            //Do nothing!
        }

        return false;
    }

    function hook_admin_menu() {
        add_submenu_page('newsletter_main_index', 'EDD', '<span class="tnp-side-menu">EDD</span>', 'manage_options', 'newsletter_edd_index', [$this, 'menu_page_index']);
        add_submenu_page('admin.php', 'EDD Import', 'EDD Import', 'manage_options', 'newsletter_edd_import', [$this, 'menu_page_import']);
    }

    function menu_page_index() {
        global $wpdb, $newsletter;
        require dirname(__FILE__) . '/index.php';
    }

    function menu_page_import() {
        global $wpdb, $newsletter;
        require dirname(__FILE__) . '/import.php';
    }

    /**
     * Returns a label using the configured values from the options panel, is not empty or the standard
     * values from the gettext files possibly translated by a multilanguage plugin.
     *
     * @param string $key
     * @return string
     */
    function get_label($key) {
        if (!empty($this->options[$key])) {
            return $this->options[$key];
        }

        switch ($key) {
            case 'profile_link_label': return __('Manage your newsletter preferences', 'newsletter-woocommerce');
            case 'ask_text': return __('Subscribe to our newsletter', 'newsletter-woocommerce');
        }
    }
}
