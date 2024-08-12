<?php
/* @var $this NewsletterAutoresponderAdmin */
/* @var $wpdb wpdb */

global $wpdb;

$autoresponder = $this->get_autoresponder((int) $_GET['id']);
$logger = $this->get_logger();
$newsletter = Newsletter::instance();

$debug = isset($_GET['debug']) || NEWSLETTER_DEBUG;

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();

if (!$controls->is_action()) {
    $controls->set_data($autoresponder);
} else {

    if ($controls->is_action('save')) {
        $controls->data['id'] = $autoresponder->id;
        $autoresponder = $this->save_autoresponder($controls->data);
        $logger->info('Test mode set to ' . $controls->data['test'] . ' on autoresponder ' . $autoresponder->id);
        $controls->add_toast_saved();
    }

    if ($controls->is_action('align')) {

        $r = NewsletterAutoresponder::instance()->align($autoresponder, true);
        if (is_wp_error($r)) {
            $controls->errors = 'Error: ' . esc_html($r->get_error_message());
        } else {
            $controls->add_message(esc_html($r) . ' subscriber processed');
        }
    }

    if ($controls->is_action('reset')) {
        $logger->info('Reset called for autoresponder ' . $autoresponder->id);

        //$controls->data['id'] = $autoresponder->id;
        //$autoresponder = $this->save_autoresponder($controls->data);
        //$controls->set_data($autoresponder);

        if (empty($autoresponder->rules) || !$autoresponder->list) {
            $controls->warnings[] = 'Reset supported only for series associated to a list';
        } else {
            $this->query($wpdb->prepare("delete from {$wpdb->prefix}newsletter_autoresponder_steps where autoresponder_id=%d", $autoresponder->id));
            NewsletterAutoresponder::instance()->align($autoresponder);

            $controls->add_message_reset();
        }
    }

    if ($controls->is_action('run')) {
        if (empty($autoresponder->status)) {
            $controls->warnings[] = 'Autoresponder not enabled';
        } else {
            NewsletterAutoresponder::instance()->hook_newsletter(true, $autoresponder);
            $controls->add_toast_done();
        }
    }

    if ($controls->is_action('convert')) {
        $logger->info('Conversion triggered');
        foreach ($autoresponder->emails as $email_id) {
            $email = $newsletter->get_email($email_id);
            ob_start();
            NewsletterEmails::instance()->render_block('header', true);
            NewsletterEmails::instance()->render_block('text', true, ['html' => $email->message]);
            NewsletterEmails::instance()->render_block('footer', true);
            $body = ob_get_clean();
            $email->message = TNP_Composer::get_html_open($email) . TNP_Composer::get_main_wrapper_open($email) .
                    $body . TNP_Composer::get_main_wrapper_close($email) . TNP_Composer::get_html_close($email);
            $newsletter->save_email($email);
            $logger->info($email);
            $autoresponder->type = TNP_Autoresponder::TYPE_COMPOSER;
            $autoresponder->status = TNP_Autoresponder::STATUS_DISABLED;
            $this->save_autoresponder($autoresponder);
            //break;
        }
        $controls->add_toast_done();
    }

    if ($controls->is_action('reactivate')) {
        $this->move_subscribers_with_completed_status_to_new_step($autoresponder);
        $controls->add_toast_done();
    }
}
?>

<div class="wrap" id="tnp-wrap">

    <?php include NEWSLETTER_ADMIN_HEADER; ?>

    <div id="tnp-heading">
        <?php include __DIR__ . '/nav.php' ?>
    </div>

    <div id="tnp-body">

        <?php $controls->show(); ?>

        <form method="post" action="">
            <?php $controls->init(); ?>

            <table class="form-table">

                

                <tr>
                    <th>Reactivate subscribers</th>
                    <td>
                        <?php $c = $this->get_early_completed_count($autoresponder); ?>
                        <?php if ($c) { ?>
                            <?php $controls->button('reactivate', __('Reactivate', 'newsletter-autoresponder')); ?>
                            <br><br>
                            There are <?php echo esc_html($c); ?> subscribers that completed the series BEFORE more steps have been added. <br>
                            <a href="https://www.thenewsletterplugin.com/documentation/addons/extended-features/autoresponder-extension/#completed">Please read carefully about possible drawbacks.</a>
                        <?php } else { ?>
                            Nothing to do.
                        <?php } ?>
                    </td>
                </tr>

                <tr>
                    <th>Run</th>
                    <td>
                        <?php $controls->button_primary('run', __('Run', 'newsletter')) ?>
                        <p class="description">
                            Force the processing of pending emails in this series. <a href="https://www.thenewsletterplugin.com/documentation/addons/extended-features/autoresponder-extension/#trigger" target="_blank">Read more</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th>Reset and restart</th>
                    <td>
                        <?php $controls->btn('reset', 'Go', ['confirm' => true]); ?>
                        <p class="description">
                            Every subsceriber is <strong>removed</strong>, its status relative to this series <strong>cleaned up</strong> and the linked list
                            subscribers readded to the first step of the series.
                        </p>
                    </td>
                </tr>
                <?php if ($autoresponder->type == TNP_Autoresponder::TYPE_CLASSIC) { ?>
                    <tr>
                        <th>Convert to the new format</th>
                        <td>
                            <?php $controls->btn('convert', 'Convert to composer', ['confirm' => true]); ?>
                            <p class="description">
                                Converts this email series to the new version (editable with the composer).<br>
                                Remember to re-enable it after conversion.<br>
                                Only the body part is kept!<br>
                                PLEASE, save a copy of the original messages before proceed!
                            </p>
                        </td>
                    </tr>
                <?php } ?>

                <tr>
                    <th>Test mode</th>
                    <td>
                        <?php $controls->yesno('test') ?>

                        <p class="description">
                            <strong>PLEASE USE WITH CARE!</strong><br>
                            In test mode messages are sent only if you force an engine run
                            (see below the ↻ button). Each run moves the subscribers a step forward sending them
                            the message.
                        </p>
                    </td>
                </tr>
            </table>

            <p>
                <?php $controls->button_save(); ?>
            </p>

        </form>

    </div>

</div>
