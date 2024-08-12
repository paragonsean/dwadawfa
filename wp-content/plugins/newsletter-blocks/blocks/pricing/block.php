<?php
/*
 * Name: Pricing table
 * Section: content
 * Description: One, two, three price columns
 *
 */

/* @var $options array */
/* @var $wpdb wpdb */

$default_options = array(
    'columns' => 2,
    'text_1' => '',
    'title_1' => 'Silver',
    'features_1' => '',
    'url_1' => '',
    'text_2' => '',
    'title_2' => 'Gold',
    'features_2' => '',
    'url_2' => '',
    'image_3' => '',
    'text_3' => '',
    'title_3' => 'Platinum',
    'features_3' => '',
    'url_3' => '',
    'responsive' => '1',
    'height' => 300,
    'background_1' => '#eee',
    'background_2' => '#eee',
    'background_3' => '#eee',
    'title_font_family' => '',
    'title_font_size' => '',
    'title_font_color' => '',
    'title_font_weight' => '',
    'text_font_family' => '',
    'text_font_size' => '',
    'text_font_color' => '',
    'text_font_weight' => '',
    'features_font_family' => '',
    'features_font_size' => '',
    'features_font_color' => '',
    'features_font_weight' => '',
    'block_padding_left' => 0,
    'block_padding_right' => 0,
    'block_padding_top' => 15,
    'block_padding_bottom' => 15,
    'block_background' => ''
);

for ($i = 1; $i <= 3; $i++) {
    $default_options["text_${i}"] = "Optional short description...";
    $default_options["price_${i}"] = "100$";
    $default_options["features_${i}"] = "Feature 1\nFeature 2\nFeature 3";
    $default_options["title_${i}_font_weight"] = 'bold';
    $default_options["price_${i}_font_weight"] = 'bold';

    $default_options["button_${i}_label"] = "Get it";
}

$options = array_merge($default_options, $options);

$responsive = !empty($options['responsive']);
?>
<style>
<?php for ($i = 1; $i <= $options['columns']; $i++) { ?>
    <?php
    $text_font = TNP_Composer::get_text_style($options, 'text', $composer, ['scale' => 1]);
    $title_font = TNP_Composer::get_title_style($options, 'title_' . $i, $composer, ['scale' => 1]);
    $price_font = TNP_Composer::get_title_style($options, 'price_' . $i, $composer, ['scale' => 1.2]);
    $features_font = TNP_Composer::get_text_style($options, 'features', $composer, ['scale' => 0.9]);
    ?>
        .text<?php echo $i ?> {
    <?php $text_font->echo_css() ?>;
            text-decoration: none;
            margin-top: 15px;
            line-height: 1.3;
        }
        .title<?php echo $i ?> {
    <?php $title_font->echo_css() ?>;
            text-decoration: none;
            margin-top: 15px;
            line-height: normal;
        }
        .price<?php echo $i ?> {
    <?php $price_font->echo_css() ?>;
            text-decoration: none;
            margin-top: 15px;
            line-height: normal;
        }
        .features<?php echo $i ?> {
    <?php $features_font->echo_css() ?>;
            text-decoration: none;
            margin-top: 15px;
            line-height: normal;
            text-align: left;
        }
<?php } ?>
</style>

<?php
$items = [];

for ($i = 1; $i <= $options['columns']; $i++) {
    $features = wp_kses_post($options['features_' . $i]);
    $features = str_replace("\r\n", "\n", $features);
    $features = str_replace("\r", "\n", $features);
    $features = str_replace("\n", "<br>", $features);
    
    //$features = wpautop($features, true);

    ob_start();
    ?>
    <table cellpadding="15" cellspacing="0" border="0" width="100%"><tr>
            <td valign="top" align="center" style="background-color: <?php echo esc_attr($options['background_' . $i]) ?>; padding: 20px 20px 30px 20px">
                <?php if (!empty($options['title_' . $i])) { ?>
                    <div inline-class="title<?php echo $i ?>"><?php echo wp_kses_post($options['title_' . $i]) ?></div>
                <?php } ?>
                <?php if (!empty($options['text_' . $i])) { ?>
                    <div inline-class="text<?php echo $i ?>"><?php echo wp_kses_post($options['text_' . $i]) ?></div>
                <?php } ?>
                <?php if (!empty($options['price_' . $i])) { ?>
                    <div inline-class="price<?php echo $i ?>"><?php echo wp_kses_post($options['price_' . $i]) ?></div>
                <?php } ?>
                <?php if (!empty($options['features_' . $i])) { ?>
                    <div inline-class="features<?php echo $i ?>"><?php echo $features ?><br><br><br></div>
                <?php } ?>
                <?php echo TNP_Composer::button($options, 'button_' . $i, $composer) ?>
            </td></tr></table>

    <?php
    $items[] = ob_get_clean();
}

echo TNP_Composer::grid($items, ['columns' => $options['columns'], 'responsive' => true, 'width' => $composer['content_width']]);
