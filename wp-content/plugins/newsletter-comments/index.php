<?php
/* @var $this NewsletterComments */

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();

if (!$controls->is_action()) {
    $controls->data = $this->options;
} else {
    if ($controls->is_action('save')) {
        $this->save_options($controls->data);
        $controls->data = $this->options;
        $controls->add_message_saved();
    }
}
?>

<div class="wrap" id="tnp-wrap">
    <?php include NEWSLETTER_ADMIN_HEADER ?>
    <div id="tnp-heading">
        <?php $controls->title_help('/comments-extension') ?>
        <h2>Subscribe on comment</h2>
    </div>
    <div id="tnp-body">
        <?php $controls->show(); ?>
        <form action="" method="post">
            <?php $controls->init(); ?>


            <table class="form-table">

                <tr>
                    <th>Status</th>
                    <td>
                        <?php $controls->enabled('enabled'); ?>
                    </td>
                </tr>
                <tr>
                    <th>Subscription checkbox label</th>
                    <td>
                        <?php $controls->text('label', 70); ?>
                        <p class="description">
                        </p>
                    </td>
                </tr>
                <tr>
                    <th>Subscription checkbox status</th>
                    <td>
                        <?php $controls->select('checked', array('0' => 'Unchecked', '1' => 'Checked')); ?>
                        <p class="description">
                        </p>
                    </td>
                </tr>
                <tr>
                    <th>Opt-in mode</th>
                    <td>
                        <?php $controls->select('optin', array('default' => 'Default', 'double' => 'Double', 'single' => 'Single')); ?>
                        <p class="description">
                            The default opt-in is the one in the general Newsletter subscription configuration.
                        </p>
                    </td>
                </tr>
                <tr>
                    <th>Welcome email</th>
                    <td>
                        <?php $controls->select('welcome_disable', array('0' => 'Enabled', '1' => 'Disabled')); ?>
                        <p class="description">
                            Works only with single opt-in (set as default in Newsletter or forced above).
                        </p>
                    </td>
                </tr>

                <tr>
                    <th>Lists</th>
                    <td>
                        <?php $controls->preferences_group('lists'); ?>
                        <p class="description">
                            You can add the subscriber to one or more lists.
                        </p>
                    </td>
                </tr>

            </table>

            <p>
                <?php $controls->button_save() ?>
            </p>
        </form>
    </div>
    <?php include NEWSLETTER_ADMIN_FOOTER ?>
</div>