<?php
$p = sanitize_key($_GET['page'] ?? '');
?>
<ul class="tnp-nav">
    <li class="<?php echo $p === 'newsletter_reports_view' ? 'active' : '' ?>"><a href="?page=newsletter_reports_view&id=<?php echo rawurlencode($email->id); ?>"><?php esc_html_e('Overview', 'newsletter') ?></a></li>
    <li class="<?php echo $p === 'newsletter_reports_geo' ? 'active' : '' ?>"><a href="?page=newsletter_reports_geo&id=<?php echo rawurlencode($email->id) ?>"><?php esc_html_e('Geo', 'newsletter') ?></a></li>
    <li class="<?php echo $p === 'newsletter_reports_urls' ? 'active' : '' ?>"><a href="?page=newsletter_reports_urls&id=<?php echo rawurlencode($email->id) ?>"><?php esc_html_e('Links', 'newsletter') ?></a></li>
    <li class="<?php echo $p === 'newsletter_reports_retarget' ? 'active' : '' ?>"><a href="?page=newsletter_reports_retarget&id=<?php echo rawurlencode($email->id) ?>"><?php esc_html_e('Retarget', 'newsletter') ?></a></li>
    <li class="<?php echo $p === 'newsletter_reports_users' ? 'active' : '' ?>"><a href="?page=newsletter_reports_users&id=<?php echo rawurlencode($email->id) ?>"><?php esc_html_e('Subscribers', 'newsletter') ?></a></li>
    <?php if (NEWSLETTER_DEBUG) { ?>
        <li class="<?php echo $p === 'newsletter_reports_ip' ? 'active' : '' ?>"><a href="?page=newsletter_reports_ip&id=<?php echo rawurlencode($email->id) ?>"><?php esc_html_e('IP', 'newsletter') ?></a></li>
        <li><a href="?page=newsletter_statistics_view&id=<?php echo rawurlencode($email->id) ?>"><?php esc_html_e('Basic', 'newsletter') ?></a></li>
    <?php } ?>
</ul>
<?php
unset($p);
?>