<?php
/* @var $this NewsletterAutomated */
/* @var $controls NewsletterControls */
/* @var $wpdb wpdb */

global $wpdb;

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();

$channel = $this->get_channel($_GET['id']);

if (!$channel) {
    echo 'Channel not found';
    return;
}

$email = Newsletter::instance()->get_email($channel->email_id);
if ($email && empty($email->message)) {
    $controls->warnings[] = 'The newsletter template has not yet configured.';
}

$logger = $this->get_admin_logger();

if (!$controls->is_action()) {

    $controls->data = $channel->data;
} else {

    if ($controls->is_action('now')) {
        $this->log($channel->id, 'Manually started');
        $logger->info('Forced newsletter generation for channel ' . $channel->id);
        if ($controls->data['enabled'] == 1) {
            update_option('newsletter_automated_' . $channel->id . '_wakeup', 0, false);
            $res = $this->hook_newsletter_automated($channel->id, true);
            if ($res) {
                $controls->messages = 'New newsletter generated and scheduled.';
            } else {
                $controls->errors = 'There is no new content to generate a new newsletter. You may change the last sent time to include already processed posts.';
            }
        } else {
            $controls->errors = 'This channel is not enabled.';
        }
    }

    if ($controls->is_action('save')) {

        $logger->info('Saved channel ' . $channel->id);

        $wpdb->update($wpdb->prefix . "newsletter_automated", array('data' => json_encode($controls->data)), array('id' => $channel->id));

        // Sometime it is saved as string, ALWAYS unschedule both versions!
        wp_clear_scheduled_hook('newsletter_automated', array((int) $channel->id));
        wp_clear_scheduled_hook('newsletter_automated', array((string) $channel->id));

        // Create the daily event at the specified time
        if ($controls->data['enabled'] == 1) {
            if ($controls->data['frequency'] === 'hourly') {
                $time = time() - time() % HOUR_IN_SECONDS + HOUR_IN_SECONDS; // Next hour
                wp_schedule_event($time, 'hourly', 'newsletter_automated', [(int) $channel->id]);
            } else {

                $hour = (int) $controls->data['hour'] - get_option('gmt_offset'); // to gmt
                // Set always to the next day to avoid to send the same day twice because delivery hour change!
                $day = gmdate("d");
                if (gmdate('G') > $hour) {
                    $day++;
                }
                $time = gmmktime($hour, 0, 0, gmdate("m"), $day, gmdate("Y"));
                // int must be forced, the object id is a string!
                wp_schedule_event($time, 'daily', 'newsletter_automated', array((int) $channel->id));

                // Second time scheduled
                if (!empty($controls->data['hour2_enabled'])) {
                    $hour = (int) $controls->data['hour2'] - get_option('gmt_offset'); // to gmt
                    // Set always to the next day to avoid to send the same day twice because delivery hour change!
                    $day = gmdate("d");
                    if (gmdate('G') > $hour) {
                        $day++;
                    }
                    $time = gmmktime($hour, 0, 0, gmdate("m"), $day, gmdate("Y"));
                    // int must be forced, the object id is a string!
                    wp_schedule_event($time, 'daily', 'newsletter_automated', array((int) $channel->id));
                }
            }
        }

        $channel = $this->get_channel($channel->id);
    }

    if ($controls->is_action('reset_time')) {
        $logger->info('Time reset for channel ' . $channel->id);
        $this->set_last_run($channel->id, 0);
        $controls->messages = 'Reset. On next run all posts are considered as new';
        $channel = $this->get_channel($channel->id);
    }

    if ($controls->is_action('back_time')) {
        $logger->info('Back 1 day for channel ' . $channel->id);
        $this->add_to_last_run($channel->id, -3600 * 24);
        $controls->messages = 'Set.';
        $channel = $this->get_channel($channel->id);
    }

    if ($controls->is_action('forward_time')) {
        $logger->info('Forward 1 day for channel ' . $channel->id);
        $this->add_to_last_run($channel->id, 3600 * 24);
        $controls->messages = 'Set.';
        $channel = $this->get_channel($channel->id);
    }

    if ($controls->is_action('now_time')) {
        $logger->info('Time set to now for channel ' . $channel->id);
        $this->set_last_run($channel->id, time());
        $controls->messages = 'Set.';
        $channel = $this->get_channel($channel->id);
    }

    if ($controls->is_action('import')) {
        $list = (int) $controls->data['list'];
        if (empty($list)) {
            $controls->errors = 'Feed by mail subscriber import can be done only when a list is selected';
        } else {
            $res = $wpdb->query("update " . NEWSLETTER_USERS_TABLE . " set list_{$list}=1 where feed=1");
            $controls->messages = "Imported $res subscribers.";
        }
    }
}

