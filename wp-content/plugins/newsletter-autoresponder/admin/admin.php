<?php

class NewsletterAutoresponderAdmin extends NewsletterAddonAdmin {

    /**
     * @var NewsletterAutoresponder
     */
    static $instance;
    var $store;
    public $autoresponder_table;
    public $autoresponder_steps_table;

    function __construct($name, $version, $dir) {
        global $wpdb;

        self::$instance = $this;

        parent::__construct('autoresponder', $version, __DIR__);
        $this->setup_options();

        $this->autoresponder_table = $wpdb->prefix . "newsletter_autoresponder";
        $this->autoresponder_steps_table = $wpdb->prefix . "newsletter_autoresponder_steps";
    }

    static function instance() {
        return self::$instance;
    }

    function init() {

        parent::init();

        if (Newsletter::instance()->is_allowed()) {
            add_filter('newsletter_menu_newsletters', array($this, 'hook_newsletter_menu_newsletters'));
            add_filter('newsletter_lists_notes', array($this, 'hook_newsletter_lists_notes'), 10, 2);

            add_action('newsletter_users_edit_autoresponders', [$this, 'hook_newsletter_users_edit_autoresponders'], 10, 2);
            add_action('newsletter_users_edit_autoresponders_init', [$this, 'hook_newsletter_users_edit_autoresponders_init'], 10, 2);
            add_filter('newsletter_support_data', [$this, 'hook_newsletter_support_data'], 10, 1);
        }

        wp_unschedule_hook('newsletter_autoresponder');

        if (wp_next_scheduled('newsletter_autoresponder_align') === false) {
            wp_schedule_event(time() + HOUR_IN_SECONDS, 'hourly', 'newsletter_autoresponder_align');
        }
    }

    function get_autoresponder($id) {
        return NewsletterAutoresponder::instance()->get_autoresponder($id);
    }

    function get_autoresponders() {
        return NewsletterAutoresponder::instance()->get_autoresponders();
    }

