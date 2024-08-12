<?php
/* @var $this NewsletterAutoresponderAdmin */
/* @var $wpdb wpdb */
global $wpdb;

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();

$logger = $this->get_logger();

$debug = isset($_GET['debug']) || NEWSLETTER_DEBUG;

// Delete data of no more existent subscribers
$this->delete_orphan_steps();

if ($controls->is_action('add')) {
    $data = ['name' => 'New autoresponder', 'status' => 0, 'emails' => []];
    $data = $this->save_autoresponder($data);
    $controls->js_redirect('?page=newsletter_autoresponder_edit&id=' . rawurlencode($data->id));
}

if ($controls->is_action('add_composer')) {
    $data = ['name' => 'New autoresponder', 'status' => 0, 'type' => TNP_Autoresponder::TYPE_COMPOSER, 'emails' => []];
    $data = $this->save_autoresponder($data);
    $controls->js_redirect('?page=newsletter_autoresponder_edit&id=' . rawurlencode($data->id));
    exit();
}

if ($controls->is_action('delete')) {

    $res = $this->delete_autoresponder((int) $_POST['btn']);

    if ($res === false) {
        $controls->errors = __('Unable to delete.', 'newsletter-autoresponder');
    } else {
        $controls->add_toast_deleted();
    }
}

if ($controls->is_action('copy')) {
    $logger->info('Copy of series ' . $_POST['btn']);

    $this->copy_autoresponder((int) $_POST['btn']);
    $controls->add_toast(__('Duplicated.', 'newsletter-autoresponder'));
}

if ($controls->is_action('reset_error')) {
    update_option('newsletter_autoresponder_error', '', false);
    $controls->add_toast_done();
}

$autoresponders = $this->get_autoresponders();

$max_delay = 3600 * 8;
if ($debug) {
    $max_delay = 3600;
}

$late_total = 0;
$late_min_send_at = time();

foreach ($autoresponders as $ar) {
    if ($ar->status != 1) {
        continue;
    }
    // Compute the queued subscriber which are late
    $r = $wpdb->get_row("select autoresponder_id, min(send_at) as min_send_at, count(*) as total from {$wpdb->prefix}newsletter_autoresponder_steps where status=0 and send_at<" . time() . " and autoresponder_id=" . $ar->id);
    if ($r && $r->total) {
        $late_total += $r->total;
        $late_min_send_at = min($late_min_send_at, $r->min_send_at);
        if ($late_min_send_at < time() - $max_delay) {
            $controls->warnings[] = 'Series ' . $ar->id . ' has late messages in queue. ' .
                    '<a href="https://www.thenewsletterplugin.com/documentation/addons/extended-features/autoresponder-extension/#late-messages" target="_blank">Read more</a>. ' .
                    'You can check the <a href="?page=newsletter_system_status">status page</a> for warnings as well.<br>' .
                    'Max delay: ' . $controls->delta_time(time() - $late_min_send_at);
        }
    }
}

$error = get_option('newsletter_autoresponder_error');
if ($error) {
    $controls->errors = 'Autoresponder is not working due to a fatal error: ' . esc_html($error) . '.<br>'
            . ' Once solved you can reset the error condition with the button at the end of this page.';
}
?>

<div class="wrap" id="tnp-wrap">
    <?php include NEWSLETTER_ADMIN_HEADER; ?>
    <div id="tnp-heading">
        <?php $controls->title_help('/addons/extended-features/autoresponder-extension/') ?>
        <h2>Autoresponders/Email series</h2>
    </div>

    <div id="tnp-body">
        <?php $controls->show(); ?>


        <form method="post" action="">
            <?php $controls->init(); ?>

            <div class="tnp-buttons">
                <?php $controls->button('add_composer', 'Add new email series') ?>
            </div>
            <table class="widefat">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>&nbsp;</th>
                        <th>Name</th>
                        <th>List</th>
                        <?php if (Newsletter::instance()->is_multilanguage()) { ?>
                            <th>Language</th>
                        <?php } ?>

                        <th>Steps</th>
                        <th title="Active subscribers not completed or stopped">
                            Subscribers
                            <i class="fas fa-info-circle tnp-notes" title="Active subscribers not completed or stopped"></i>

                        </th>
                        <?php if ($debug) { ?>
                            <th><code>Late</code></th>
                        <?php } ?>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($autoresponders as $autoresponder) { ?>
                        <tr>
                            <td><?php echo $autoresponder->id ?></td>
                            <td>
                                <span class="tnp-led-<?php echo!empty($autoresponder->status) ? 'green' : 'gray' ?>">&#x2B24;</span>
                            </td>
                            <td><?php echo esc_html($autoresponder->name) ?></td>
                            <td>
                                <?php
                                if (!empty($autoresponder->rules)) {
                                    $list = Newsletter::instance()->get_list($autoresponder->list);
                                    if ($list) {
                                        echo esc_html($list->name);
                                    } else {
                                        esc_html_e('All subscribers', 'newsletter');
                                    }
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <?php if (Newsletter::instance()->is_multilanguage()) { ?>
                                <td>
                                    <?php
                                    if (!empty($autoresponder->rules)) {
                                        $list = Newsletter::instance()->get_list($autoresponder->list);
                                        if (empty($autoresponder->language)) {
                                            esc_html_e('All', 'newsletter');
                                        } else {
                                            echo esc_html($autoresponder->language);
                                        }
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                            <?php } ?>

                            <td><?php echo count($autoresponder->emails) ?></td>
                            <td style="text-align: right">
                                <?php echo (int) $this->get_user_count($autoresponder) ?>
                                <!--
                                <a href="?page=newsletter_autoresponder_statistics&id=<?php echo $autoresponder->id; ?>"><i class="fas fa-chart-bar"></i></a>
                                -->
                            </td>


                            <?php if ($debug) { ?>
                                <td style="text-align: right">
                                    <code><?php echo (int) $this->get_late_user_count($autoresponder) ?></code>
                                </td>
                            <?php } ?>

                            <td style="white-space: nowrap">
                                <?php $controls->button_icon_configure('?page=newsletter_autoresponder_edit&id=' . $autoresponder->id) ?>
                                <?php $controls->button_icon_statistics('?page=newsletter_autoresponder_statistics&id=' . $autoresponder->id) ?>
                                <?php $controls->button_icon_subscribers('?page=newsletter_autoresponder_users&id=' . $autoresponder->id) ?>

                                <?php if ($autoresponder->type == TNP_Autoresponder::TYPE_CLASSIC) { ?>
                                    <?php $controls->button_icon_design('?page=newsletter_autoresponder_theme&id=' . $autoresponder->id) ?>
                                <?php } ?>
                            </td>
                            <td style="white-space: nowrap">
                                <?php $controls->button_icon_copy($autoresponder->id); ?>
                                <?php $controls->button_icon_delete($autoresponder->id); ?>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
            <hr style="border-color: #ccc">
            <p>

                <?php $controls->btn_link('?page=newsletter_autoresponder_index&debug=1', 'Load this page showing debug information', ['secondary' => true]) ?>
                <?php
                if ($error) {
                    $controls->btn('reset_error', 'Reset the error condition', ['secondary' => true]);
                }
                ?>
            </p>
            <p>
                <?php $controls->btn('add', 'DEPRECATED - New email series with old themes', ['tertiary' => true]) ?>
            </p>

        </form>

    </div>

</div>
