<?php
/* @var $this NewsletterAutoresponderAdmin */
/* @var $wpdb wpdb */
global $wpdb;

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();

$email_id = (int) $_GET['email_id'];
$autoresponder = $this->get_autoresponder((int) $_GET['id']);

if (!$autoresponder) {
    die('Autoresponder not found.');
}

if ($controls->is_action('save') || $controls->is_action('test')) {
    $email = $controls->data;
    $email['id'] = $email_id;
    $email['type'] = 'autoresponder_' . $autoresponder->id;
    $email['track'] = 1;
    $email['options'] = [];
    $email['options']['delay'] = (float) $controls->data['delay'];
    unset($email['delay']);

    Newsletter::instance()->save_email($email);
    $controls->add_message_saved();
    if ($controls->is_action('test')) {
        $email = Newsletter::instance()->get_email($email_id);
        $email->message = $this->apply_template($email->message, $autoresponder);
        $this->send_test_email($email, $controls);
    }
} else {

    $email = Newsletter::instance()->get_email($email_id);

    $controls->data = [];
    $controls->data['message'] = $email->message;
    $controls->data['delay'] = $email->options['delay'];
    $controls->data['subject'] = $email->subject;
}
?>

<div class="wrap" id="tnp-wrap">
    <?php include NEWSLETTER_DIR . '/tnp-header.php' ?>
    <div id="tnp-heading">

        <h2>Message</h2>

        <?php $controls->show(); ?>

    </div>
    <div id="tnp-body">

        <form method="post" action="">
            <?php $controls->init(); ?>
            <p>
                <?php $controls->button_back('?page=newsletter_autoresponder_messages&id=' . $autoresponder->id, '')?>
                <?php $controls->button_save(); ?>
                <?php $controls->button_test('test', 'Test'); ?>
            </p>

            <table class="form-table">
                <tr>
                    <th>Delay (hours)</th>
                    <td><?php $controls->text('delay') ?></td>
                </tr>
            </table>

            <br><br>

            <?php $controls->text('subject', 90) ?>
            <br><br>
            <div style="max-width: 700px">
            <?php $controls->wp_editor('message') ?>
            </div>

            <p>
                <?php $controls->button_back('?page=newsletter_autoresponder_edit&id=' . $autoresponder->id)?>
                <?php $controls->button_save(); ?>
                <?php $controls->button('test', 'Test'); ?>
            </p>


        </form>

    </div>

</div>
