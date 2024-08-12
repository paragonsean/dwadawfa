<div id="tnp-heading">
    <h2><?php echo esc_html($email->subject) ?> <span><?php echo esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), $email->send_on)) ?></span></h2>
    <?php include __DIR__ . '/view-nav.php' ?>
</div>