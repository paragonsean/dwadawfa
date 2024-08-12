<?php

/*
 * Name: Buttons
 * Section: content
 * Description: Call to action buttons
 */

$max_buttons = 3;

$default_options = [
    'block_background' => '',
    'block_padding_top' => 20,
    'block_padding_bottom' => 20,
    'button_width' => '180',
    'buttons_number' => 1,
    'schema' => '',
];

for ($i = 1; $i <= $max_buttons; $i++) {
    $default_options["button${i}_label"] = "Button $i";
    $default_options["button${i}_url"] = home_url();

    $default_options["button${i}_background"] = "";

    $default_options["button${i}_font_family"] = "";
    $default_options["button${i}_font_size"] = "";
    $default_options["button${i}_font_weight"] = "";
    $default_options["button${i}_font_color"] = "";
    $default_options["list${i}"] = "";
}

$options = array_merge($default_options, $options);

if (!empty($options['schema'])) {
    if ($options['schema'] === 'dark') {
        $options['block_background'] = '#000000';

        for ($i = 1; $i <= $max_buttons; $i++) {
            $options["button${i}_font_color"] = '#ffffff';
            $options["button${i}_background"] = '#96969C';
        }
    }

    if ($options['schema'] === 'bright') {
        $options['block_background'] = '#ffffff';

        for ($i = 1; $i <= $max_buttons; $i++) {
            $options["button${i}_font_color"] = '#ffffff';
            $options["button${i}_background"] = '#256F9C';
        }
    }
}

$button_options = $options;

for ($i = 1; $i <= $options['buttons_number']; $i++) {

    $button_options["button${i}_font_family"] = empty($options["button${i}_font_family"]) ? $global_button_font_family : $options["button${i}_font_family"];
    $button_options["button${i}_font_size"] = empty($options["button${i}_font_size"]) ? $global_button_font_size : $options["button${i}_font_size"];
    $button_options["button${i}_font_weight"] = empty($options["button${i}_font_weight"]) ? $global_button_font_weight : $options["button${i}_font_weight"];
    $button_options["button${i}_font_color"] = empty($options["button${i}_font_color"]) ? $global_button_font_color : $options["button${i}_font_color"];

    $button_options["button${i}_background"] = empty($options["button${i}_background"]) ? $global_button_background_color : $options["button${i}_background"];

    $button_options["button${i}_width"] = $options['button_width'];

    if (method_exists('NewsletterReports', 'build_lists_change_url')) {
        $lists = [];
        if (!empty($button_options['list' . $i])) {
            $lists[$button_options['list' . $i]] = 1;
        } 
        if (!empty($button_options['unlist' . $i])) {
            $lists[$button_options['unlist' . $i]] = 0;
        }
        if ($lists) {
            $button_options["button${i}_url"] = NewsletterReports::build_lists_change_url($button_options["button${i}_url"], $lists);
        }
    }
}

$content_width = $composer['width'] - $options['block_padding_left'] - $options['block_padding_right'];

$items = [];
for ($i = 1; $i <= $options['buttons_number']; $i++) {
    $items[] = TNP_Composer::button($button_options, 'button' . $i);
}
echo TNP_Composer::grid($items, ['width' => $content_width, 'columns' => count($items)]);

