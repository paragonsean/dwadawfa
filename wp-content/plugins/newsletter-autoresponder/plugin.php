<?php

/**
 * @property int $list ID of the associated list
 * @property int $keep_active Do not stop if the subscriber is removed from the associated list
 * @property int[] $emails IDs of the stored emails content
 * @property int $type The autoresponder type
 * @property int $status The autoresponder status
 * @property string $name The autoresponder name
 * @property string $language
 *
 * @property string $utm_campaign
 * @property string $utm_source
 * @property string $utm_medium
 * @property string $utm_term
 * @property string $utm_content
 */
class TNP_Autoresponder {

    const TYPE_CLASSIC = 0;
    const TYPE_COMPOSER = 1;
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;
}

/**
 * @property int $id The identifier
 * @property int $user_id ID of the associated list
 * @property int $autoresponder_id IDs of the stored emails content
 * @property int $status The step status
 * @property int $send_at Timestamp when to send the step
 * @property int $step The step number to be sent on $send_at
 */
class TNP_Autoresponder_Step {

    const STATUS_RUNNING = 0;
    const STATUS_COMPLETED = 1;
    const STATUS_NO_EMAIL = 2;
    const STATUS_NO_USER = 3;
    const STATUS_NOT_CONFIRMED = 4;
    const STATUS_NOT_IN_LIST = 5;
    const STATUS_STOPPED = 6;
}

class NewsletterAutoresponder extends NewsletterAddon {

    /**
     * @var NewsletterAutoresponder
     */
    static $instance;
    var $store;
    public $autoresponder_table;
    public $autoresponder_steps_table;

    function __construct($version) {
        global $wpdb;

        self::$instance = $this;

        parent::__construct('autoresponder', $version, __DIR__);
        $this->setup_options();

        $this->autoresponder_table = $wpdb->prefix . "newsletter_autoresponder";
        $this->autoresponder_steps_table = $wpdb->prefix . "newsletter_autoresponder_steps";

        add_action('newsletter_user_confirmed', [$this, 'hook_newsletter_user_confirmed']);

        if (is_admin()) {
            require_once __DIR__ . '/admin/admin.php';
            new NewsletterAutoresponderAdmin('autoresponder', $version, __DIR__);
        }
    }

    static function instance() {
        return self::$instance;
    }

    function upgrade($first_install = false) {
        parent::upgrade($first_install);

        global $wpdb, $charset_collate;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta("CREATE TABLE `" . $wpdb->prefix . "newsletter_autoresponder` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(100) NOT NULL DEFAULT '',
            `list` SMALLINT(5) NOT NULL DEFAULT 0,
            `rules` SMALLINT(5) NOT NULL DEFAULT 1,
            `keep_active` SMALLINT(5) NOT NULL DEFAULT 0,
            `language` VARCHAR(5) NOT NULL DEFAULT '',
            `emails` TEXT NOT NULL DEFAULT '',
            `new_lists` TEXT NOT NULL DEFAULT '',
            `status` SMALLINT(5) NOT NULL DEFAULT 0,
            `test` SMALLINT(5) NOT NULL DEFAULT 0,
            `type` SMALLINT(5) NOT NULL DEFAULT 0,
            `restart` SMALLINT(5) NOT NULL DEFAULT 0,
            `regenerate` SMALLINT(5) NOT NULL DEFAULT 0,
            `sender_email` VARCHAR(100) NOT NULL DEFAULT '',
            `sender_name` VARCHAR(100) NOT NULL DEFAULT '',
            `theme` LONGTEXT,
            `utm_campaign` VARCHAR(100) NOT NULL DEFAULT '',
            `utm_source` VARCHAR(100) NOT NULL DEFAULT '',
            `utm_medium` VARCHAR(100) NOT NULL DEFAULT '',
            `utm_term` VARCHAR(100) NOT NULL DEFAULT '',
            `utm_content` VARCHAR(100) NOT NULL DEFAULT '',
            `token` VARCHAR(50) NOT NULL DEFAULT '',
            `align` SMALLINT(5) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)) $charset_collate;");

