<?php
/* @var $this NewsletterAutoresponderAdmin */
/* @var $logger NewsletterLogger */
/* @var $wpdb wpdb */

global $wpdb;
require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();
$logger = $this->get_logger();

$autoresponder = $this->get_autoresponder((int) $_GET['id']);
if (!$autoresponder) {
    die('Autoresponder not found.');
}

$statistics = NewsletterStatistics::instance();

$debug = isset($_GET['debug']) || NEWSLETTER_DEBUG;

if ($autoresponder->type == TNP_Autoresponder::TYPE_COMPOSER) {
    $email_edit_url = 'newsletter_autoresponder_composer';
} else {
    $email_edit_url = 'newsletter_autoresponder_email';
}


if (!$controls->is_action()) {
    $controls->set_data($autoresponder);
} else {


    if ($controls->is_action('add')) {
        $email = array('type' => 'autoresponder_' . $autoresponder->id, 'subject' => '[no subject]', 'track' => 1, 'status' => 'sent', 'editor' => NewsletterEmails::EDITOR_COMPOSER, 'options' => ['delay' => 24]);
        $email = Newsletter::instance()->save_email($email);
        $autoresponder->emails[] = $email->id;
        $autoresponder = $this->save_autoresponder($autoresponder);
        $controls->set_data($autoresponder);
        $controls->js_redirect('?page=' . $email_edit_url . '&id=' . $autoresponder->id . '&email_id=' . $email->id);
        die();
    }

    if ($controls->is_action('copy')) {
        $i = (int) $_POST['btn'];
        $email = Newsletter::instance()->get_email($autoresponder->emails[$i], ARRAY_A);
        unset($email['id']);
        $email['subject'] .= ' (copy)';
        $email = Newsletter::instance()->save_email($email);
        $autoresponder->emails[] = $email->id;
        $this->save_autoresponder($autoresponder);
    }

    //Move up email
    if ($controls->is_action('up')) {
        $i = (int) $_POST['btn'];
        $emails = $autoresponder->emails;

        $tmp = $emails[$i];
        $emails[$i] = $emails[$i - 1];
        $emails[$i - 1] = $tmp;

        $autoresponder->emails = $emails;
        $autoresponder = $this->save_autoresponder($autoresponder);
        $controls->data = (array) $autoresponder;
    }

    //Move down email
    if ($controls->is_action('down')) {
        $i = (int) $_POST['btn'];
        $emails = $autoresponder->emails;

        $tmp = $emails[$i + 1];
        $emails[$i + 1] = $emails[$i];
        $emails[$i] = $tmp;

        $autoresponder->emails = $emails;
        $autoresponder = $this->save_autoresponder($autoresponder);
        $controls->set_data($autoresponder);
    }

    if ($controls->is_action('delete')) {
        $i = (int) $_POST['btn'];
        $emails = $autoresponder->emails;
        Newsletter::instance()->delete_email($emails[$i]);
        unset($emails[$i]);
        $autoresponder->emails = $emails;
        $autoresponder = $this->save_autoresponder($autoresponder);
        $controls->set_data($autoresponder);
        $controls->add_message_deleted();
    }

    if ($controls->is_action('reset')) {
        $logger->info('Reset called for autoresponder ' . $autoresponder->id);

        $controls->data['id'] = $autoresponder->id;
        $autoresponder = $this->save_autoresponder($controls->data);
        $controls->set_data($autoresponder);

        if (!$autoresponder->list) {
            $controls->errors = 'No list assigned.';
        } else {
            if ($autoresponder->emails) {
                // Get the first email to compute the first delay
                $email = Newsletter::instance()->get_email($autoresponder->emails[0]);
                $send_at = time() + $email->options['delay'] * 3600;
            } else {
                $send_at = time();
            }
            $list = (int) $autoresponder->list;
            $this->query($wpdb->prepare("delete from {$wpdb->prefix}newsletter_autoresponder_steps where autoresponder_id=%d", $autoresponder->id));

            $wpdb->query("insert ignore into " . $wpdb->prefix . "newsletter_autoresponder_steps (autoresponder_id, user_id, send_at) (
                    select " . $autoresponder->id . ", u.id, " . $send_at . " from " . $wpdb->prefix . "newsletter u left join " . $wpdb->prefix . "newsletter_autoresponder_steps s on u.id=s.user_id and autoresponder_id=" .
                    $autoresponder->id . " where s.user_id is null and u.list_" . $list . "=1)");
            $controls->add_message_reset();
        }
    }

    if ($controls->is_action('run')) {
        $this->hook_newsletter(true, $autoresponder);
        $controls->messages .= 'Engine triggered';
    }

    if ($controls->is_action('continue_completed_subscriber')) {

        $this->move_subscribers_with_completed_status_to_new_step($autoresponder);
    }
}


$emails = $autoresponder->emails;

if ($autoresponder->test) {
    $controls->warnings[] = 'Running in test mode!';
}
?>
<div class="wrap" id="tnp-wrap">

    <?php include NEWSLETTER_ADMIN_HEADER ?>
    <div id="tnp-heading">
        <?php include __DIR__ . '/nav.php' ?>
    </div>

    <div id="tnp-body">

        <?php $controls->show(); ?>

        <form method="post" action="">

            <?php $controls->init(); ?>

            <table class="widefat" style="width: 100%">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <?php if ($debug) { ?>
                            <th><code>Email ID</code></th>
                        <?php } ?>
                        <th><?php esc_html_e('Subject', 'newsletter') ?></th>
                        <th>Delay <small>(from previous message)</small></th>
                        <th><?php esc_html_e('Subscribers waiting', 'newsletter') ?></th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    <?php for ($i = 0; $i < count($emails); $i++) { ?>
                        <?php
                        $email_id = $emails[$i];
                        $email = Newsletter::instance()->get_email($email_id);
                        ?>
                        <tr>
                            <td><?php echo $i + 1 ?></td>
                            <?php if ($debug) { ?>
                                <td><code><?php echo $email->id ?></code></td>
                            <?php } ?>
                            <td><?php echo esc_html($email->subject) ?></td>
                            <td><?php echo esc_html($this->format_delay($email->options['delay'])) ?></td>
                            <td>
                                <?php echo $this->get_subscribers_count_waiting_on_step($autoresponder->id, $i) ?>
                                <?php if ($debug) { ?>
                                    <code>(<?php echo $this->get_late_subscribers_count_waiting_on_step($autoresponder->id, $i) ?> late)</code>
                                <?php } ?>
                            </td>
                            <td>
                                <?php
                                if ($i > 0) {
                                    $controls->button_confirm('up', '↑', '', $i);
                                } else {
                                    echo '<span style="margin-left: 34px"></span>';
                                }
                                ?>
                                <?php
                                if ($i < ( count($emails) - 1 )) {
                                    $controls->button_confirm('down', '↓', '', $i);
                                }
                                ?>
                            </td>
                            <td style="white-space: nowrap">
                                <?php $controls->button_icon_edit('?page=' . $email_edit_url . '&id=' . $autoresponder->id . '&email_id=' . $email->id) ?>
                                <?php $controls->button_icon_statistics($statistics->get_statistics_url($autoresponder->emails[$i])) ?>
                            </td>
                            <td style="white-space: nowrap">
                                <?php $controls->button_icon_copy($i); ?>
                                <?php $controls->button_icon_delete($i); ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="tnp-buttons"><?php $controls->button('add', 'New email'); ?></div>

        </form>

    </div>
</div>