$email = $this->get_last_email($channel->id);

if ($channel->last_run_status) {

    $controls->add_message('On last run there was no new contents and the newsletter has not been generated. If you think it is wrong, please check your template dynamic blocks.');
}

$badge = '';
if ($channel->data['enabled']) {
    $badge = '<span class="tnp-badge-green">' . esc_html__('Enabled', 'newsletter') . '</span>';
} else {
    $badge = '<span class="tnp-badge-orange">' . esc_html__('Disabled', 'newsletter') . '</span>';
}

if ($email) {
    $badge .= '<span class="tnp-badge-green">Last sent: ' . esc_html($controls->print_date($email->send_on)) . '</span>';
}



if (!empty($controls->data['enabled'])) {
    if (!wp_next_scheduled('newsletter_automated', [(int) $channel->id])) {
        $controls->errors .= 'Something happened in your WP, the Automated engine has been disabled. Please press "save" to restore.';
    }
}
?>

<style>
    #preview-subject {
        font-size: 20px;
        border: 1px solid #ccc;
        margin-bottom: 16px;
        padding: 10px;
    }
    #preview-desktop, #preview-mobile {
        float: left;
        border: 1px dashed #aaa;
        height: 500px
    }
    #preview-desktop, #preview-subject {
        width: 800px;
    }
    #preview-mobile {
        width: 375px;
        margin-left: 20px;
    }
</style>



