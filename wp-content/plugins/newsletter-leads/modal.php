<?php
header('Content-Type: text/html;charset=UTF-8');

$module = NewsletterLeads::$instance;

$newsletter = Newsletter::instance();

if (!empty($_GET['language'])) {
    $newsletter->switch_language($_GET['language']);
}

$current_language = $newsletter->get_current_language();

$options = $module->get_options($current_language);

$subscription = NewsletterSubscription::instance();

$list_ids = [];
if (isset($options['theme_lists_show'])) {
    $list_ids = $options['theme_lists_show'];
}

$placeholders = !empty($options['theme_placeholders']);
?>

<div id="tnp-modal-html" class="tnp-modal">

    <?php if (!empty($options['theme_title'])) { ?>
    <h1><?php echo $options['theme_title'] ?></h1>
    <?php } ?>

    <div class="tnp-popup-pre">
        <?php echo $options['theme_pre']; ?>
    </div>

    <div class="tnp-popup-main">
        <form action="#" method="post" onsubmit="tnp_leads_submit(this); return false;">

            <input type="hidden" name="nr" value="popup">

            <?php if (!empty($options['theme_list'])) { ?>
                <input name="nl[]" value="<?php echo esc_attr($options['theme_list']) ?>" type="hidden">
            <?php } ?>

            <?php if (!empty($options['theme_field_name'])) { ?>
                <div class="tnp-field tnp-field-name">
                    <?php if (!$placeholders) { ?>
                        <label><?php echo esc_html($subscription->get_form_text('name')) ?></label>
                    <?php } ?>
                    <input type="text" name="nn" class="tnp-name" <?php echo $subscription->get_form_option('name_rules') == 1 ? 'required' : '' ?>
                           placeholder="<?php echo esc_attr($placeholders ? $subscription->get_form_text('name') : ''); ?>">
                </div>
            <?php } ?>

            <?php if (!empty($options['theme_field_surname'])) { ?>
                <div class="tnp-field tnp-field-name">
                    <?php if (!$placeholders) { ?>
                    <label><?php echo esc_html($subscription->get_form_text('surname')) ?></label>
                    <?php } ?>
                    <input type="text" name="ns" class="tnp-name" <?php echo $subscription->get_form_option('surname_rules') == 1 ? 'required' : '' ?>
                           placeholder="<?php echo esc_attr($placeholders ? $subscription->get_form_text('surname') : ''); ?>">
                </div>
            <?php } ?>

            <div class="tnp-field tnp-field-email">
                <?php if (!$placeholders) { ?>
                <label><?php echo esc_html($subscription->get_form_text('email')) ?></label>
                <?php } ?>
                <input type="email" name="ne" class="tnp-email" type="email" required
                       placeholder="<?php echo esc_attr($placeholders ? $subscription->get_form_text('email') : ''); ?>">
            </div>


            <?php
            if (!empty($list_ids)) {
                $buffer = '';
                $idx = 1;
                foreach ($list_ids as $list_id) {
                    $list = $subscription->get_list($list_id);
                    if ($list->is_private())
                        continue;
                    $idx++;
                    $buffer .= '<div class="tnp-field tnp-field-checkbox tnp-field-list"><label for="nl' . $idx . '">';
                    $buffer .= '<input type="checkbox" id="nl' . $idx . '" name="nl[]" value="' . esc_attr($list->id) . '"';
                    $buffer .= '>&nbsp;' . esc_html($list->name) . '</label>';
                    $buffer .= "</div>\n";
                }
                echo $buffer;
            }
            ?>

            <?php
            if (empty($options['theme_field_privacy'])) {
                echo $subscription->get_privacy_field('<div class="tnp-field tnp-privacy-field">', '</div>');
            }
            ?>

            <div class="tnp-field tnp-field-submit">
                <input type="submit" value="<?php echo esc_attr($options['theme_subscribe_label']) ?>" class="tnp-submit">
            </div>
        </form>

        <div class="tnp-popup-post"><?php echo $options['theme_post']; ?></div>
    </div>

</div>

