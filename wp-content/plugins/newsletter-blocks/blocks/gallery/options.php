<?php
/* @var $options array contains all the options the current block we're ediging contains */
/* @var $controls NewsletterControls */
/* @var $fields NewsletterFields */
?>
<style>
    .gallery-img {
        float: left;
        width: 210px;
        /* height: 220px; */
        overflow: hidden;
        margin: 5px;
        border: 2px solid #eee;
        padding: 5px;
        box-sizing: border-box;
        text-align: center;
    }
    .gallery-images {
        overflow: auto;
        height: 400px;
        background-color: #fff;
        padding: 10px;
        margin-top: 10px;
        border: 1px solid #ddd;
    }
</style>

<div class="tnp-field-row">
    <div class="tnp-field-col-3">
        <?php $fields->select('layout', 'Size', ['1' => 'Thumbnails', '2' => 'Medium']) ?>
    </div>
    <div class="tnp-field-col-3">
        <?php $fields->select('columns', 'Columns', ['2'=>'2', '3'=>'3']) ?>
    </div>
    <div class="tnp-field-col-3">
        <?php $fields->yesno('responsive', 'Responsive') ?>
    </div>
</div>

<?php $fields->url('url', 'Default URL') ?>

<div class="gallery-images">
    <?php for ($i = 1; $i <= 8; $i++) { ?>
        <div class="gallery-img">
            <?php $fields->media('image_' . $i, '', array('alt' => true)) ?>
            <?php $fields->url('url_' . $i) ?>
        </div>
    <?php } ?>
    <div style="clear: both"></div>
</div>

<?php $fields->block_commons() ?>
