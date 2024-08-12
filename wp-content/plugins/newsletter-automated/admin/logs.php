<?php
/* @var $wpdb wpdb */
/* @var $this NewsletterAutomated */

global $wpdb;
require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
require_once NEWSLETTER_INCLUDES_DIR . '/paginator.php';
$controls = new NewsletterControls();

$channel_id = (int) $_GET['id'];
$channel = $this->get_channel($channel_id);

if (!$channel) {
    echo 'Channel not found';
    return;
}
if (!$controls->is_action()) {

} else {

}

$pagination_controller = new TNP_Pagination_Controller($wpdb->prefix . 'newsletter_automated_logs', 'id');

$logs = $pagination_controller->get_items();
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

            <?php if (empty($logs)) { ?>
                <p>No logs by now.</p>
            <?php } else { ?>

                <?php $pagination_controller->display_paginator(); ?>

                <table class="widefat">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Date</th>
                            <th>User</th>
                            <th>Message</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $count = 0; ?>
                        <?php foreach ($logs as $log) { ?>
                            <?php $count++;
                            $time = strtotime($log->created);
                            ?>
                            <tr>
                                <td><?php echo esc_html($log->id); ?></td>
                                <td><?php echo esc_html($controls->print_date($time)); ?></td>
                                <td><?php echo esc_html($log->user) ?></td>
                                <td><?php echo esc_html($log->message) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>



        </form>

    </div>

</div>