<div class="wrap" id="tnp-wrap">
    <?php include NEWSLETTER_ADMIN_HEADER ?>
    <div id="tnp-heading">

        <h2><?php echo esc_html($channel->data['name']) ?> <?php echo $badge; ?></h2>
        <?php include __DIR__ . '/nav.php' ?>

    </div>

    <div id="tnp-body" class="tnp-automated-edit">

        <?php $controls->show(); ?>

        <form method="post" action="">
            <?php $controls->init(); ?>

            <div class="tnp-buttons">
                <?php $controls->button_save('save', 'Save'); ?>
                <?php if ($controls->data['enabled'] == 1) { ?>
                    <?php $controls->button_confirm('now', 'Generate and send now', 'Are you sure?'); ?>
                <?php } ?>
            </div>

            <div id="tabs">

                <ul>
                    <li><a href="#tabs-configuration">Configuration</a></li>
                    <li><a href="#tabs-planning">Planning</a></li>
                    <li><a href="#tabs-newsletter-preview">Preview</a></li>
                    <li><a href="#tabs-ga">Google Analytics</a></li>
                    <li class="tnp-tabs-advanced"><a href="#tabs-status">Advanced</a></li>
                </ul>

                <div id="tabs-configuration">

                    <table class="form-table">
                        <tr valign="top">
                            <th>Enabled?</th>
                            <td>
                                <?php $controls->yesno('enabled'); ?>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>Channel name</th>
                            <td>
                                <?php $controls->text('name', 50); ?>
                                <p class="description">
                                    For internal use, be descriptive.
                                </p>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th>Subject</th>
                            <td>
                                <?php $controls->text('subject', 50); ?>
                                <p class="description">

                                    If empty the first block suggested subject is used. Use <code>{dynamic_subject}</code> to reference the first block suggested
                                    subject. Use <code>{date}</code> tag for the current date
                                    (<a href="https://www.thenewsletterplugin.com/documentation/newsletter-tags" target="_blank">see more options</a>).

                                </p>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th>Send to list</th>
                            <td>
                                <?php $controls->lists_select('list', 'Everyone'); ?>
                                <p class="description">
                                    The subscriber list this channel is sent to. Subscribers can stop to receive this channel disabling the
                                    list on their profile.
                                </p>
                            </td>
                        </tr>
                        <?php if (Newsletter::instance()->is_multilanguage()) { ?>
                            <tr valign="top">
                                <th>Filter subscribers by language</th>
                                <td>
                                    <?php $controls->languages(); ?>
                                    <p class="description">
                                        If no language is selected, no filter is applied. This filter DOES NOT affect the newsletter content.
                                    </p>
                                </td>
                            </tr>
                        <?php } ?>

                        <?php
                        $fields = NewsletterAdmin::instance()->get_customfields();
                        ?>
                        <?php if (!empty($fields)) { ?>
                            <tr>
                                <th><?php _e('Profile fields', 'newsletter') ?></th>
                                <td>
                                    <?php foreach ($fields as $profile) { ?>
                                        <?php if ($profile->type !== TNP_Profile::TYPE_SELECT) continue; ?>
                                        <?php echo esc_html($profile->name), ' ', __('is one of:', 'newsletter') ?>
                                        <?php $controls->select2("profile_$profile->id", $profile->options, null, true, null, __('Do not filter by this field', 'newsletter')); ?>
                                        <br>
                                    <?php } ?>
                                    <p class="description">

                                    </p>
                                </td>
                            </tr>
                        <?php } ?>

                        <tr valign="top">
                            <th>Track opens and clicks?</th>
                            <td>
                                <?php $controls->yesno('track'); ?>
                            </td>
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

                <div id="tabs-planning">
                    <table class="form-table">
                        <tr valign="top">
                            <th>Planning</th>
                            <td>
                                <?php $controls->radio('frequency', 'hourly', 'Hourly'); ?><br>
                                <p class="description">
                                    Every hour the template is activate and a newsletter is created if it found new content.<br>
                                    It does nothing if a newsletter is already sending (to avoid excessive queuing).
                                </p>
                                <br><br>
                                <?php $controls->radio('frequency', 'weekly', 'Weekly on...'); ?><br>
                                Monday&nbsp;<?php $controls->yesno('day_1'); ?>
                                Tuesday&nbsp;<?php $controls->yesno('day_2'); ?>
                                Wednesday&nbsp;<?php $controls->yesno('day_3'); ?>
                                Thursday&nbsp;<?php $controls->yesno('day_4'); ?>
                                Friday&nbsp;<?php $controls->yesno('day_5'); ?>
                                Saturday&nbsp;<?php $controls->yesno('day_6'); ?>
                                Sunday&nbsp;<?php $controls->yesno('day_7'); ?>
                                <br><br>
                                <?php $controls->radio('frequency', 'monthly', 'Monthly on...'); ?><br>

                                <style>
                                    #tnp-monthly-plan {
                                        width: auto!important;
                                    }
                                    #tnp-monthly-plan th, #tnp-monthly-plan td {
                                        padding: 3px;
                                        text-align: center;
                                        width: 80px;
                                    }
                                    #tnp-monthly-plan th {
                                        font-weight: bold;
                                    }
                                </style>
                                <table id="tnp-monthly-plan">
                                    <tr>
                                        <th>Week</th>
                                        <th>Monday</th>
                                        <th>Tuesday</th>
                                        <th>Wednesday</th>
                                        <th>Thursday</th>
                                        <th>Friday</th>
                                        <th>Saturday</th>
                                        <th>Sunday</th>
                                    </tr>
                                    <?php for ($week = 1; $week <= 5; $week++) { ?>

                                        <tr>
                                            <td><?php echo $week; ?></td>
                                            <?php
                                            for ($i = 1; $i <= 7; $i++) {
                                                echo '<td>';
                                                $controls->checkbox_group('monthly_' . $week . '_days', $i);
                                                echo '</td>';
                                            }
                                            ?>
                                        </tr>
                                    <?php } ?>

                                </table>

                            </td>
                        </tr>

                        <tr valign="top">
                            <th>Delivery hour</th>
                            <td>
                                <?php $controls->hours('hour'); ?>
                                <span class="description">
                                    <a href="https://www.thenewsletterplugin.com/documentation/addons/extended-features/automated-extension/#hours">Read more about DST (Daylight Time Saving)</a>
                                </span>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th>Second optional delivery hour</th>
                            <td>
                                <?php $controls->enabled('hour2_enabled', ['bind_to' => 'hour2']); ?>

                                <?php $controls->hours('hour2'); ?>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="tabs-ga">
                    <p>
                        Requires the <a href="?page=newsletter_main_extensions">Analytics Addon</a>. UTMs parameters are not added to links
                        on newsletter body but appended when the subscriber clicks them. Links on test newsletter are not processed.
                    </p>
                    <table class="form-table">
                        <tr>
                            <th>UTM Campaign</th>
                            <td>
                                <?php $controls->text('utm_campaign', 50); ?>
                                <p class="description">
                                    This is the campaign name, mandatory to track, could be your channel name
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>UTM Source</th>
                            <td>
                                <?php $controls->text('utm_source', 50); ?>
                                <p class="description">
                                    Should set as "newsletter-{email_id}" and it's mandatory for Google. "{email_id}" is replaced with the
                                    newsletter unique id. Automated newsletter, autoresponders and other non standard newsletter use a different
                                    source like automated-{channel numer}-{email id}.
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

                <div id="tabs-newsletter-preview">
                    <p>
                        Generated newsletter preview as if it would be sent right now. Different content could be included at
                        sending time. Dynamic subject can be different at delivery time.
                    </p>
                    <p>
                        <strong>If empty there is no new contents since the last delivery.</strong>
                    </p>
                    <script>
                        function setPreviewSubject(iframe) {
                            document.getElementById("preview-subject").innerHTML = iframe.contentDocument.title;
                        }
                    </script>

                    <div id="preview-subject"></div>
                    <iframe id="preview-desktop" src="<?php echo wp_nonce_url(Newsletter::add_qs(home_url('/'), 'real=1&na=automated-preview&id=' . $channel->id), 'preview'); ?>&real=1" onload="setPreviewSubject(this)"></iframe>

                    <iframe id="preview-mobile" src="<?php echo wp_nonce_url(Newsletter::add_qs(home_url('/'), 'real=1&na=automated-preview&id=' . $channel->id), 'preview'); ?>"></iframe>

                    <div style="clear: both"></div>
                </div>

                <div id="tabs-status">

                    <p>
                        Posts below are the one will be included on next email (sheduled future posts are not counted so
                        more posts could be included).
                    </p>

                    <table class="form-table">

                        <tr valign="top">
                            <th>Last sent time</th>
                            <td>
                                <?php echo NewsletterControls::print_date($channel->last_run); ?>
                                <?php $controls->button_confirm('reset_time', 'Reset as it never ran', 'Are you sure?'); ?>
                                <?php $controls->button('back_time', 'Back one day'); ?>
                                <?php $controls->button('forward_time', 'Forward one day'); ?>
                                <?php $controls->button('now_time', 'Set to now'); ?>
                                <p class="description">
                                    Last time a newsletter has been generated and sent.
                                </p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>Generator next run</th>
                            <td>
                                <?php echo NewsletterControls::print_date(wp_next_scheduled('newsletter_automated', [(int) $channel->id]), false, true); ?>
                                <p class="description">
                                    When the newsletter generator runs next time in its daily cycle. Of course on not enabled days it will
                                    stop suddenly.
                                </p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>Subscribers on this channel</th>
                            <td>
                                <?php echo $this->get_subscriber_count($channel) ?>
                                <?php if (NEWSLETTER_DEBUG) { ?>
                                    <p class="description"><code><?php echo $this->generate_subscribers_list_query($channel) ?>
                                        <?php } ?>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>Import</th>
                            <td>
                                <?php $controls->button_confirm('import', 'Import feed by mail subscribers', 'Are you sure?'); ?>
                                <p class="description">
                                    The import associates the "old" feed by mail subscribed user to the Newsletter list associated to this
                                    channel.
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>



            </div>


        </form>

    </div>
    <?php include NEWSLETTER_ADMIN_FOOTER ?>
</div>
