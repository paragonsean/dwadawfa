<?php
/*
 * Name: Columns
 * Section: content
 * Description: Two or three columns
 *
 */

/* @var $options array */
/* @var $wpdb wpdb */

$default_options = array(
    'image_1' => '',
    'text_1' => '',
    'title_1' => '',
    'url_1' => '',
    'image_2' => '',
    'text_2' => '',
    'title_2' => '',
    'url_2' => '',
    'image_3' => '',
    'text_3' => '',
    'title_3' => '',
    'url_3' => '',
    'order' => '',
    'responsive' => '1',
    'font_family' => '',
    'font_size' => '',
    'font_color' => '',
    'font_weight' => '',
    'block_padding_left' => 0,
    'block_padding_right' => 0,
    'block_padding_top' => 15,
    'block_padding_bottom' => 15,
    'block_background' => ''
);

$options = array_merge($default_options, $options);

$col_count = 2;
$column_class = 'mj-column-per-50';
$mso_width = 300;
$size = [250, 200, false];
if (!empty($options['text_3']) || !empty($options['image_3']['id'])) {
    $column_class = 'mj-column-per-33';
    $mso_width = 200;
    $col_count = 3;
    $size = [170, 170, false];
}

$image_1 = '';
if (!empty($options['image_1']['id'])) {
    $image_1 = tnp_resize_2x($options['image_1']['id'], $size);
}

$image_2 = '';
if (!empty($options['image_2']['id'])) {
    $image_2 = tnp_resize_2x($options['image_2']['id'], $size);
}

$image_3 = '';
if (!empty($options['image_3']['id'])) {
    $image_3 = tnp_resize_2x($options['image_3']['id'], $size);
}

$url_1 = $options['url_1'];
$url_2 = $options['url_2'];
$url_3 = $options['url_3'];

$text_font = TNP_Composer::get_text_style($options, '', $composer, ['scale'=>0.9]);
$title_font = TNP_Composer::get_title_style($options, 'title', $composer, ['scale'=>0.8]);

$responsive = !empty($options['responsive']);

?>
<style>
    .text {
        <?php $text_font->echo_css() ?>;
        text-decoration: none;
        margin-top: 15px;
        line-height: 1.3;
    }
    .title {
        <?php $title_font->echo_css() ?>;
        text-decoration: none;
        margin-top: 15px;
        line-height: normal;
    }
</style>

<?php
$items = [];

for ($i = 1; $i <= $col_count; $i++) {
    $url = $options['url_' . $i];
    $image = '';
    if (!empty($options['image_' . $i]['id'])) {
        $image = tnp_resize_2x($options['image_' . $i]['id'], $size);
    }
    ob_start();
    ?>
        <?php if (!empty($url)) { ?>
        <a href="<?php echo $url ?>" inline-class="link">
        <?php } ?>
        <?php if (!empty($image)) { ?>
            <?php echo TNP_Composer::image($image) ?>
        <?php } ?>
            
            <?php if (!empty($options['title_' . $i])) { ?>
            <div inline-class="title"><?php echo $options['title_' . $i] ?></div>
            <?php } ?>
            
        <div inline-class="text"><?php echo $options['text_' . $i] ?></div>
        <?php if (!empty($url)) { ?>
            </a>
        <?php } ?>
    <?php
    $items[] = ob_get_clean();
}

echo TNP_Composer::grid($items, ['columns' => $col_count, 'responsive'=>$responsive, 'width' => $composer['content_width']]);
