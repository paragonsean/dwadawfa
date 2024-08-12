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

if ($controls->is_action('set')) {
    $r = $wpdb->query($wpdb->prepare("update " . NEWSLETTER_USERS_TABLE . " set list_" . ((int) $controls->data['list']) . "=1 where id in (select distinct user_id from " . NEWSLETTER_STATS_TABLE . " s where s.url=%s and s.email_id=%d)", $controls->data['url'], $email->id));
    $controls->messages = '<strong>Added ' . $r . ' subscribers to list ' . ((int) $controls->data['list']) . '</strong><br>(number could not match the total since subscribers could have been removed after the newsletter has been sent or alredy in that list)';
}
?>
<link rel="stylesheet" href="<?php echo plugins_url('newsletter-reports') ?>/admin/style.css" type="text/css">

<div class="wrap" id="tnp-wrap">

    <?php include NEWSLETTER_ADMIN_HEADER ?>

    <?php include __DIR__ . '/view-heading.php' ?>

    <div id="tnp-body">
        <?php $controls->show(); ?>

        <?php
        $urls = $wpdb->get_results("select url, count(distinct user_id) as number from " . NEWSLETTER_STATS_TABLE . " where url<>'' and email_id=" . ( (int) $email->id ) . " group by url order by number desc");
        $total = $wpdb->get_var("select count(distinct user_id) from " . NEWSLETTER_STATS_TABLE . " where url<>'' and email_id=" . ( (int) $email->id ));
        ?>

        <?php if (empty($urls)) : ?>

            <p>No clicks by now.</p>

        <?php else: ?>
            <table class="widefat">
                <colgroup>
                    <col class="w-80">
                    <col class="w-10">
                    <col class="w-10">
                </colgroup>
                <thead>
                    <tr class="text-left">
                        <th>Clicked URLs</th>
                        <th>Clicks</th>
                        <th>%</th>
                        <th>Who clicked...</th>
                    </tr>
                </thead>
                <tbody>

                    <?php for ($i = 0; $i < count($urls); $i++) : ?>
                        <tr>
                            <td>
                                <a href="<?php echo esc_attr($urls[$i]->url) ?>" target="_blank">
                                    <?php echo esc_html($urls[$i]->url) ?>
                                </a>
                            </td>
                            <td><?php echo esc_html($urls[$i]->number) ?></td>
                            <td>
                                <?php echo esc_html(NewsletterModule::percent($urls[$i]->number, $total)); ?>
                            </td>
                            <td>
                                <form action="" method="post">
                                    <?php $controls->init() ?>
                                    <?php $controls->data['url'] = $urls[$i]->url; ?>
                                    <?php $controls->hidden('url') ?>
                                    <?php $controls->lists_select() ?>
                                    <?php $controls->btn('set', 'Add to this list', ['secondary' => true]) ?>
                                </form>
                            </td>
                        </tr>
                    <?php endfor; ?>

                </tbody>
            </table>

            <p>
                Unique clicks and percentage of subscribers who clicked the specific link.
            </p>
        <?php endif; ?>

    </div>
</div>


