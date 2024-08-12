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
$newsletter = Newsletter::instance();

$debug = isset($_GET['debug']) || NEWSLETTER_DEBUG;

if (!$controls->is_action()) {
    $controls->set_data($autoresponder);
} else {

    if ($controls->is_action('save')) {
        $controls->data['id'] = $autoresponder->id;
        $autoresponder = $this->save_autoresponder($controls->data);
        $controls->set_data($autoresponder);
        $controls->add_toast_saved();
    }
}


$emails = $autoresponder->emails;

if ($autoresponder->test) {
    $controls->warnings[] = 'Running in test mode!';
}


if ($autoresponder->status) {
    $status_badge = '<span class="tnp-badge-green">' . esc_html('Enabled', 'newsletter') . '</span>';
} else {
    $status_badge = '<span class="tnp-badge-orange">' . esc_html('Disabled', 'newsletter') . '</span>';
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

            <div id="tabs">

                <ul>
                    <li><a href="#tabs-general"><?php esc_html_e('General', 'newsletter') ?></a></li>
                    <li><a href="#tabs-rules"><?php esc_html_e('Rules', 'newsletter') ?></a></li>
                    <li><a href="#tabs-analytics"><?php esc_html_e('Google Analytics', 'newsletter') ?></a></li>
                    <li class="tnp-tabs-advanced"><a href="#tabs-advanced"><?php esc_html_e('Advanced', 'newsletter') ?></a></li>
                </ul>

                <div id="tabs-general">
                    <table class="form-table">
                        <tr>
                            <th>Enabled</th>
                            <td><?php $controls->yesno('status') ?></td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <td><?php $controls->text('name', 70) ?></td>
                        </tr>
                        <tr valign="top">
                            <th>Sender name</th>
                            <td>
                                <?php $controls->text('sender_name', ['size' => 40]); ?>
                                <span class="description">
                                    Default: <?php echo esc_html(Newsletter::instance()->get_sender_name()) ?>
                                </span>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th>Sender email name</th>
                            <td>
                                <?php $controls->text_email('sender_email', ['size' => 40]); ?>
                                <span class="description">
                                    Default: <?php echo esc_html(Newsletter::instance()->get_sender_email()) ?>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="tabs-rules">
                    <p>
                        Rules to evaluate against new subscribers to connect them to this series.
                        <br>
                        For imported or manually added subscribers the rules are evaluated hourly, see the
                        option below.
                    </p>
                    <table class="form-table">
                        <tr>
                            <th>Enabled?</th>
                            <td>
                                <?php $controls->enabled('rules', ['bind_to' => 'divrules']) ?>
                                <p class="description">
                                    When disabled the series can anyway be connected to subscribers
                                    by addons, custom subscription forms, and so on.
                                </p>
                            </td>
                        </tr>
                    </table>

                    <table class="form-table" id="options-divrules">
                        <tr>
                            <th>List</th>
                            <td>
                                <?php $controls->lists_select_with_notes('list', 'All subscribers') ?>
                                <p class="description">
                                    If selected only subscribers with a mathcing list will be connected.
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <th>Language</th>
                            <td>
                                <?php $controls->language() ?>
                                <p class="description">
                                    Only subscribers with a matching language will be connected.
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <th>Keep active</th>
                            <td>
                                <?php $controls->yesno('keep_active') ?>
                                <p class="description">
                                    Keep a subscriber active even when it doesn't match the rules anymore. Rules are evaluated only when
                                    a message is going to be sent, so the subscriber stays connected until that moment.
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <th>Apply rules periodically</th>
                            <td>
                                <?php $controls->select('align', ['0' => 'No', '1' => 'Every hour']); ?>
                                <?php $controls->button_confirm_secondary('align', 'Run now') ?>
                                <?php if (!empty($autoresponder->align)) { ?>
                                        Next run: <?php echo NewsletterControls::print_date(wp_next_scheduled('newsletter_autoresponder_align'), false, true); ?>
                                    <?php } ?>
                                <p class="description">
                                    Process all the subscribers and connect them if needed. Useful for imported subscribers, manually edited and so
                                    on. Regular subscriptions are processed automatically.

                                </p>
                            </td>
                        </tr>
                    </table>

                </div>
                <div id="tabs-advanced">
                    <table class="form-table">
                        <tr>
                            <th>Restart on re-subscription</th>
                            <td>
                                <?php $controls->yesno('restart') ?>
                                <p class="description">
                                    If a subscriber re-subscribes and the series is already completed, restart it.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>Update emails content</th>
                            <td>
                                <?php $controls->yesno('regenerate') ?>
                                <p class="description">
                                    If the content of the emails should be updated every day (it applies to post list, product list and so on)
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>Lists to add on completion</th>
                            <td>
                                <?php $controls->lists('new_lists') ?>
                                <p class="description">
                                    List to be set on a subscriber's profile when the series reaches its end.
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="tabs-analytics">

                    <p>
                        Google Analytics addon required.<br>
                        On UTM parameters <code>{email_id}</code> and <code>{email_subsject}</code> can be used to make them dynamic.<br>
                    </p>

                    <table class="form-table">
                        <tr>
                            <th>UTM Campaign</th>
                            <td>
                                <?php $controls->text('utm_campaign', 50); ?>
                                <p class="description">

                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>UTM Source (mandatory)</th>
                            <td>
                                <?php $controls->text('utm_source', 50); ?>
                                <p class="description">
                                    Use the <code>{step}</code> tag to have the step number inserted (1, 2, 3, ...). The suggested value
                                    is <code>step-{step}</code>.
                                </p>
                            </td>
                        </tr>


                        <tr>
                            <th>UTM Medium</th>
                            <td>
                                <?php $controls->text('utm_medium', 50); ?>
                                <p class="description">
                                    Should be set to "email" since this is the only medium used.
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <th>UTM Term</th>
                            <td>
                                <?php $controls->text('utm_term', 50); ?>
                                <p class="description">
                                    Usually empty can be used on specific newsletters but it is more related to keyword based advertising.
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <th>UTM Content</th>
                            <td>
                                <?php $controls->text('utm_content', 50); ?>
                                <p class="description">
                                    Usually empty can be used on specific newsletters.
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="tnp-buttons">
                <?php $controls->button_save(); ?>
            </div>



        </form>

    </div>
</div>
