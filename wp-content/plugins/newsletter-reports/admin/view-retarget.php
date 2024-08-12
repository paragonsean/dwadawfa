<?php
/* @var $this NewsletterReports */

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();

$email = Newsletter::instance()->get_email((int) $_GET['id'] ?? 0);
if (!$email) {
    die('Email not found');
}

if ($controls->is_action('open')) {
    $r = $wpdb->query($wpdb->prepare("update " . NEWSLETTER_USERS_TABLE . " set list_" . ((int) $controls->data['list']) . "=1 where id in (select distinct user_id from " . NEWSLETTER_STATS_TABLE . " where email_id=%d)", $email->id));
    $controls->messages = '<strong>Added ' . $r . ' subscribers to list ' . ((int) $controls->data['list']) . '</strong><br>(number could not match the total since subscribers could have been removed after the newsletter has been sent or alredy in that list)';
}

if ($controls->is_action('click')) {
    $r = $wpdb->query($wpdb->prepare("update " . NEWSLETTER_USERS_TABLE . " set list_" . ((int) $controls->data['list']) . "=1 where id in (select distinct user_id from " . NEWSLETTER_SENT_TABLE . " where open=2 and email_id=%d)", $email->id));
    $controls->messages = '<strong>Added ' . $r . ' subscribers to list ' . ((int) $controls->data['list']) . '</strong><br>(number could not match the total since subscribers could have been removed after the newsletter has been sent or alredy in that list)';
}

if ($controls->is_action('nothing')) {
    $r = $wpdb->query($wpdb->prepare("update " . NEWSLETTER_USERS_TABLE . " set list_" . ((int) $controls->data['list']) . "=1 where id in (select distinct user_id from " . NEWSLETTER_SENT_TABLE . " where open=0 and email_id=%d)", $email->id));
    $controls->messages = '<strong>Added ' . $r . ' subscribers to list ' . ((int) $controls->data['list']) . '</strong><br>(number could not match the total since subscribers could have been removed after the newsletter has been sent or alredy in that list)';
}

if ($controls->is_action('error')) {
    $r = $wpdb->query($wpdb->prepare("update " . NEWSLETTER_USERS_TABLE . " set list_" . ((int) $controls->data['list']) . "=1 where id in (select distinct user_id from " . NEWSLETTER_SENT_TABLE . " s where s.status>0 and s.email_id=%d)", $email->id));
    $controls->messages = '<strong>Added ' . $r . ' subscribers to list ' . ((int) $controls->data['list']) . '</strong><br>(number could not match the total since subscribers could have been removed after the newsletter has been sent or alredy in that list)';
}
?>

<link rel="stylesheet" href="<?php echo plugins_url('newsletter-reports') ?>/admin/style.css" type="text/css">

<div class="wrap" id="tnp-wrap">
    <?php include NEWSLETTER_ADMIN_HEADER; ?>
    <?php include __DIR__ . '/view-heading.php' ?>

    <div id="tnp-body" style="min-width: 500px">
        <?php $controls->show(); ?>

        <table class="widefat" style="width: auto">
            <thead>
                <tr>
                    <th>Subscribers</th>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>

            <tr>
                <th>Who opened the newsletter</th>
                <td>
                    <?php echo (int)$wpdb->get_var($wpdb->prepare("select count(*) from " . NEWSLETTER_SENT_TABLE . " where open>0 and email_id=%d", $email->id)) ?>
                </td>
                <td>
                    <form action="" method="post">
                        <?php $controls->init() ?>
                        <?php $controls->lists_select() ?>
                        <?php $controls->button_primary('open', 'Add to this list') ?>
                    </form>

                </td>
            </tr>
            <tr>
                <th>Who clicked a link</th>
                <td>
                    <?php echo (int)$wpdb->get_var($wpdb->prepare("select count(*) from " . NEWSLETTER_SENT_TABLE . " where open=2 and email_id=%d", $email->id)) ?>
                </td>
                <td>
                    <form action="" method="post">
                        <?php $controls->init() ?>
                        <?php $controls->lists_select() ?>
                        <?php $controls->button_primary('click', 'Add to this list') ?>
                    </form>

                </td>
            </tr>

            <tr>
                <th>Who did nothing</th>
                <td>
                    <?php echo (int)$wpdb->get_var($wpdb->prepare("select count(*) from " . NEWSLETTER_SENT_TABLE . " where open=0 and email_id=%d", $email->id)) ?>
                </td>
                <td>
                    <form action="" method="post">
                        <?php $controls->init() ?>
                        <?php $controls->lists_select() ?>
                        <?php $controls->button_primary('nothing', 'Add to this list') ?>
                    </form>

                </td>
            </tr>

            <tr>
                <th>With delivery error</th>
                <td>
                    <?php echo (int)$wpdb->get_var($wpdb->prepare("select count(*) from " . NEWSLETTER_SENT_TABLE . " where status>0 and email_id=%d", $email->id)) ?>
                </td>
                <td>
                    <form action="" method="post">
                        <?php $controls->init() ?>
                        <?php $controls->lists_select() ?>
                        <?php $controls->button_primary('error', 'Add to this list') ?>
                    </form>

                </td>
            </tr>

        </table>
    </div>

    <?php include NEWSLETTER_ADMIN_FOOTER; ?>
</div>
