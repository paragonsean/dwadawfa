<?php
/* @var $wpdb wpdb */
/* @var $this NewsletterEdd */

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();

if (!$controls->is_action()) {

    $controls->data = $this->options;
} else {
    // Product IDs from CSV to array

    $this->save_options($controls->data);
    for ($rule = 1; $rule <= 20; $rule++) {
        $product_ids = $controls->data['rule_product_' . $rule . '_id'];
        $product_ids = explode(',', $product_ids);
        $product_ids = array_map('trim', $product_ids);
        $controls->data['rule_product_' . $rule . '_id'] = $product_ids;
    }

    if ($controls->is_action('save')) {
        $controls->add_toast_saved();
    }
}

// Conversion of product IDs from array to CSV
for ($rule = 1; $rule <= 20; $rule++) {
    if (!isset($controls->data['rule_product_' . $rule . '_id'])) {
        continue;
    }
    if (!is_array($controls->data['rule_product_' . $rule . '_id'])) {
        continue;
    }

    $controls->data['rule_product_' . $rule . '_id'] = implode(',', $controls->data['rule_product_' . $rule . '_id']);
}

// recupero le categorie per le select
$all_categories = array();
$product_categories = get_terms($args = array(
    'taxonomy' => "download_category",
    'hide_empty' => false,
//        'parent'     => 0,
        ));

foreach ($product_categories as $cat) {
    $all_categories[$cat->term_id] = $cat->name;
}
?>

<div class="wrap" id="tnp-wrap">
    <?php include NEWSLETTER_ADMIN_HEADER ?>
    <div id="tnp-heading">
        <?php echo $controls->title_help("/addons/integrations/edd-extension/") ?>
        <h2>Easy Digital Downloads</h2>
    </div>

    <div id="tnp-body">
        <?php $controls->show(); ?>

        <form action="" method="post">
            <?php $controls->init(); ?>

            <div id="tabs">
                <ul>
                    <li><a href="#tabs-general"><?php _e('General', 'newsletter') ?></a></li>
                    <li><a href="#tabs-rules-product"><?php _e('Rules by download', 'newsletter') ?></a></li>
                    <li><a href="#tabs-rules-category"><?php _e('Rules by category', 'newsletter') ?></a></li>
                </ul>

                <div id="tabs-general">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th>Enabled</th>
                                <td>
                                    <?php $controls->yesno('enabled'); ?>
                                    <p class="description">
                                        When not enabled this addon stops interacting with EDD checkout.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th>Subscribe on checkout</th>
                                <td>
                                    <?php $controls->select('ask', array(0 => 'Force subscription', 1 => 'Show a checkbox')); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Subscription checkbox</th>
                                <td>
                                    <?php $controls->text('ask_text', 50, __('Subscribe to our newsletter', 'newsletter-edd')); ?>
                                    <?php $controls->select('checked', array("0" => "Unchecked", "1" => "Checked")); ?>
                                    <p class="description">
                                        <?php if (NewsletterEdd::$instance->is_multilanguage()): ?>
                                            Leave  empty and use your multilanguage plugin to translate it.
                                        <?php endif; ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th>Send users an email to confirm subscription?</th>
                                <td>
                                    <?php $controls->yesno('confirm'); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Add users to these lists</th>
                                <td><?php $controls->preferences() ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="tabs-rules-product">

                    <h3>When a customer purchase a download</h3>
                    <p>Multiple id can be specified comma separated. Only already subscribed customers will be processed.</p>
                    <table class="form-table">
                        <tbody>
                            <?php for ($i = 1; $i <= 20; $i++) { ?>
                                <tr>
                                    <th>Rule <?php echo $i ?></th>
                                    <td>
                                        Download IDs <?php $controls->text('rule_product_' . $i . '_id') ?>
                                        <?php $controls->select('rule_product_' . $i . '_action', array('' => 'add to list', 1 => 'remove from list')) ?>
                                        <?php $controls->preferences_select('rule_product_' . $i . '_list') ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div id="tabs-rules-category">

                    <h3>When a customer purchase a download in category</h3>
                    <p>Only already subscribed customers will be processed.</p>
                    <table class="form-table">
                        <tbody>
                            <?php for ($i = 1; $i <= 20; $i++) { ?>
                                <tr>
                                    <th>Rule <?php echo $i ?></th>
                                    <td>
                                        Categories <?php $controls->select2('rule_category_' . $i . '_id', $all_categories, null, true, "width: 500px") ?>
                                        <?php $controls->select('rule_category_' . $i . '_action', array('' => 'add to list', 1 => 'remove from list')) ?>
                                        <?php $controls->preferences_select('rule_category_' . $i . '_list') ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <p>
                    <?php $controls->button_save(); ?>
                </p>

        </form>


    </div>
    <?php include NEWSLETTER_ADMIN_FOOTER ?>
</div>
