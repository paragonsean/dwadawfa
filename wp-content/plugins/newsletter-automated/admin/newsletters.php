<?php
/* @var $wpdb wpdb */
/* @var $this NewsletterAutomated */

global $wpdb;
require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
require_once NEWSLETTER_INCLUDES_DIR . '/paginator.php';
$controls = new NewsletterControls();

$feed_id = (int) $_GET['id'];
$feed = $this->get_channel($feed_id);
$channel = $feed;

if (!$feed) {
    echo 'Channel not found';
    return;
}
if (!$controls->is_action()) {

} else {


    if ($controls->is_action('delete')) {
        Newsletter::instance()->delete_email($_POST['btn']);
        $controls->add_message_done();
    }

    if ($controls->is_action('abort')) {
        $wpdb->query($wpdb->prepare("update " . $wpdb->prefix . "newsletter_emails set status='new' where id=%d", $_POST['btn']));
        $controls->messages = 'Newsletter definitively blocked';
    }
}

$pagination_controller = new TNP_Pagination_Controller(NEWSLETTER_EMAILS_TABLE, 'id', ['type' => 'automated_' . $feed_id]);

$emails = $pagination_controller->get_items();
?>


<div class="wrap" id="tnp-wrap">
    <?php include NEWSLETTER_ADMIN_HEADER ?>
    <div id="tnp-heading">

        <h2><?php echo esc_html($channel->data['name'])?></h2>
        <?php include __DIR__ . '/nav.php' ?>

    </div>

    <div id="tnp-body" class="tnp-automated-edit">

        <form method="post" action="">
            <?php $controls->init(); ?>

            <?php if (empty($emails)) { ?>
                <p>No newsletters have been generated since now for this channel.</p>
            <?php } else { ?>

                <?php $pagination_controller->display_paginator(); ?>

                <table class="widefat">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th colspan="2">Progress</th>
                            <th>Opens/Clicks</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($emails as $email) { ?>
                            <tr>
                                <td><?php echo $email->id; ?></td>
                                <td>
                                    <?php echo esc_html($email->subject); ?>
                                </td>
                                <td style="white-space: nowrap">
                                    <?php echo NewsletterControls::print_date($email->send_on); ?>
                                </td>
                                <td>
                                    <?php Newsletter::instance()->show_email_status_label($email) ?>
                                </td>

                                <td>
                                    <?php Newsletter::instance()->show_email_progress_bar($email, array('numbers' => false)) ?>
                                </td>
                              <td>
                                    <?php Newsletter::instance()->show_email_progress_numbers($email) ?>
                                </td>
                                <td>
                                        <?php echo NewsletterStatistics::instance()->get_open_count($email->id) ?>/<?php echo NewsletterStatistics::instance()->get_click_count($email->id) ?>
                                </td>
                                <td style="white-space: nowrap">
                                    <?php $controls->button_icon_statistics(NewsletterStatistics::instance()->get_statistics_url($email->id)) ?>
                                    <?php $controls->button_icon_view(home_url('/') . '?na=v&id=' . $email->id) ?>
                                    <?php $controls->button_icon_delete($email->id); ?>
                                    <?php if ($email->status !== TNP_Email::STATUS_SENT) $controls->button_icon('abort', 'fa-stop', 'Block this newsletter', $email->id, true); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>



        </form>

    </div>
</div>
