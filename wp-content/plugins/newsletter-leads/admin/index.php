<?php
/* @var $this NewsletterLeads */

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();

$newsletter = Newsletter::instance();

$current_language = $this->get_current_language();

$is_all_languages = $this->is_all_languages();

if (!$controls->is_action()) {
    $controls->data = $this->get_options($current_language);

    if (!empty($controls->data['theme_title'])) {
        $controls->data['theme_pre'] = '<h1><span style="color: #fff">' . $controls->data['theme_title'] . '</span></h1>';
    }
} else {

    if ($controls->is_action('save')) {



        $controls->data = wp_kses_post_deep($controls->data);

        if ($is_all_languages) {
            if (!is_numeric($controls->data['width'])) {
                $controls->data['width'] = 600;
            }
//            if (!is_numeric($controls->data['height'])) {
//                $controls->data['height'] = 500;
//            }
            if (!is_numeric($controls->data['days'])) {
                $controls->data['days'] = 365;
            }
            if (!is_numeric($controls->data['delay'])) {
                $controls->data['delay'] = 2;
            }
        }

        $options = $this->get_options($current_language);
        $options = array_merge($options, $controls->data);
        unset($options['theme_title']);
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
                <a href="<?php echo esc_attr(home_url()); ?>?newsletter_leads_popup=1" target="home">Preview</a>
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
                        <input type="hidden" name="options[theme]" value="default">
                        <table class="form-table">

                            <tr>
                                <th>Enabled</th>
                                <td>
                                    <?php $controls->yesno('popup-enabled'); ?>
                                </td>
                            </tr>

                            <tr>
                                <th>Show on</th>
                                <td>
                                    <?php $controls->select('count', array('0' => 'first', '1' => 'second', '2' => 'third', '3' => 'fourth')); ?>
                                    page view
                                </td>
                            </tr>

                            <tr>
                                <th>Show after</th>
                                <td>
                                    <?php $controls->text('delay', 6); ?> seconds
                                    <p class="description">
                                        How many seconds have to pass, after the page is fully loaded, before the pop up is shown.
                                        Decimal values allowed (for example 0.5 for half a second).
                                    </p>
                                </td>
                            </tr>

                            <tr>
                                <th>Restart counting after</th>
                                <td>
                                    <?php $controls->text('days', 5); ?> days
                                    <p class="description">
                                        The number of days the system should retain memory of shown pop up to a user before
                                        restart the process.
                                    </p>
                                </td>
                            </tr>

                            <tr>
                                <th>Lists to show</th>
                                <td>
                                    <?php $controls->lists_public('theme_lists_show') ?>
                                </td>
                            </tr>

                            <tr>
                                <th>Lists to add automatically</th>
                                <td>
                                    <?php $controls->public_lists_select('theme_list', 'None') ?>
                                    <p class="description">
                                        Only public lists are available
                                    </p>
                                </td>
                            </tr>

                        </table>
                    <?php } ?>
                </div>


                <div id="tabs-layout">
                    <?php $controls->language_notice(); ?>

                    <?php if ($is_all_languages) { ?>
                        <table class="form-table">
                            <tr>
                                <th>Size</th>
                                <td>
                                    <?php $controls->text('width', 5); ?> x <?php $controls->text('height', ['size' => 5, 'placeholder' => 'auto']); ?> pixels
                                </td>
                            </tr>
                            <tr>
                                <th>Show the first name field</th>
                                <td>
                                    <?php $controls->checkbox2('theme_field_name'); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Show the last name field</th>
                                <td>
                                    <?php $controls->checkbox2('theme_field_surname'); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Disable the privacy checkbox</th>
                                <td>
                                    <?php $controls->checkbox2('theme_field_privacy'); ?>
                                </td>
                            </tr>

                            <tr>
                                <th>Show labels inside the fields</th>
                                <td>
                                    <?php $controls->checkbox2('theme_placeholders'); ?>
                                </td>
                            </tr>

                            <tr>
                                <th>Palette</th>
                                <td>

                                    <?php foreach (array_keys(NewsletterLeads::$leads_colors) AS $name) { ?>
                                        <span class="tnp-option-color <?php echo $name ?>">
                                            <input type="radio" name="options[theme_popup_color]" id="popup-<?php echo $name ?>"
                                                   value="<?php echo $name ?>" <?php if (isset($controls->data['theme_popup_color']) && $controls->data['theme_popup_color'] == $name) { ?>checked<?php } ?>>
                                            <label for="popup-<?php echo $name ?>"><?php echo ucfirst($name) ?></label>
                                        </span>
                                    <?php } ?>
                                </td>
                            </tr>

                            <tr>
                                <th>Custom colors</th>
                                <td>
                                    <input type="radio" name="options[theme_popup_color]" id="popup-custom" value="custom" <?php echo ($controls->data['theme_popup_color'] == 'custom') ? 'checked' : '' ?>>
                                    Custom
                                    <br><br>
                                    <?php $controls->color('theme_popup_color_1'); ?> Background
                                    &nbsp;&nbsp;&nbsp;
                                    <?php $controls->color('theme_popup_color_2'); ?> Button
                                    &nbsp;&nbsp;&nbsp;
                                    <?php $controls->color('theme_popup_color_3'); ?> Font
                                </td>
                            </tr>
                            <tr>
                                <th>Background image</th>
                                <td>
                                    <?php $controls->media('theme_background'); ?>
                                </td>
                            </tr>
                        </table>

                    <?php } ?>
                </div>


                <div id="tabs-texts">

                    <?php $controls->language_notice(); ?>

                    <table class="form-table">

                        <tr>
                            <th>Pre Form Text</th>
                            <td>
                                <?php $controls->wp_editor('theme_pre', ['editor_height' => 150], ['body_background' => '#ccc']); ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Post Form Text</th>
                            <td>
                                <?php $controls->wp_editor('theme_post', ['editor_height' => 150], ['body_background' => '#ccc']); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Button</th>
                            <td>
                                <?php $controls->text('theme_subscribe_label', 70); ?>
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