    function delete_autoresponder($id) {
        global $wpdb;

        $logger = $this->get_logger();
        $logger->info('Deletion of autoresponder ' . $id);

        $autoresponder = $this->get_autoresponder($id);
        if (!$autoresponder) {
            $logger->error('Autoresponder not found');
            return false;
        }

        $logger->info($autoresponder);

        $res = $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->prefix}newsletter_autoresponder where id=%d limit 1", $id));
        if ($res) {
            $res = $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->prefix}newsletter_autoresponder_steps where autoresponder_id=%d", $id));
            Newsletter::instance()->delete_email($autoresponder->emails);
        }

        return $res;
    }

    /**
     *
     * @global wpdb $wpdb
     * @param array|stdClass|TNP_Autoresponder $autoresponder
     */
    function save_autoresponder($autoresponder) {
        global $wpdb;
        if (is_object($autoresponder)) {
            $autoresponder = (array) $autoresponder;
        }
        if (isset($autoresponder['emails']) && is_array($autoresponder['emails'])) {
            $autoresponder['emails'] = implode(',', $autoresponder['emails']);
        }
        if (isset($autoresponder['new_lists']) && is_array($autoresponder['new_lists'])) {
            $autoresponder['new_lists'] = implode(',', $autoresponder['new_lists']);
        }

        if (isset($autoresponder['theme']) && (is_array($autoresponder['theme']) || is_object($autoresponder['theme']))) {
            $autoresponder['theme'] = json_encode($autoresponder['theme']);
        }

        $store = $this->get_store();

        $autoresponder = $store->save($wpdb->prefix . "newsletter_autoresponder", $autoresponder);
        $autoresponder = $this->get_autoresponder($autoresponder->id);

        $newsletter = Newsletter::instance();
        if ($autoresponder->utm_source) {
            $step = 1;
            foreach ($autoresponder->emails as $email_id) {
                $email = $newsletter->get_email($email_id);
                if ($email) {
                    $email->options['utm_campaign'] = $autoresponder->utm_campaign;
                    $email->options['utm_source'] = str_replace('{step}', $step, $autoresponder->utm_source);
                    $email->options['utm_medium'] = $autoresponder->utm_medium;
                    $email->options['utm_term'] = $autoresponder->utm_term;
                    $email->options['utm_content'] = $autoresponder->utm_content;
                    $newsletter->save_email($email);
                }
                $step++;
            }
        }

        return $autoresponder;
    }

    function hook_newsletter_support_data($data) {
        $autoresponders = $this->get_autoresponders();
        $autoresponder_data = [];
        $autoresponder_data['version'] = $this->version;
        foreach ($autoresponders as $a) {
            $autoresponder_data['autoresponder-' . $a->id] = (array) $a;
        }

        $data['autoresponder'] = $autoresponder_data;
        return $data;
    }

    function format_delay($delay) {
        $days = floor($delay / 24);
        $hours = $delay % 24;
        if ($days)
            $b = $days . ' day(s), ' . $hours . ' hour(s)';
        else
            $b = $hours . ' hour(s)';

        return $b;
    }

    function hook_newsletter_menu_newsletters($entries) {
        $entries[] = [
            'label' => 'Autoresponder',
            'url' => '?page=newsletter_autoresponder_index'
        ];
        return $entries;
    }

    function hook_newsletter_lists_notes($notes, $list_id) {
        static $autoresponders = null;
        if (is_null($autoresponders)) {
            $autoresponders = $this->get_autoresponders();
        }
        foreach ($autoresponders as $autoresponder) {
            if ($autoresponder->list == $list_id) {
                $notes[] = 'Linked to email series "' . esc_html($autoresponder->name) . '"';
            }
        }
        return $notes;
    }

    public function get_status_label($status) {
        switch ($status) {
            case TNP_Autoresponder_Step::STATUS_COMPLETED: return 'Completed';
            case TNP_Autoresponder_Step::STATUS_NOT_CONFIRMED: return 'Stopped: unsubscribed';
            case TNP_Autoresponder_Step::STATUS_NOT_IN_LIST: return 'Stopped: not in list';
            case TNP_Autoresponder_Step::STATUS_NO_USER: return 'Stopped: missing subscriber';
            case TNP_Autoresponder_Step::STATUS_RUNNING: return 'Running';
            case TNP_Autoresponder_Step::STATUS_STOPPED: return 'Manually stopped';
        }
    }

    /**
     * Invoked only if the current user is allowed.
     */
    function admin_menu() {
        add_submenu_page('newsletter_main_index', 'Autoresponder', '<span class="tnp-side-menu">Autoresponder</span>', 'exist', 'newsletter_autoresponder_index', function () {
            require __DIR__ . '/index.php';
        });

        add_submenu_page('admin.php', 'Autoresponder', 'Autoresponder', 'exist', 'newsletter_autoresponder_messages', function () {
            require __DIR__ . '/messages.php';
        });

        add_submenu_page('admin.php', 'Autoresponder', 'Autoresponder', 'exist', 'newsletter_autoresponder_edit', function () {
            require __DIR__ . '/edit.php';
        });

        add_submenu_page('admin.php', 'Autoresponder', 'Autoresponder', 'exist', 'newsletter_autoresponder_email', function () {
            require __DIR__ . '/edit-email.php';
        });

        add_submenu_page('admin.php', 'Autoresponder', 'Autoresponder', 'exist', 'newsletter_autoresponder_composer', function () {
            require __DIR__ . '/edit-email-composer.php';
        });

        add_submenu_page('admin.php', 'Theme', 'Theme', 'exist', 'newsletter_autoresponder_theme', function () {
            require __DIR__ . '/theme.php';
        });
        add_submenu_page('admin.php', 'Statistics', 'Statistics', 'exist', 'newsletter_autoresponder_statistics', function () {
            require __DIR__ . '/statistics.php';
        });
        add_submenu_page('admin.php', 'Subscribers', 'Subscribers', 'exist', 'newsletter_autoresponder_users', function () {
            require __DIR__ . '/users.php';
        });
        add_submenu_page('admin.php', 'Maintenance', 'Maintenance', 'exist', 'newsletter_autoresponder_maintenance', function () {
            require __DIR__ . '/maintenance.php';
        });

//        add_submenu_page('', 'Welcome series', 'Welcome series', 'exist', 'newsletter_autoresponder_subscription_index', function () {
//            require __DIR__ . '/admin/subscription/index.php';
//        });
    }

    /**
     *
     * @global wpdb $wpdb
     * @param int $id
     * @return mixed
     */
    function copy_autoresponder($id) {

        $origin_autoresponder = $this->get_autoresponder($id);
        $emails_id_to_duplicate = $origin_autoresponder->emails;
        $origin_autoresponder->status = 0;
        $origin_autoresponder->name .= ' (copy)';
        unset($origin_autoresponder->id);
        unset($origin_autoresponder->emails);

        $new_autoresponder = $this->save_autoresponder($origin_autoresponder);

        $duplicate_emails_id = [];
        foreach ($emails_id_to_duplicate as $email_id) {
//Duplicate email
            $original_email = Newsletter::instance()->get_email($email_id);

            $email = [];
            $email['subject'] = $original_email->subject;
            $email['message'] = $original_email->message;
            $email['message_text'] = $original_email->message_text;
            $email['type'] = 'autoresponder_' . $new_autoresponder->id;
            $email['editor'] = $original_email->editor;
            $email['options'] = $original_email->options;
            $email['track'] = 1;
            $email['status'] = 'sent'; // Imposto lo stato a 'sent' perchè altrimenti non sarebbe possibile la visualizzazione online della mail

            $new_email = NewsletterEmails::instance()->save_email($email);

//Save id to array
            $duplicate_emails_id[] = $new_email->id;
        }

        $new_autoresponder->emails = $duplicate_emails_id;

        return $this->save_autoresponder($new_autoresponder);
    }

    function set_step_status($step_id, $status) {
        return NewsletterAutoresponder::instance()->set_step_status($step_id, $status);
    }

    function get_step($user_id, $autoresponder_id) {
        return NewsletterAutoresponder::instance()->get_step($user_id, $autoresponder_id);
    }

    function save_step($step) {
        return NewsletterAutoresponder::instance()->save_step($step);
    }

    function do_next_step($autoresponder_id, $user_id) {
        $logger = $this->get_logger();
        $autoresponder = $this->get_autoresponder($autoresponder_id);
        $user = Newsletter::instance()->get_user($user_id);

        $step = $this->get_step($user_id, $autoresponder_id);
        $logger->debug($step);
        if ($step->status != TNP_Autoresponder_Step::STATUS_RUNNING) {
            $logger->debug('Not running');
            return;
        }
        if ($user->status != TNP_User::STATUS_CONFIRMED) {
            $logger->error('Subscriber not confirmed, add block');
            $this->set_step_status($step->id, TNP_Autoresponder_Step::STATUS_NOT_CONFIRMED);
            return;
        }

        if (!empty($list) && empty($autoresponder->keep_active)) {
            $field = 'list_' . $list;
            if ($user->$field != 1) {
                $logger->error('User no more in this list, add block');
                $this->set_step_status($step->id, TNP_Autoresponder_Step::STATUS_NOT_IN_LIST);
                return;
            }
        }

        $result = NewsletterAutoresponder::instance()->send($user, $autoresponder, $step);
    }

    function hook_newsletter_users_edit_autoresponders($user, $controls) {
        include __DIR__ . '/users/index.php';
    }

    /**
     *
     * @param type $user
     * @param NewsletterControls $controls
     */
    function hook_newsletter_users_edit_autoresponders_init($user, $controls) {
        global $wpdb;
        if ($controls->is_action('restore')) {
            $autoresponder = $this->get_autoresponder($controls->button_data);
            if (!$autoresponder) {
                die('Wrong autoresponder ID');
            }
            if (!empty($autoresponder->list)) {
                $list = (int) $autoresponder->list;
                Newsletter::instance()->set_user_list($user, $list, 1);
            }
            $wpdb->query($wpdb->prepare("update {$wpdb->prefix}newsletter_autoresponder_steps set status=0 where user_id=%d and autoresponder_id=%d limit 1", $user->id, $autoresponder->id));
            $controls->add_toast_done();
        }

        if ($controls->is_action('restart')) {
            $autoresponder = $this->get_autoresponder($controls->button_data);
            if (!$autoresponder) {
                die('Wrong autoresponder ID');
            }
            if (!empty($autoresponder->list)) {
                $list = (int) $autoresponder->list;
                Newsletter::instance()->set_user_list($user, $list, 1);
            }

            $emails = $autoresponder->emails;
            $email = Newsletter::instance()->get_email($emails[0]);
            $send_at = time() + $email->options['delay'] * 3600;
            $wpdb->query($wpdb->prepare("update " . $wpdb->prefix . "newsletter_autoresponder_steps set status=0, step=0, send_at=%d where user_id=%d and autoresponder_id=%d limit 1", $send_at, $user->id, $autoresponder->id));
            $controls->add_toast_done();
        }

        if ($controls->is_action('continue')) {
            $autoresponder = $this->get_autoresponder($controls->button_data);
            if (!$autoresponder) {
                die('Wrong autoresponder ID');
            }
            $step = $this->get_step($user->id, $autoresponder->id);
            $step->step++;

            $emails = $autoresponder->emails;
            $email = Newsletter::instance()->get_email($emails[$step->step]);

            if (!$email) {
                $controls->errors = 'No new steps available';
            } else {
                $this->move_completed_subscriber_to_next_step($user->id, $autoresponder->id, $email);
            }
            $controls->add_toast_done();
        }

        if ($controls->is_action('stop')) {
            $this->set_step_status($controls->button_data, TNP_Autoresponder_Step::STATUS_STOPPED);
            $controls->add_toast_done();
        }

        if ($controls->is_action('attach')) {
            $autoresponder = $this->get_autoresponder($controls->button_data);
            if (!$autoresponder) {
                die('Wrong autoresponder ID');
            }
            NewsletterAutoresponder::instance()->create_step($user, $autoresponder);
        }
    }

    /**
     *
     * @param TNP_Autoresponder $autoresponder
     */
    public function get_user_count($autoresponder) {
        global $wpdb;
        return $wpdb->get_var($wpdb->prepare(
                                "select count(*) from {$wpdb->prefix}newsletter_autoresponder_steps where status=%d and autoresponder_id=%d",
                                TNP_Autoresponder_Step::STATUS_RUNNING, $autoresponder->id));
    }

    public function get_user_counts($autoresponder) {
        global $wpdb;
        $data = $wpdb->get_row($wpdb->prepare("SELECT COUNT(*) AS total,
            COUNT(case when STATUS = %d then 1 END) AS running,
            COUNT(case when STATUS = 1 then 1 END) AS completed FROM wp_newsletter_autoresponder_steps WHERE autoresponder_id=%d",
                        TNP_Autoresponder_Step::STATUS_RUNNING, TNP_Autoresponder_Step::STATUS_COMPLETED, $autoresponder->id));

        $data->stopped = $data->total - $data->running - $data->completed;
        return $data;
    }

    public function get_late_user_count($autoresponder) {
        global $wpdb;
        return $wpdb->get_var($wpdb->prepare("select count(*) from {$wpdb->prefix}newsletter_autoresponder_steps where status=%d "
                                . "and send_at<%d and autoresponder_id=%d",
                                TNP_Autoresponder_Step::STATUS_RUNNING, time() - 900, $autoresponder->id));
    }

    function get_early_completed_count($autoresponder) {
        global $wpdb;

        $r = $wpdb->get_row($wpdb->prepare("select * from {$wpdb->prefix}newsletter_autoresponder_steps where autoresponder_id=%d and status=1 and step<%d limit 1",
                        $autoresponder->id, count($autoresponder->emails) - 1));

        return $r;
    }

    function get_subscribers_count_waiting_on_step($autoresponder_id, $step_id) {
        global $wpdb;

        $query = $wpdb->prepare("SELECT count(*) FROM $this->autoresponder_steps_table WHERE autoresponder_id=%d AND step=%d AND status=%d",
                $autoresponder_id,
                $step_id,
                TNP_Autoresponder_Step::STATUS_RUNNING
        );

        return (int) $wpdb->get_var($query);
    }

    function get_late_subscribers_count_waiting_on_step($autoresponder_id, $step_id) {
        global $wpdb;

        $query = $wpdb->prepare("SELECT count(*) FROM $this->autoresponder_steps_table WHERE autoresponder_id=%d AND step=%d AND status=%d AND send_at<%d",
                $autoresponder_id,
                $step_id,
                TNP_Autoresponder_Step::STATUS_RUNNING,
                time() - 600
        );

        return (int) $wpdb->get_var($query);
    }

    /**
     * Get list of users with TNP_Autoresponder_Step::STATUS_COMPLETED status inside steps
     *
     * @return array
     */
    public function get_completed_subscribers_by_steps($autoresponder) {

        $completed_subscriber_by_steps = [];
        foreach ($autoresponder->emails as $step => $email) {
            $completed_subscriber_by_steps[$step] = $this->get_completed_subscribers_id_by_step($autoresponder->id, $step);
        }

        return $completed_subscriber_by_steps;
    }

    private function get_completed_subscribers_id_by_step($autoresponder_id, $step_id) {
        global $wpdb;

        $query = $wpdb->prepare("SELECT user_id FROM $this->autoresponder_steps_table WHERE autoresponder_id=%d AND step=%d AND status=%d",
                $autoresponder_id,
                $step_id,
                TNP_Autoresponder_Step::STATUS_COMPLETED
        );

        $subscriber_id_list = array_map(function ($record) {
            return (int) $record->user_id;
        }, $wpdb->get_results($query));

        return $subscriber_id_list;
    }

    /**
     * Check if there are subscribers with TNP_Autoresponder_Step::STATUS_COMPLETED to move to new steps
     *
     * @return false
     */
    public function need_to_move_completed_subscribers($autoresponder) {
        $subscribers_to_move = $this->get_completed_subscribers_by_steps($autoresponder);
        $max_steps = count($autoresponder->emails) - 1;

        $need_to_move = false;
        foreach ($subscribers_to_move as $step => $subscribers_on_step) {
            if ($step < $max_steps && count($subscribers_on_step) > 0) {
                $need_to_move = true;
            }
        }

        return $need_to_move;
    }

    /**
     * Reschedule
     */
    public function move_subscribers_with_completed_status_to_new_step($autoresponder) {

        $subscribers_to_move = $this->get_completed_subscribers_by_steps($autoresponder);
        $max_steps = count($autoresponder->emails) - 1;

        foreach ($subscribers_to_move as $step => $subscribers_on_step) {

            if ($step < $max_steps && count($subscribers_on_step) > 0) {

                $next_step = $step + 1;
                if (!isset($autoresponder->emails[$next_step])) {
                    throw new Exception('Invalid email step');
                }

                $next_step_email = Newsletter::instance()->get_email($autoresponder->emails[$next_step]);

                foreach ($subscribers_on_step as $subscriber_id) {

                    $step_row = $this->get_step($subscriber_id, $autoresponder->id);

                    $step_row->send_at += $next_step_email->options['delay'] * 3600;
                    $step_row->status = TNP_Autoresponder_Step::STATUS_RUNNING;
                    $step_row->step++;

                    $this->save_step($step_row);
                }
            }
        }
    }

    function move_completed_subscriber_to_next_step($subscriber_id, $autoresponder_id, $next_step_email) {

        $step_row = $this->get_step($subscriber_id, $autoresponder_id);

        $step_row->send_at += $next_step_email->options['delay'] * 3600;
        $step_row->status = TNP_Autoresponder_Step::STATUS_RUNNING;
        $step_row->step++;

        $this->save_step($step_row);
    }

    function delete_orphan_steps() {
        global $wpdb;

        $wpdb->query("delete s from {$wpdb->prefix}newsletter_autoresponder_steps s left join {$wpdb->prefix}newsletter u on u.id=s.user_id where u.id is null");
    }

    function get_store() {
        return NewsletterAutoresponder::instance()->get_store();
    }

    function apply_template($body, $autoresponder) {
        return NewsletterAutoresponder::instance()->apply_template($body, $autoresponder);
    }

    function get_theme($id) {
        return NewsletterAutoresponder::instance()->get_theme($id);
    }

    function get_themes() {
        return NewsletterAutoresponder::instance()->get_themes();
    }
}
