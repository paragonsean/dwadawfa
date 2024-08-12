<?php
if ($autoresponder->status) {
    $status_badge = '<span class="tnp-badge-green">' . esc_html__('Enabled', 'newsletter') . '</span>';
} else {
    $status_badge = '<span class="tnp-badge-orange">' . esc_html__('Disabled', 'newsletter') . '</span>';
}
$p = sanitize_key(wp_unslash($_GET['page']));
?>
<?php $controls->title_help('/addons/extended-features/autoresponder-extension/'); ?>
<h2><?php echo esc_html($autoresponder->name) ?> <?php echo $status_badge; ?></h2>
<ul class="tnp-nav">
    <li class="<?php echo $p === '' ? 'active' : '' ?>"><a href="?page=newsletter_autoresponder_index">&laquo;</a></li>
    <li class="<?php echo $p === 'newsletter_autoresponder_edit' ? 'active' : '' ?>"><a href="?page=newsletter_autoresponder_edit&id=<?php echo rawurldecode($autoresponder->id); ?>"><?php esc_html_e('Settings', 'newsletter') ?></a></li>
    <?php if ($autoresponder->type == TNP_Autoresponder::TYPE_CLASSIC) { ?>
        <li class="<?php echo $p === 'newsletter_autoresponder_theme' ? 'active' : '' ?>"><a href="?page=newsletter_autoresponder_theme&id=<?php echo rawurldecode($autoresponder->id); ?>"><?php esc_html_e('Theme', 'newsletter') ?></a></li>
    <?php } ?>
    <li class="<?php echo $p === 'newsletter_autoresponder_messages' ? 'active' : '' ?>"><a href="?page=newsletter_autoresponder_messages&id=<?php echo rawurldecode($autoresponder->id); ?>"><?php esc_html_e('Emails', 'newsletter') ?></a></li>
    <li class="<?php echo $p === 'newsletter_autoresponder_users' ? 'active' : '' ?>"><a href="?page=newsletter_autoresponder_users&id=<?php echo rawurldecode($autoresponder->id); ?>"><?php esc_html_e('Subscribers', 'newsletter') ?></a></li>
    <li class="<?php echo $p === 'newsletter_autoresponder_statistics' ? 'active' : '' ?>"><a href="?page=newsletter_autoresponder_statistics&id=<?php echo rawurldecode($autoresponder->id); ?>"><?php esc_html_e('Statistics', 'newsletter') ?></a></li>
    <li class="<?php echo $p === 'newsletter_autoresponder_maintenance' ? 'active' : '' ?>"><a href="?page=newsletter_autoresponder_maintenance&id=<?php echo rawurldecode($autoresponder->id); ?>"><?php esc_html_e('Maintenance', 'newsletter') ?></a></li>
</ul>
