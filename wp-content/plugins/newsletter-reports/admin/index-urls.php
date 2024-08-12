<?php
/* @var $this NewsletterReports */
/* @var $wpdb wpdb */

global $wpdb;

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();

if ($controls->is_action('update')) {
    $this->save_options($controls->data);
}

$controls->data = $this->get_options();
if (!is_array($controls->data)) {
    $controls->data = [];
}
$controls->data = array_merge(['type' => 'message', 'days' => 180], $controls->data);

$email_type = $controls->data['type'];
$send_mode = $this->get_email_send_mode($email_type);

if (!isset($controls->data['days'])) {
    $controls->data['days'] = 180;
}

$days = (int) $controls->data['days'];

// Emails generated by Autoresponder should be managed in a particular way
$autoresponder = strpos($email_type, 'autoresponder') !== false;
$welcome = strpos($email_type, 'welcome') !== false;
$is_continuous = $send_mode === 'continuous' || $autoresponder || $welcome;

if (!$is_continuous) {
    if (empty($days)) {
        $emails = $wpdb->get_results($wpdb->prepare("select id from " . NEWSLETTER_EMAILS_TABLE . " where status='sent' and type=%s order by send_on desc", $email_type));
    } else {
        $emails = $wpdb->get_results($wpdb->prepare("select id from " . NEWSLETTER_EMAILS_TABLE . " where status='sent' and type=%s and send_on>unix_timestamp()-$days*24*3600 order by send_on desc", $email_type));
    }
} else {
    // TODO: Get the emails IDs from the autoresponder!
    // TODO: Delegate Autoresponder to extract the email list? Should be a good idea!
    $emails = $wpdb->get_results($wpdb->prepare("select id from " . NEWSLETTER_EMAILS_TABLE . " where status='sent' and type=%s", $email_type));
}

$email_ids = [];
foreach ($emails as $email) {
    $email_ids[] = (int) $email->id;
}



//$email_ids = array_map('intval', explode(',', $_GET['email_ids']));

$urls = $wpdb->get_results("select url, count(distinct user_id) as number from " . NEWSLETTER_STATS_TABLE . " where url<>'' and email_id in (" . implode(',', $email_ids) . ") group by url order by number desc");
$total = $wpdb->get_var("select count(distinct user_id) from " . NEWSLETTER_STATS_TABLE . " where url<>'' and email_id in (" . implode(',', $email_ids) . ")");
?>
<link rel="stylesheet" href="<?php echo plugins_url('newsletter-reports') ?>/admin/style.css?ver=<?php echo $this->version ?>" type="text/css">


<div class="wrap" id="tnp-wrap">
    <?php include NEWSLETTER_ADMIN_HEADER ?>
    <div id="tnp-heading">

        <?php $controls->title_help('/reports-extension') ?>
        <h2><?php echo esc_html_e('Reports', 'newsletter') ?></h2>
        <?php include __DIR__ . '/index-nav.php' ?>

    </div>

    <div id="tnp-body" class="tnp-statistics">

<?php include __DIR__ . '/index-filter-form.php'?>
        <table class="widefat">
            <thead>
                <tr>
                    <th>Clicked URLs</th>
                    <th>Clicks</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($urls); $i++) : ?>
                    <tr>
                        <td>
                            <a href="<?php echo esc_url($urls[$i]->url) ?>" target="_blank"><?php echo esc_html($urls[$i]->url) ?></a>
                        </td>
                        <td><?php echo $urls[$i]->number ?></td>
                        <td>
                            <?php echo NewsletterModule::percent($urls[$i]->number, $total); ?>
                        </td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
        <?php include NEWSLETTER_DIR . '/tnp-footer.php'; ?>



    </div>
</div>