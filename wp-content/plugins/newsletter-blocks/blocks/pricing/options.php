<?php
/* @var $options array contains all the options the current block we're ediging contains */
/* @var $controls NewsletterControls */
/* @var $fields NewsletterFields */
?>

<p>Be aware: experimental.</p>

<?php //$fields->select('responsive', 'Responsive', ['1' => 'Responsive', '0' => 'Not responsive']) ?>
<?php $fields->select('columns', '', [1 => '1 column', 2 => '2 columns', 3 => '3 columns'], ['reload' => true]); ?>
<?php
$fields->font('text_font', __('Text font', 'newsletter'), [
    'family_default' => true,
    'size_default' => true,
    'weight_default' => true
])
?>
<?php
$fields->font('features_font', __('Features font', 'newsletter'), [
    'family_default' => true,
    'size_default' => true,
    'weight_default' => true
])
?>
<?php $fields->separator() ?>

<?php for ($i = 1; $i <= 3; $i++) { ?>
    <?php $display_style = $i <= $fields->controls->data['columns'] ? '' : 'display:none;'; ?>
    <div style="<?php echo $display_style; ?>">
        <?php $fields->section('Column ' . $i) ?>
        <?php $fields->text('title_' . $i, 'Title') ?>
        <?php
        $fields->font('title_' . $i . '_font', '', [
            'family_default' => true,
            'size_default' => true,
            'weight_default' => true
        ])
        ?>
        <?php $fields->text('text_' . $i, 'Text') ?>
        <?php
//        $fields->font('text_' . $i . '_font', '', [
//            'family_default' => true,
//            'size_default' => true,
//            'weight_default' => true
//        ])
        ?>
        <?php $fields->text('price_' . $i, 'Price') ?>
        <?php
        $fields->font('price_' . $i . '_font', '', [
            'family_default' => true,
            'size_default' => true,
            'weight_default' => true
        ])
        ?>
        <?php $fields->textarea('features_' . $i, 'Features') ?>
        <?php
//        $fields->font('features_' . $i . '_font', '', [
//            'family_default' => true,
//            'size_default' => true,
//            'weight_default' => true
//        ])
        ?>
        <?php $fields->button('button_' . $i, 'Button', [
    'family_default' => true,
    'size_default' => true,
    'weight_default' => true
]) ?>
        <?php $fields->color('background_' . $i, 'Background') ?>


        <?php $fields->separator() ?>
    </div>
<?php } ?>


<?php $fields->block_commons() ?>
