<?php
/* @var $this NewsletterAutomated */

global $wpdb;
require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';

$newsletter_emails = NewsletterEmails::instance();
$controls = new NewsletterControls();

$channel_id = (int) $_GET['id'];
$channel = $this->get_channel($channel_id);
if (!$channel) {
    echo 'Channel not found';
    return;
}

$email = Newsletter::instance()->get_email($channel->email_id);
if (!$email) {
    echo 'The email model with id ', esc_html($channel->email_id), ' cannot be found';
    return;
}

if (!$controls->is_action()) {
    NewsletterEmails::instance()->regenerate($email, array('type' => 'automated', 'last_run' => 0));
    $email->subject = $channel->data['subject'];
    TNP_Composer::prepare_controls($controls, $email);
} else {

    if ($controls->is_action('save') || $controls->is_action('configure')) {

        TNP_Composer::update_email($email, $controls);
        $email = NewsletterEmails::instance()->save_email($email);

        $channel->data['subject'] = $email->subject;

        $wpdb->update($wpdb->prefix . "newsletter_automated", array('data' => json_encode($channel->data)), array('id' => $channel_id));

        // Old code kept for compatibility
        $wpdb->update($wpdb->prefix . "newsletter_automated", array('theme' => $email->message), array('id' => $channel_id));

        TNP_Composer::prepare_controls($controls, $email);
        $controls->add_toast_saved();
    }

    if ($controls->is_action('configure')) {
        $controls->js_redirect('?page=newsletter_automated_index&id=' . urlencode($channel->id));
    }

    if ($controls->is_action('test')) {
        TNP_Composer::update_email($email, $controls);
        $this->send_test_email($email, $controls);
        TNP_Composer::prepare_controls($controls, $email);
    }

    if ($controls->is_action('send-test-to-email-address')) {
        TNP_Composer::update_email($email, $controls);
        $custom_email = sanitize_email($_POST['test_address_email']);
        if (!empty($custom_email)) {
            try {
                $message = NewsletterEmailsAdmin::instance()->send_test_newsletter_to_email_address($email, $custom_email);
                $controls->messages .= $message;
            } catch (Exception $e) {
                $controls->errors = __('Newsletter should be saved before send a test', 'newsletter');
            }
        } else {
            $controls->errors = __('Empty email address', 'newsletter');
        }
        TNP_Composer::prepare_controls($controls, $email);
    }
}
?>
<div class="wrap" id="tnp-wrap">
    <?php include NEWSLETTER_ADMIN_HEADER; ?>
    <div id="tnp-heading">

        <h2><?php echo esc_html($channel->data['name']) ?></h2>
        <?php include __DIR__ . '/nav.php' ?>

    </div>

    <div id="tnp-body" class="tnp-automated-edit">


        <?php $controls->show(); ?>

        <div class="tnp-automated-edit">

            <form method="post" id="tnpc-form" action="" onsubmit="tnpc_save(this); return true;">
                <?php $controls->init(); ?>

                <p>
                    <?php $controls->button_save() ?>
                </p>
                <?php $controls->composer_fields_v2() ?>

            </form>
            <?php $controls->composer_load_v2(true, true, 'automated') ?>

        </div>

    </div>
</div>
