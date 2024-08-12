<?php
/* @var $this NewsletterArchive */
require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();

if (!$controls->is_action()) {
    $controls->data = $this->options;
} else {
    if ($controls->is_action('save')) {
        $this->save_options($controls->data);
        $controls->add_toast_saved();
    }
}
?>

<div class="wrap" id="tnp-wrap">
    <?php include NEWSLETTER_ADMIN_HEADER; ?>
    <div id="tnp-heading">
        <h2>Newsletter Archive</h2>
    </div>

    <div id="tnp-body">
        <?php $controls->show(); ?>

        <p>
            Create newsletter archive pages for your campaigns or automated newsletters.<br>
            Please <a href="https://www.thenewsletterplugin.com/documentation/addons/extended-features/archive-extension/" target="_blank">refer
                the official page</a> to know how to use the shortcode.
        </p>

        <form action="" method="post">
            <?php $controls->init(); ?>

            <table class="form-table">
                <tr valign="top">
                    <th>Show newsletter date?</th>
                    <td>
                        <?php $controls->checkbox('date'); ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th>Showing the newsletter</th>
                    <td>
                        <?php $controls->select('show', ['' => 'Embedded the same page', 'blank' => 'In a new browser page', 'self' => 'In the same browser page']); ?>
                        <p class="description">
                            Some page biulder or some page filters do not allow to show the newsletter in the same page: use an alternative option.
                        </p>
                    </td>
                </tr>
            </table>

            <p>
                <?php $controls->button_save(); ?>
            </p>
        </form>
    </div>
    <?php include NEWSLETTER_ADMIN_FOOTER; ?>
</div>