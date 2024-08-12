<?php
/* @var $this NewsletterAutoresponderAdmin */
global $wpdb;
require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();

$autoresponder = $this->get_autoresponder((int) $_GET['id']);
if (!$autoresponder) {
    die('Autoresponder not found.');
}
$statistics = NewsletterStatisticsAdmin::instance();

$emails = [];
foreach ($autoresponder->emails as $email_id) {
    $emails[] = Newsletter::instance()->get_email($email_id);
}
?>
<style>
    .widefat {
        min-width: 500px;
    }
</style>

<div class="wrap" id="tnp-wrap">
    <?php include NEWSLETTER_ADMIN_HEADER ?>
    <div id="tnp-heading">
        <?php include __DIR__ . '/nav.php' ?>
    </div>
    <div id="tnp-body">

        <?php $controls->show(); ?>

        <form method="post" action="">
            <?php $controls->init(); ?>

            <div id="tabs" class="tnp-tabs">

                <ul>
                    <li><a href="#tabs-email"><?php esc_html_e('By email', 'newsletter') ?></a></li>
                    <li><a href="#tabs-status"><?php esc_html_e('By status', 'newsletter') ?></a></li>
                    <li><a href="#tabs-abandons"><?php esc_html_e('Abandons', 'newsletter') ?></a></li>
                </ul>

                <div id="tabs-email">
                    <p>Counts are limited to active subscribers who have not abandoned the series (by list change, cancellation, ...).</p>

                    <table class="widefat" style="width: auto">
                        <thead>
                            <tr>
                                <th>Progress</th>
                                <th>Subscribers</th>
                                <th>Subject</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0; ?>
                            <?php for ($i = 0; $i < count($emails); $i++) { ?>
                                <?php
                                $email = $emails[$i];
                                $count = $wpdb->get_var($wpdb->prepare("select count(*) from " . $wpdb->prefix . "newsletter_autoresponder_steps where autoresponder_id=%d and step=%d and status=" . TNP_Autoresponder_Step::STATUS_RUNNING, $autoresponder->id, $i));
                                $total += $count;
                                ?>
                                <tr>
                                    <td>Waiting to receive message <?php echo $i + 1 ?></td>

                                    <td>
                                        <?php echo $count ?>
                                    </td>
                                    <td>
                                        <?php echo esc_html($email->subject) ?>
                                    </td>
                                    <td>
                                        <?php $controls->button_icon_statistics($statistics->get_statistics_url($autoresponder->emails[$i])) ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><strong>Total queued</strong></td>
                                <td>
                                    <strong>
                                        <?php echo $total ?>
                                    </strong>
                                </td>
                                <td>
                                    &nbsp;
                                </td>
                                <td>
                                    &nbsp;
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="tabs-status">

                    <p>Overview of subscriber on this message series.</p>
                    <table class="widefat" style="width: auto">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Subscribers</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>Completed</td>
                                <td>
                                    <?php echo $wpdb->get_var($wpdb->prepare("select count(*) from " . $wpdb->prefix . "newsletter_autoresponder_steps where autoresponder_id=%d and status=1", $autoresponder->id))
                                    ?>
                                </td>

                            </tr>
                            <tr>
                                <td>Active</td>
                                <td>
                                    <?php echo $wpdb->get_var($wpdb->prepare("select count(*) from " . $wpdb->prefix . "newsletter_autoresponder_steps where autoresponder_id=%d and status=0", $autoresponder->id))
                                    ?>
                                </td>

                            </tr>
                            <tr>
                                <td>Abandoned</td>
                                <td>
                                    <?php echo $wpdb->get_var($wpdb->prepare("select count(*) from " . $wpdb->prefix . "newsletter_autoresponder_steps where autoresponder_id=%d and status=%d", $autoresponder->id, TNP_Autoresponder_Step::STATUS_NOT_IN_LIST))
                                    ?>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    Other<br>
                                    <small>Missing user, errors</small>
                                </td>
                                <td>

                                    <?php echo $wpdb->get_var($wpdb->prepare("select count(*) from " . $wpdb->prefix . "newsletter_autoresponder_steps where autoresponder_id=%d and status not in (0, 1, " . TNP_Autoresponder_Step::STATUS_NOT_IN_LIST . ")", $autoresponder->id))
                                    ?>
                                </td>

                            </tr>
                            <tr>
                                <td><strong>Total</strong></td>
                                <td>
                                    <strong>
                                        <?php echo $wpdb->get_var($wpdb->prepare("select count(*) from " . $wpdb->prefix . "newsletter_autoresponder_steps where autoresponder_id=%d", $autoresponder->id)) ?>
                                    </strong>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="tabs-abandons">

                    <p>At which message subscribers abandoned the series (by subscription cancellation or list change)</p>
                    <table class="widefat" style="width: auto">
                        <thead>
                            <tr>
                                <th>Step</th>
                                <th>Subscribers</th>
                                <th>Subject</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Before to receive the first message</td>
                                <td>
                                    <?php echo $wpdb->get_var($wpdb->prepare("select count(*) from " . $wpdb->prefix . "newsletter_autoresponder_steps where autoresponder_id=%d and step=0 and status=%d", $autoresponder->id, TNP_Autoresponder_Step::STATUS_NOT_IN_LIST))
                                    ?>
                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>



                            </tr>
                            <?php for ($i = 0; $i < count($emails); $i++) { ?>
                                <?php
                                $email = $emails[$i];
                                ?>
                                <tr>
                                    <td>After the message <?php echo $i + 1 ?></td>
                                    <td>
                                        <?php
                                        echo $wpdb->get_var($wpdb->prepare("select count(*) from " . $wpdb->prefix . "newsletter_autoresponder_steps where autoresponder_id=%d and step=%d and (status=%d or status=%d)", $autoresponder->id, $i + 1, TNP_Autoresponder_Step::STATUS_NOT_IN_LIST, TNP_Autoresponder_Step::STATUS_NOT_CONFIRMED))
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo esc_html($email->subject) ?>
                                    </td>
                                    <td>
                                        <?php $controls->button_icon_statistics($statistics->get_statistics_url($autoresponder->emails[$i])) ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>

    </div>

</div>
