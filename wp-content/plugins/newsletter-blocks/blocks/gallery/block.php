<?php

/*
 * Name: Gallery
 * Section: content
 * Description: Extract an embed all the media from a post gallery
 *
 */

/* @var $options array */
/* @var $wpdb wpdb */

$default_options = array(
    'layout' => 2,
    'url' => home_url(),
    'responsive'=> 1,
    'columns' => 3,
    'block_padding_left' => 0,
    'block_padding_right' => 0,
    'block_padding_top' => 20,
    'block_padding_bottom' => 20,
    'block_background' => ''
);

$options = array_merge($default_options, $options);

$layout = $options['layout'];
$size = $layout == 1 ? 'thumbnail' : 'medium';

$images = array();
for ($i = 1; $i <= 9; $i++) {
    if (empty($options['image_' . $i]['id'])) {
        continue;
    }

    $media = tnp_resize($options['image_' . $i]['id'], $size);
    if (!$media) {
        continue;
    }

    if (!empty($options['image_' . $i . '_alt'])) {
        $media->alt = $options['image_' . $i . '_alt'];
    } else {
        $alt_texts = array('picture', 'image', 'pic', 'photo');
        $media->alt = $alt_texts[array_rand($alt_texts)];
    }
    $media->link = !empty($options['url_' . $i]) ? $options['url_' . $i] : $options['url'];

    $images[] = $media;
}

if ($images) {
    $items = [];

    foreach ($images as $media) {
        $items[] = TNP_Composer::image($media);
    }

    echo TNP_Composer::grid($items, ['columns' => $options['columns'], 'width' => $composer['content_width'], 'responsive' => !empty($options['responsive'])]);
} else {
    echo '<p>Add some images to your gallery</p>';
}