        dbDelta("CREATE TABLE `" . $wpdb->prefix . "newsletter_autoresponder_steps` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `user_id` int(10) unsigned NOT NULL DEFAULT 0,
            `autoresponder_id` int(10) unsigned NOT NULL DEFAULT 0,
            `step` int(10) unsigned NOT NULL DEFAULT 0,
            `send_at` int(10) unsigned NOT NULL DEFAULT 0,
            `status` smallint(10) unsigned NOT NULL DEFAULT 0,
            UNIQUE KEY `idx` (`user_id`,`autoresponder_id`),
            PRIMARY KEY (`id`)) $charset_collate;");

        $autoresponders = $this->get_autoresponders();
        foreach ($autoresponders as $autoresponder) {
            if (empty($autoresponder->token)) {
                $wpdb->update($wpdb->prefix . 'newsletter_autoresponder', ['token' => wp_generate_password(12, false, false)], ['id' => $autoresponder->id]);
            }
        }
    }

    function init() {

        parent::init();

        // Attach to the newsletter engine schduler since we need to keep the correct emailing rate
        add_action('newsletter', [$this, 'hook_newsletter'], 2);

        // Event triggered periodically (see admin.php) to start the alignment process.
        add_action('newsletter_autoresponder_align', [$this, 'hook_newsletter_autoresponder_align']);
    }

    function weekly_check() {
        parent::weekly_check();
        $license_key = Newsletter::instance()->get_license_key();
        $response = wp_remote_post('https://www.thenewsletterplugin.com/wp-content/addon-check.php?k=' . rawurlencode($license_key)
                . '&a=' . rawurlencode($this->name) . '&d=' . rawurlencode(home_url()) . '&v=' . rawurlencode($this->version)
                . '&ml=' . (Newsletter::instance()->is_multilanguage() ? '1' : '0'));
    }

    function deactivate() {
        parent::deactivate();
        delete_transient('newsletter_autoresponder_run');
        wp_unschedule_hook('newsletter_autoresponder_align');
    }

    function add($user, $autoresponders) {
        $logger = $this->get_logger();
        $logger->debug('Processing user: ' . $user->id);
        if (is_scalar($autoresponders)) {
            $autoresponders = [$autoresponders];
        }

        foreach ($autoresponders as $id) {
            $logger->debug('Processing autoresponder: ' . $id);
        }
    }

    /**
     *
     * @param TNP_Autoresponder_Step $step
     * @return TNP_Autoresponder_Step
     */
    function save_step($step) {
        global $wpdb;
        $store = $this->get_store();
        $res = $store->save($wpdb->prefix . 'newsletter_autoresponder_steps', $step);
        if ($res === false) {
            $this->get_logger()->fatal($wpdb->last_error);
            update_option('newsletter_autoresponder_error', 'Database error: ' . $wpdb->last_error, false);
        }
        return $res;
    }

    /**
     *
     * @global wpdb $wpdb
     * @param int $user_id
     * @param int $autoresponder_id
     * @return TNP_Autoresponder_Step
     */
    function get_step($user_id, $autoresponder_id) {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM $this->autoresponder_steps_table WHERE user_id=%d AND autoresponder_id=%d",
                $user_id, $autoresponder_id
        );

        return $wpdb->get_row($query);
    }

    function set_step_status($step_id, $status) {
        global $wpdb;
        $res = $wpdb->update($wpdb->prefix . 'newsletter_autoresponder_steps', array('status' => $status), array('id' => $step_id));
        if ($res === false) {
            $this->get_logger()->fatal($wpdb->last_error);
            update_option('newsletter_autoresponder_error', 'Database error: ' . $wpdb->last_error, false);
        }
        return $res;
    }

    /**
     * Step could be read from database, but for performance is provided since
     * it is already available on call.
     *
     * @param TNP_User $user
     * @param TNP_Autoresponder $autoresponder
     * @param TNP_Autoresponder_Step $step
     * @return TNP_Autoresponder_Step
     */
    function send($user, $autoresponder, $step) {
        $logger = $this->get_logger();
        $error = get_option('newsletter_autoresponder_error');
        if ($error) {
            $logger->fatal('Blocked by a previous fatal error');
        }
        $newsletter = Newsletter::instance();

        $logger->debug('Getting email ' . $autoresponder->emails[$step->step]);

        $email = $newsletter->get_email($autoresponder->emails[$step->step]);

        if (!$email) {
            $logger->debug('Missing email, considering the series ended');
            $this->set_step_status($step->id, TNP_Autoresponder_Step::STATUS_COMPLETED);
            return;
        }

        $email->track = 1;

        if ($autoresponder->type == TNP_Autoresponder::TYPE_CLASSIC) {
            $email->message = $this->apply_template($email->message, $autoresponder);
        } else {
            if ($autoresponder->regenerate) {
// A possible bug set the email subject to an empty string
                $subject = $email->subject;
                NewsletterEmails::instance()->regenerate($email, ['type' => 'autoresponder']);
                $email->subject = $subject;
                $logger->debug('Email regenerated');
            }
        }

        if ($autoresponder->test) {
            $email->subject = '[Test Mode] ' . $email->subject;
        }

        // TODO: Set the sender name and email
        if ($autoresponder->sender_name) {
            $email->options['sender_name'] = $autoresponder->sender_name;
        }

        if ($autoresponder->sender_email) {
            $email->options['sender_email'] = $autoresponder->sender_email;
        }

        $result = Newsletter::instance()->send($email, [$user], $autoresponder->test);

        // Now the subscriber is moved to the next step
        $step->step++;

        // Are there more emails to send?
        if (!isset($autoresponder->emails[$step->step])) {
            $logger->debug('No other emails, set to completed.');
            $this->set_step_status($step->id, TNP_Autoresponder_Step::STATUS_COMPLETED);

            // Should the subscriber added to specific lists on completion?
            if (!empty($autoresponder->new_lists)) {
                $logger->debug('Setting new list on completion');
                $data = ['id' => $user->id];
                foreach ($autoresponder->new_lists as $list_id) {
                    $data['list_' . $list_id] = 1;
                }
                $newsletter->save_user($data);
            }
            return;
        }

        // Next email
        $next_email = $newsletter->get_email($autoresponder->emails[$step->step]);
        if (empty($next_email)) {
            // Should never happen, but you know...
            $logger->error('Email not found');
            $this->set_step_status($step->id, TNP_Autoresponder_Step::STATUS_NO_EMAIL);
            return;
        }

        if (!isset($next_email->options['delay'])) {
            $logger->error('Missing delay set to 0 hours');
            $next_email->options['delay'] = 24;
        }

        $step->send_at = (int) (time() + $next_email->options['delay'] * 3600);
        $logger->debug('Next step updated:');
        $logger->debug($step);
        return $this->save_step($step);
    }

    function delete_step($user, $autoresponder) {
        global $wpdb;
        $logger = $this->get_logger();
        $logger->debug('Deleting status for user ' . $user->id . ' and autoresponder ' . $autoresponder->id);
        return $wpdb->query($wpdb->prepare("delete from {$wpdb->prefix}newsletter_autoresponder_steps where autoresponder_id=%d and user_id=%d limit 1", $autoresponder->id, $user->id));
    }

    /**
     * Creates a new step for the subscriber deleting the previous step if present.
     *
     * @global wpdb $wpdb
     * @param type $user
     * @param type $autoresponder
     * @return boolean
     */
    function create_step($user, $autoresponder) {
        global $wpdb;
        $logger = $this->get_logger();
        $logger->debug('Creating step for user ' . $user->id . ' and autoresponder ' . $autoresponder->id);

// Extract the first email
        if (empty($autoresponder->emails)) {
            $logger->debug('No emails in this autoresponder. Stop.');
            return false;
        }

        $newsletter = Newsletter::instance();

        $email = $newsletter->get_email($autoresponder->emails[0]);
        if (empty($email)) {
            $logger->error('First email in autoresponder ' . $autoresponder->id . ' not found! Stop.');
            return false;
        }

        $this->delete_step($user, $autoresponder);

        $step = [];
        $delay = (float) $email->options['delay'];
        $step['send_at'] = (int) (time() + $delay * 3600);
        $step['user_id'] = $user->id;
        $step['autoresponder_id'] = $autoresponder->id;
        $step['step'] = 0;
        $store = $this->get_store();
        $step = $store->save($wpdb->prefix . 'newsletter_autoresponder_steps', $step);

        return $step;
    }

    /**
     * Intercept the subscriber confirmation, attach it to series when the rules match, send the
     * first emails if the daly iz zero.
     *
     * @global wpdb $wpdb
     * @param TNP_User $user
     */
    function hook_newsletter_user_confirmed($user) {
        global $wpdb;

        @set_time_limit(0);
        @ignore_user_abort(true);

        $newsletter = Newsletter::instance();
        $store = $this->get_store();
        $logger = $this->get_logger();
        $logger->debug('Subscriber confirmed, checking if needs to be linked to an autoreponder...');
        $logger->debug($this->user_to_string($user));

        // Check if there are specific autoresponders to be activated
        $ids = wp_parse_list($newsletter->get_user_meta($user->id, 'autoresponders'));
        $newsletter->delete_user_meta($user->id, 'autoresponders');

        $logger->debug('Processing requested autoresponders');
        $logger->debug($ids);
        foreach ($ids as $id) {
            $autoresponder = $this->get_autoresponder($id);

            if (!$autoresponder) {
                $logger->debug('Autoresponder not found: ' . $id);
                continue;
            }

//            $language = $autoresponder->language;
//            if ($user->language !== $language) {
//                $logger->debug('Subscriber language not matching. Stop.');
//                continue;
//            }

            $logger->debug('Adding to autoresponder: ' . $id);
            $step = $this->get_step($user->id, $autoresponder->id);
            if ($step) {
                if ($step->status == TNP_Autoresponder_Step::STATUS_RUNNING) {
                    $logger->debug('Autoresponder already active on this subscriber');
                    continue;
                }

                if (empty($autoresponder->restart)) {
                    $logger->debug('Autoresponder not restartable');
                    continue;
                }
            }
            $step = $this->create_step($user, $autoresponder);
            if ($step->send_at > time()) {
                $logger->debug('First email has a delay, no need to send it right now');
                continue;
            }

            $logger->debug('Created step must be processed immediately');

            $this->send($user, $autoresponder, $step);
        }


        // Autoresponders by rules

        $logger->debug('Processing rules');
        $autoresponders = $this->get_autoresponders();

        foreach ($autoresponders as $autoresponder) {
            $logger->debug('Processing autoresponder ' . $autoresponder->id . '...');

            if (empty($autoresponder->status)) {
                $logger->debug('Autoresponder not enabled. Stop.');
                continue;
            }

            if (empty($autoresponder->rules)) {
                $logger->debug('Autoresponder rules not enabled. Stop.');
                continue;
            }

            $step = $this->get_step($user->id, $autoresponder->id);

            // If a step exists, decide if we can create a new one or not. Many different logics can be
            // implemented and no one will satisfy every customer.
            if ($step) {
                if ($step->status == TNP_Autoresponder_Step::STATUS_RUNNING) {
                    $logger->debug('Autoresponder already active on this subscriber');
                    continue;
                }

                if (empty($autoresponder->restart)) {
                    $logger->debug('Autoresponder not restartable');
                    continue;
                }
            }

            $list = (int) $autoresponder->list;
            $language = $autoresponder->language;

            $logger->debug('Required list number: ' . $list);
            $logger->debug('Required language: ' . $language);

            // If the autorespoder has a list set, the subscriber must be in it
            if (!empty($list)) {
                $field = 'list_' . $list;
                if ($user->$field != 1) {
                    $logger->debug('Subscriber not in the required list. Stop.');
                    continue;
                }
            }

            if ($language && $user->language !== $language) {
                $logger->debug('Subscriber language not matching. Stop.');
                continue;
            }

            $step = $this->create_step($user, $autoresponder);

            if (!$step) {
                continue;
            }

            if ($step->send_at > time()) {
                $logger->debug('First email has a delay, no need to send it right now');
                continue;
            }

            $logger->debug('Created step must be processed immediately');

            $this->send($user, $autoresponder, $step);
        }
    }

    /**
     * Periodic (hourly) alignment of subscribers with ALL autoresponder. Activated as scheduled
     * job by the admin.
     */
    function hook_newsletter_autoresponder_align() {

        $logger = $this->get_logger();

        $logger->debug('Hourly alignment start');

        $autoresponders = $this->get_autoresponders();

        foreach ($autoresponders as $autoresponder) {
            $this->align($autoresponder);
        }

        $logger->debug('Hourly alignment end');
    }

    /**
     *
     * @global wpdb $wpdb
     * @param TNP_Autoresponder $autoresponder
     * @return
     */
    function align($autoresponder, $force = false) {
        global $wpdb;
        $logger = $this->get_logger();

        $logger->debug('Alignment start');

        if (empty($autoresponder->status)) {
            $logger->debug('Not enabled. Stop.');
            return new WP_Error('1', 'Series not enabled');
        }

        if (!$force && empty($autoresponder->align)) {
            $logger->debug('Auto align not enabled. Stop.');
            return;
        }

        if (empty($autoresponder->rules)) {
            $logger->debug('Autoresponder without rules, stop.');
            return new WP_Error('1', 'Series with no rules');
        }

        if (empty($autoresponder->emails)) {
            $logger->error('Autoresponder without emails, stop.');
            return;
        }

        $list = (int) $autoresponder->list;

//        if (empty($list)) {
//            $logger->debug('Autoresponder without list, stop.');
//            return;
//        }

        $logger->debug('Language: ' . $autoresponder->language);

        $query = "select count(*) from " . NEWSLETTER_USERS_TABLE . " u left join "
                . $wpdb->prefix . "newsletter_autoresponder_steps s on u.id=s.user_id and autoresponder_id=%d "
                . " where u.status='C' and s.user_id is null";

        $params = [$autoresponder->id];

        if ($autoresponder->language) {
            $query .= " and u.language=%s ";
            $params[] = $autoresponder->language;
        }

        if ($list) {
            $query .= " and u.list_$list=1";
        }

        $query .= " limit 1";

        $logger->debug($query);

        $count = $wpdb->get_var($wpdb->prepare($query, $params));

        $logger->debug($count);

        if ($count === false) {
            $logger->error($wpdb->last_error);
            return new WP_Error('1', $wpdb->last_error);
        }

        if (!$count) {
            $logger->debug('No subscriber to align');
            return 0;
        }

        $logger->debug($count . ' subscribers to align');

        // Get the first email to compute the first delay
        $email = Newsletter::instance()->get_email($autoresponder->emails[0]);

        if (!$email) {
            $logger->error('First email ' . $autoresponder->emails[0] . ' not found during alignment');
            return;
        }
        $send_at = time() + $email->options['delay'] * 3600;

        $query = "insert ignore into " . $wpdb->prefix . "newsletter_autoresponder_steps (autoresponder_id, user_id, send_at) "
                . "(select " . $autoresponder->id . ", u.id, " . $send_at . " from " . $wpdb->prefix . "newsletter u left join "
                . $wpdb->prefix . "newsletter_autoresponder_steps s on u.id=s.user_id and autoresponder_id=%d "
                . "where s.user_id is null and u.status='C'";

        $params = [$autoresponder->id];

        if ($autoresponder->language) {
            $query .= " and u.language=%s ";
            $params[] = $autoresponder->language;
        }

        if ($list) {
            $query .= " and u.list_$list=1";
        }

        $query .= ')';

        $logger->debug($query);

        $r = $wpdb->query($wpdb->prepare($query, $params));
        if ($r === false) {
            $logger->error($wpdb->last_error);
            $logger->error($query);
            return new WP_Error('1', $wpdb->last_error);
        }

        return $r;
    }

    function hook_newsletter($force = false, $autoresponder = null) {
        global $wpdb;

        set_time_limit(0);
        ignore_user_abort(true);

        $newsletter = Newsletter::instance();
        $logger = $this->get_logger();
        $store = $this->get_store();

        $logger->debug('Engine start');

        if (!$autoresponder) {
            $autoresponders = $this->get_autoresponders();
        } else {
            $logger->debug('Request the specific autoresponder ' . $autoresponder->id);
            $autoresponders = [$autoresponder];
        }

        foreach ($autoresponders as $autoresponder) {

            $logger->debug('Processing autoresponder ' . $autoresponder->id);

            if (empty($autoresponder->status)) {
                $logger->debug('Not enabled. Stop.');
                continue;
            }

            if ($autoresponder->test) {
                $logger->debug('Test mode active! Manually run only.');
                if (!$force)
                    continue;
            }

            if (empty($autoresponder->emails)) {
                $logger->debug('No emails configured. Stop.');
                continue;
            }

            $list = (int) $autoresponder->list;

            $emails = $autoresponder->emails;

            //$this->align($autoresponder);
// Extract all the pending steps
            if ($autoresponder->test) {
                $steps = $wpdb->get_results("select * from " . $wpdb->prefix . "newsletter_autoresponder_steps where status=0 and autoresponder_id=" . $autoresponder->id . " order by send_at asc");
            } else {
                $max_emails = $newsletter->get_emails_per_run();
                $logger->debug('Max allowed emails for this run by your capacity is ' . $max_emails);
                $steps = $wpdb->get_results("select * from " . $wpdb->prefix . "newsletter_autoresponder_steps where status=0 and autoresponder_id=" . $autoresponder->id . " and send_at<" . time() . " order by send_at asc limit " . $max_emails);
            }

            if (empty($steps)) {
                $logger->info('No planned steps found. Stop.');
                continue;
            }

            $logger->info(count($steps) . ' found to be processed');

            foreach ($steps as $step) {
                $logger->debug('Processing step ' . $step->id . ' of user ' . $step->user_id);

                $user = $newsletter->get_user($step->user_id);
                if (!$user) {
                    $logger->error('User not found, add block');
                    $this->set_step_status($step->id, TNP_Autoresponder_Step::STATUS_NO_USER);
                    continue;
                }

                if ($user->status !== TNP_User::STATUS_CONFIRMED) {
                    $logger->error('Subscriber not confirmed, add block');
                    $this->set_step_status($step->id, TNP_Autoresponder_Step::STATUS_NOT_CONFIRMED);
                    continue;
                }

                if (!empty($list) && empty($autoresponder->keep_active)) {
                    $field = 'list_' . $list;
                    if ($user->$field != 1) {
                        $logger->error('User no more in this list, add block');
                        $this->set_step_status($step->id, TNP_Autoresponder_Step::STATUS_NOT_IN_LIST);
                        continue;
                    }
                }

                $result = $this->send($user, $autoresponder, $step);

                if (!$autoresponder->test && $result === false) {
                    $logger->info('Email capacity exeeded');
                    $logger->info('Engine end');
                    return;
                }
            }
        }

        $logger->info('Engine end');
    }

    /**
     *
     * @param TNP_User $user
     */
    public function user_to_string($user) {
        $b = $user->id . ' - ' . $user->status . ' - ' . $user->email . "\n";
        $b .= 'Lists: ';
        for ($i = 1;
                $i <= NEWSLETTER_LIST_MAX;
                $i++) {
            $field = 'list_' . $i;
            if ($user->$field) {
                $b .= $i . ' ';
            }
        }
        return $b;
    }

    function check_transient($name, $time) {
//usleep(rand(0, 1000000));
        if (($value = get_transient($this->prefix . '_' . $name)) !== false) {
            return false;
        }
        set_transient($this->prefix . '_' . $name, time(), $time);
        return true;
    }

    function delete_transient($name = '') {
        delete_transient($this->prefix . '_' . $name);
    }

    /**
     *
     * @global wpdb $wpdb
     * @param int $id
     * @return TNP_Autoresponder
     */
    function get_autoresponder($id) {
        global $wpdb;
        $store = $this->get_store();
        $autoresponder = $store->get_single($wpdb->prefix . 'newsletter_autoresponder', $id);
        if ($autoresponder) {
            $this->deserialize_autoresponder($autoresponder);
        }
        return $autoresponder;
    }

    function get_autoresponder_key($id) {
        global $wpdb;
        $store = $this->get_store();
        $autoresponder = $store->get_single($wpdb->prefix . 'newsletter_autoresponder', $id);
        if (!$autoresponder) {
            return false;
        }
        return $autoresponder->id . '-' . $autoresponder->token;
    }

    function is_valid_key($key) {
        list($id, $token) = explode('-', $key, 2);
        if (empty($token) || empty($id)) {
            return false;
        }
        $autoresponder = $this->get_autoresponder($id);
        if (!$autoresponder) {
            return false;
        }
        if (empty($autoresponder->token)) {
            return false;
        }
        if ($autoresponder->token !== $token) {
            return false;
        }
        return true;
    }

    /**
     *
     * @param TNP_Autoresponder $autoresponder
     * @return TNP_Autoresponder (itself)
     */
    function deserialize_autoresponder($autoresponder) {
        $autoresponder->emails = wp_parse_id_list($autoresponder->emails);

        $autoresponder->new_lists = wp_parse_id_list($autoresponder->new_lists);

        if (empty($autoresponder->theme)) {
            $autoresponder->theme = [];
        } else {
            $autoresponder->theme = json_decode($autoresponder->theme, true);
        }

        if (empty($autoresponder->theme['theme'])) {
            $autoresponder->theme['theme'] = 'default';
        }

        $autoresponder->list = (int) $autoresponder->list;

        return $autoresponder;
    }

    /**
     *
     * @global wpdb $wpdb
     * @return TNP_Autoresponder[]
     */
    function get_autoresponders() {
        global $wpdb;
        $autoresponders = $wpdb->get_results("select * from " . $wpdb->prefix . "newsletter_autoresponder order by id");
        foreach ($autoresponders as $autoresponder) {
            $this->deserialize_autoresponder($autoresponder);
        }
        return $autoresponders;
    }

    /**
     *
     * @return NewsletterStore
     */
    function get_store() {
        if ($this->store) {
            return $this->store;
        }
        $this->store = new NewsletterStore('autoresponder');
        return $this->store;
    }

    function apply_template($body, $autoresponder) {
        ob_start();

        $theme_options = $autoresponder->theme;
        $theme = $this->get_theme($theme_options['theme']);
        if (empty($theme)) {
            $theme = $this->get_theme('default');
        }

        $theme_defaults_file = $theme['dir'] . '/theme-defaults.php';
        if (file_exists($theme_defaults_file)) {
            @include $theme_defaults_file;
            if (is_array($theme_defaults)) {
                $theme_options = array_merge($theme_defaults, $theme_options);
            }
        }

        include $theme['dir'] . '/theme.php';

        $theme = ob_get_clean();
        if (strpos($theme, '{message}') !== false) {
            $body = str_replace('{message}', $body, $theme);
        }
        return Newsletter::instance()->inline_css($body);
    }

    /**
     * Returns all the available themes. The list is a set of arrays with keys:
     *
     * dir - the path to the theme
     * name - the theme name
     *
     */
    function get_themes() {
        static $list = [];

// Caching
        if (!empty($list)) {
            return $list;
        }

        $logger = $this->get_logger();
        $dirs = [];
        $dirs[] = __DIR__ . '/themes/default';
        $dirs[] = __DIR__ . '/themes/html';

        $extra = apply_filters('newsletter_autoresponder_themes', []);

        $dirs = array_merge($dirs, $extra);

// [TODO] On windows it may not work
        foreach ($dirs as $dir) {
            $dir = wp_normalize_path($dir);
            if (!file_exists($dir . '/theme.php')) {
                continue;
            }

            $id = basename($dir);
            if (isset($list[$id])) {
                $logger->error('Theme in ' . $dir . ' folder already registered');
                continue;
            }

            $data = get_file_data($dir . '/theme.php', array('name' => 'Name', 'preview' => 'Preview'));

// Should never happen
            if (!$data) {

            }

            $data['id'] = $id;
            $data['dir'] = $dir;

            if (empty($data['name'])) {
                $data['name'] = $id;
            }

            if (!isset($data['preview']))
                $data['preview'] = true;
            else
                $data['preview'] = $data['preview'] !== 'false';

            $list[$id] = $data;
        }

        return $list;
    }

    function get_theme($id) {
        if (empty($id)) {
            $id = 'default';
        }
        $themes = $this->get_themes();
        if (isset($themes[$id])) {
            return $themes[$id];
        }
        return null;
    }
}
