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
        $options = $this->get_options($current_language);
        $options = array_merge($options, $controls->data);
        $this->save_options($options, $current_language);
        $controls->add_toast_saved();
    }
}

$posts = get_posts(['posts_per_page' => 1]);
$last_post_url = $posts ? get_the_permalink($posts[0]) : null;
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
                <?php if ($last_post_url) { ?>
                    <a href="<?php echo esc_attr($last_post_url) ?>?newsletter_leads_inject=1#newsletter-leads-bottom" target="test">See on your last post</a>.
                <?php } else { ?>
                    No public posts on your site to show a preview
                <?php } ?>
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
                                <th>Enabled</th>
                                <td>
                                    <?php $controls->yesno('inject_bottom_enabled'); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Categories to exclude</th>
                                <td>
                                    <?php $controls->categories_group('inject_exclude_categories'); ?>
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
                                <th>Field labels</th>
                                <td>
                                    <?php $controls->showhide('inject_labels'); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Palette</th>
                                <td>
                                    <input type="radio" name="options[inject_bottom_color]" value="default" <?php echo ($controls->data['inject_bottom_color'] == 'default') ? 'checked' : '' ?>> Default
                                    <br><br>
                                    <?php foreach (array_keys(NewsletterLeads::$leads_colors) AS $name) { ?>
                                        <span class="tnp-option-color <?php echo $name ?>">
                                            <input type="radio" name="options[inject_bottom_color]" id="popup-<?php echo $name ?>"
                                                   value="<?php echo $name ?>" <?php if (isset($controls->data['inject_bottom_color']) && $controls->data['inject_bottom_color'] == $name) { ?>checked<?php } ?>>
                                            <label for="popup-<?php echo $name ?>"><?php echo ucfirst($name) ?></label>
                                        </span>
                                    <?php } ?>
                                </td>
                            </tr>

                            <tr>
                                <th>Custom colors</th>
                                <td>
                                    <input type="radio" name="options[inject_bottom_color]" value="custom" <?php echo ($controls->data['inject_bottom_color'] == 'custom') ? 'checked' : '' ?>>
                                    Custom
                                    <br><br>
                                    <?php $controls->color('inject_bottom_color_1'); ?> Background
                                    &nbsp;&nbsp;&nbsp;
                                    <?php $controls->color('inject_bottom_color_2'); ?> Button
                                    &nbsp;&nbsp;&nbsp;
                                    <?php $controls->color('inject_bottom_color_3'); ?> Font
                                </td>
                            </tr>
                            <tr>
                                <th>Background image</th>
                                <td>
                                    <?php $controls->media('inject_bottom_background'); ?>
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
                                <?php $controls->wp_editor('inject_bottom_pre', ['editor_height' => 150], ['body_background' => '#ccc']); ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Post Form Text</th>
                            <td>
                                <?php $controls->wp_editor('inject_bottom_post', ['editor_height' => 150], ['body_background' => '#ccc']); ?>
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
