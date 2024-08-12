<?php
/* @var $fields NewsletterFields */

$fields->controls->data['schema'] = '';
$max_buttons = 3;
?>

<?php if (!method_exists('NewsletterReports', 'build_lists_change_url')) { ?>
    <p>List add/remove feature requires Reports Addon 4.5+ and Newsletter 7.9.2+</p>
<?php } ?>

<div class="tnp-field-row">
    <div class="tnp-field-col-3">
<?php $fields->select('schema', __('Schema', 'newsletter'), array('' => 'Custom', 'bright' => 'Bright', 'dark' => 'Dark'), ['after-rendering' => 'reload']) ?>
    </div>
    <div class="tnp-field-col-3">
        <?php $fields->select('buttons_number', __('Number of buttons'), [1 => '1', 2 => '2', 3 => '3'], ['reload' => true]); ?>
    </div>
    <div class="tnp-field-col-4">
        <?php $fields->size('button_width', __('Width', 'newsletter')) ?>
    </div>
    <div style="clear: both"></div>
</div>
    
    <?php $fields->separator() ?>

<?php for ($i = 1; $i <= $max_buttons; $i++) { ?>
    <?php $display_style = $i <= $fields->controls->data['buttons_number'] ? '' : 'display:none;'; ?>
    <div style="<?php echo $display_style; ?>">
        <?php
        $fields->button("button$i", "Button $i",
                [
                    'family_default' => true,
                    'size_default' => true,
                    'weight_default' => true
                ])
        ?>

        <?php if (NEWSLETTER_VERSION >= '7.9.2') { ?>
            <div class="tnp-field-row">
                <div class="tnp-field-col-2">
                    <?php $fields->lists_public('list' . $i, 'Add to', ['empty_label' => 'None']) ?>
                </div>
                <div class="tnp-field-col-2">
                    <?php $fields->lists_public('unlist' . $i, 'Remove from', ['empty_label' => 'None']) ?>
                </div>
                <div style="clear: both"></div>
            </div>

        <?php } ?>
        <?php $fields->separator() ?>
    </div>
<?php } ?>


<?php $fields->block_commons() ?>
