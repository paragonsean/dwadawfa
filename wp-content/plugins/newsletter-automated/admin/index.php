<?php
/* @var $this NewsletterAutomated */
/* @var $controls NewsletterControls */
global $wpdb;

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
require_once NEWSLETTER_INCLUDES_DIR . '/paginator.php';

$controls = new NewsletterControls();

if ($controls->is_action('add')) {
    $data = array('name' => 'New channel', 'list' => 1, 'theme' => 'default', 'enabled' => 0, 'hour' => 6, 'max_posts' => 10, 'excerpt_length' => 30, 'track' => 1);
    $feed = array('data' => json_encode($data));
    $wpdb->insert($wpdb->prefix . "newsletter_automated", $feed);
    $id = $wpdb->insert_id;
    $controls->messages = 'New channel created.';
}

if ($controls->is_action('add_composer')) {
    $data = array('name' => 'New channel with composer', 'list' => '', 'enabled' => 0, 'hour' => 6, 'track' => 1);
    $feed = array('data' => json_encode($data), 'theme_type' => $this::THEME_TYPE_COMPOSER);
    $wpdb->insert($wpdb->prefix . "newsletter_automated", $feed);
    $id = $wpdb->insert_id;
    $controls->messages = 'New channel created.';
}

if ($controls->is_action('delete')) {
    /* @var $wpdb wpdb */
    $channel_id = (int) $_POST['btn'];
    $res = $wpdb->query($wpdb->prepare("delete from " . $wpdb->prefix . "newsletter_automated where id=%d limit 1", $channel_id));
    $emails = $this->get_emails($channel_id);
    $newsletter = Newsletter::instance();
    foreach ($emails as $email) {
        $newsletter->delete_email($email->id);
    }

    //Clear scheduled channel hook
    wp_clear_scheduled_hook('newsletter_automated', array($channel_id));

    if ($res === false) {
        $controls->errors = __('Unable to delete.', 'newsletter-automated');
    } else {
        $controls->messages .= __('Channel deleted.', 'newsletter-automated');
    }
}

if ($controls->is_action('copy')) {
    /* @var $wpdb wpdb */
    $res = $wpdb->get_row($wpdb->prepare("select * from " . $wpdb->prefix . "newsletter_automated where id=%d limit 1", $_POST['btn']), ARRAY_A);
    $data = json_decode($res['data'], true);
    $data['enabled'] = 0;
    $data['name'] .= ' (copy)';
    $res['data'] = json_encode($data);
    $newsletter = Newsletter::instance();
    $email = $newsletter->get_email($res['email_id']);
    if ($email) {
        $new_email = (array) $email;
        unset($new_email['id']);
        $new_email = $newsletter->save_email($new_email);
        $res['email_id'] = $new_email->id;
    }
    unset($res['id']);
    $r = $wpdb->insert($wpdb->prefix . "newsletter_automated", $res);
    if (!$r) {
        $controls->errors = 'Saving error: ' . esc_html($wpdb->last_error);
    } else {
        $controls->add_message_done();
    }
}


$pagination_controller = new TNP_Pagination_Controller(
        NEWSLETTER_AUTOMATED_TABLE,
        'id',
        [],
        20,
        [
    'id',
    'email_id',
    'data',
    'theme_type'
        ]);

$channels = $pagination_controller->get_items();

$newsletters_sent_list = $wpdb->get_results("SELECT type, count(*) AS count"
        . " FROM " . NEWSLETTER_EMAILS_TABLE
        . " WHERE type LIKE 'automated_%' GROUP BY type", OBJECT_K);

foreach ($channels as $channel) {
    $channel->data = json_decode($channel->data, true);
    $channel->newsletters_sent = isset($newsletters_sent_list["automated_$channel->id"]) ? (int) $newsletters_sent_list["automated_$channel->id"]->count : 0;
}
?>

<div class="wrap" id="tnp-wrap">
    <?php include NEWSLETTER_ADMIN_HEADER ?>
    <div id="tnp-heading">
        <?php $controls->title_help('/addons/extended-features/automated-extension/') ?>
        <h2>Automated Newsletters</h2>
    </div>
    <div id="tnp-body">
        <?php $controls->show(); ?>

        <form method="post" action="">
            <?php $controls->init(); ?>

            <div class="tnp-buttons">
                <?php $controls->button('add_composer', 'New channel') ?>
            </div>

            <?php $pagination_controller->display_paginator(); ?>

            <table class="widefat">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th><!--Status--></th>
                        <th colspan="2">Last newsletter</th>

                        <th title="Generated newsletters">#</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($channels as $channel) { ?>
                        <?php $email = $this->get_last_email($channel->id) ?>
                        <tr>
                            <td>
                                <?php echo $channel->id ?>
                            </td>
                            <td><?php echo esc_html($channel->data['name']) ?></td>
                            <td>
                                <span class="tnp-led-<?php echo!empty($channel->data['enabled']) ? 'green' : 'gray' ?>">&#x2B24;</span>
                            </td>

                            <td style="white-space: nowrap">
                                <?php if ($email) { ?>
                                    <?php echo $controls->print_date($email->send_on) ?>
                                <?php } ?>
                            </td>

                            <td>
                                <?php if ($email) { ?>

                                    <?php Newsletter::instance()->show_email_status_label($email) ?>
                                <?php } ?>
                            </td>
                            <td><?php echo $channel->newsletters_sent ?></td>

                            <td style="white-space: nowrap">
                                <?php
                                if ($channel->theme_type == NewsletterAutomated::THEME_TYPE_COMPOSER) {
                                    $controls->button_icon_configure('?page=newsletter_automated_edit&id=' . $channel->id);
                                } else {
                                    $controls->button_icon_configure('?page=newsletter_automated_editlegacy&id=' . $channel->id);
                                }
                                ?>

                                <?php $controls->button_icon_newsletters('?page=newsletter_automated_newsletters&id=' . $channel->id) ?>

                                <?php if ($channel->theme_type == NewsletterAutomated::THEME_TYPE_COMPOSER) { ?>
                                    <?php $controls->button_icon_design('?page=newsletter_automated_template&id=' . $channel->id) ?>
                                <?php } ?>
                            </td>

                            <td style="white-space: nowrap">
                                <?php $controls->button_icon_copy($channel->id); ?>
                                <?php $controls->button_icon_delete($channel->id); ?>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>


            <hr>
            <div class="tnp-buttons">
                <?php $controls->btn('add', 'New channel with obsolete themes', ['tertiary' => true]) ?>
                <?php $controls->btn_link('?page=newsletter_automated_config', 'Configuration', ['tertiary' => true]) ?>
            </div>
        </form>
    </div>
    <?php include NEWSLETTER_ADMIN_FOOTER ?>
</div>
