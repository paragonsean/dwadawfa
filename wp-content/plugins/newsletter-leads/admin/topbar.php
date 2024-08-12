<?php
/* @var $this NewsletterLeads */

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();

$newsletter = Newsletter::instance();

$current_language = $this->get_current_language();

$is_all_languages = $this->is_all_languages();

if (!$controls->is_action()) {
    $controls->data = $this->get_options($current_language);
} else {

    if ($controls->is_action('save')) {

        $controls->data = wp_kses_post_deep($controls->data);

        if ($is_all_languages) {
            if (!is_numeric($controls->data['width'])) {
                $controls->data['width'] = 600;
            }
            if (!is_numeric($controls->data['height'])) {
                $controls->data['height'] = 500;
            }
            if (!is_numeric($controls->data['days'])) {
                $controls->data['days'] = 365;
            }
            if (!is_numeric($controls->data['delay'])) {
                $controls->data['delay'] = 2;
            }
        }
        $options = $this->get_options($current_language);
        $options = array_merge($options, $controls->data);
        $this->save_options($options, $current_language);
        $controls->add_toast_saved();
    }
}
?>

<style>
<?php include __DIR__ . '/assets/admin.css'; ?>
</style>

<div class="wrap" id="tnp-wrap">
    <?php include NEWSLETTER_ADMIN_HEADER; ?>
    <div id="tnp-heading">

        <h2>Leads</h2>
        <?php include __DIR__ . '/nav.php'; ?>

    </div>

    <div id="tnp-body">
        <?php $controls->show(); ?>
        <form action="" method="post">
            <?php $controls->init(); ?>

            <p>
                <a href="<?php echo esc_attr(home_url()); ?>?newsletter_leads_topbar=1" target="home">Preview</a>
            </p>

            <div id="tabs">
                <ul>
                    <li><a href="#tabs-settings">Settings</a></li>
                    <li><a href="#tabs-layout">Layout</a></li>
                    <li><a href="#tabs-texts">Texts</a></li>
                </ul>

                <div id="tabs-settings">
                    <?php $controls->language_notice(); ?>
                    <?php if ($is_all_languages) { ?>
                        <table class="form-table">

                            <tr>
                                <th><?php esc_html_e('Enabled', 'newsletter'); ?></th>
                                <td>
                                    <?php $controls->yesno('bar-enabled'); ?>
                                </td>
                            </tr>

                            <tr>
                                <th>List</th>
                                <td>
                                    <?php $controls->public_lists_select('bar_list', 'None') ?>
                                    <p class="description">
                                        Only public lists are available
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="tabs-layout">

                        <?php $controls->language_notice(); ?>
                        <table class="form-table">

                            <tr>
                                <th>Show on</th>
                                <td>
                                    <?php $controls->select('position', array('top' => 'Page top', 'bottom' => 'Page bottom')); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Disable the privacy checkbox</th>
                                <td>
                                    <?php $controls->checkbox2('bar_field_privacy'); ?>
                                </td>
                            </tr>

                            <tr>
                                <th>Palette</th>
                                <td>

                                    <?php foreach (array_keys(NewsletterLeads::$leads_colors) AS $name) { ?>
                                        <span class="tnp-option-color <?php echo $name ?>">
                                            <input type="radio" name="options[theme_bar_color]" id="popup-<?php echo $name ?>"
                                                   value="<?php echo $name ?>" <?php if (isset($controls->data['theme_bar_color']) && $controls->data['theme_bar_color'] == $name) { ?>checked<?php } ?>>
                                            <label for="popup-<?php echo $name ?>"><?php echo ucfirst($name) ?></label>
                                        </span>
                                    <?php } ?>
                                </td>
                            </tr>

                            <tr>
                                <th>Custom colors</th>
                                <td>

                                    <input type="radio" name="options[theme_bar_color]" id="bar-custom" value="custom" <?php echo ($controls->data['theme_bar_color'] == 'custom') ? 'checked' : '' ?>>
                                    Custom

                                    <br><br>
                                    <?php $controls->color('theme_bar_color_1'); ?> Background
                                    &nbsp;&nbsp;&nbsp;
                                    <?php $controls->color('theme_bar_color_2'); ?> Button
                                </td>
                            </tr>

                        </table>
                    <?php } else { ?>
                        <?php $controls->switch_to_all_languages_notice(); ?>
                    <?php } ?>
                </div>
                <div id="tabs-texts">
                    <?php $controls->language_notice(); ?>
                    <table class="form-table">

                        <tr>
                            <th>Button</th>
                            <td>
                                <?php $controls->text('bar_subscribe_label', 70); ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Email placeholder</th>
                            <td>
                                <?php $controls->text('bar_placeholder', 70); ?>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
            <p>
                <?php $controls->button_save(); ?>
            </p>
        </form>
    </div>
</div>
