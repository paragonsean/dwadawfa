<?php
/* @var $this NewsletterReports */

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';

$coreModule = Newsletter::instance();
$statisticsModule = NewsletterStatistics::instance();
$controls = new NewsletterControls();

$email = Newsletter::instance()->get_email((int) $_GET['id'] ?? 0);
if (!$email) {
    die('Email not found');
}

$ips = $wpdb->get_results($wpdb->prepare("SELECT ip, count(*) as total FROM " . NEWSLETTER_STATS_TABLE . " where email_id=%d and url <> '' group by ip order by count(*) desc limit 50", $email->id));

$ips_open = $wpdb->get_results($wpdb->prepare("SELECT ip, count(*) as total FROM " . NEWSLETTER_STATS_TABLE . " where email_id=%d and url = '' group by ip order by count(*) desc limit 50", $email->id));
?>
<link rel="stylesheet" href="<?php echo esc_attr(plugins_url('newsletter-reports')) ?>/admin/style.css" type="text/css">

<div class="wrap" id="tnp-wrap">

    <?php include NEWSLETTER_ADMIN_HEADER ?>

    <?php include __DIR__ . '/view-heading.php' ?>

    <div id="tnp-body">
        <?php $controls->show(); ?>

        <p>
            This is a diagnostic panel.
        </p>

        <div class="row">
            <div class="col-md-6">
                <h3>Clicks</h3>

                <table class="widefat" style="width: auto">

                    <thead>
                        <tr class="text-left">
                            <th>IP</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($ips as $ip) { ?>
                            <tr>
                                <td>
                                    <?php echo esc_html($ip->ip) ?>
                                </td>
                                <td><?php echo esc_html($ip->total) ?></td>

                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h3>Opens</h3>
                <table class="widefat" style="width: auto">

                    <thead>
                        <tr class="text-left">
                            <th>IP</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($ips_open as $ip) { ?>
                            <tr>
                                <td>
                                    <?php echo esc_html($ip->ip) ?>
                                </td>
                                <td><?php echo esc_html($ip->total) ?></td>

                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


