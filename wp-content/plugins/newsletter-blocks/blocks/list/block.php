<?php
/*
 * Name: List
 * Section: content
 * Description: A well designed list for your strength points
 *
 */

/* @var $options array */
/* @var $wpdb wpdb */

$default_options = array(
    'bullet' => '1',
    'text_1' => 'Element 1',
    'text_2' => 'Element 2',
    'text_3' => 'Element 3',
    'font_size'   => '',
    'font_color'  => '',
    'font_weight' => '',
    'font_family' => '',
    'block_padding_top' => 20,
    'block_padding_bottom' => 20,
    'block_padding_left' => 15,
    'block_padding_right' => 15,
    'block_background' => ''
);

$options = array_merge($default_options, $options);

$text_font = TNP_Composer::get_text_style($options, '', $composer);
?>

<style>
    .item {
        <?php $text_font->echo_css() ?>;
        text-align: left;
        line-height: normal;
    }
</style>
<table cellspacing="0" cellpadding="5" align="left">
    <?php
    for ($i = 1; $i <= 10; $i++) {
        if (empty($options['text_' . $i])) {
            continue;
        }
        ?>
        <tr>
            <td align="left" width="<?php echo round($text_font->font_size*1.3)+5 ?>" valign="top"><img style="width:<?php echo $text_font->font_size*1.3 ?>px;" src="<?php echo plugins_url('newsletter-blocks') ?>/blocks/list/images/bullet-<?php echo $options['bullet'] ?>.png"></td>
            <td width="1">&nbsp;</td>
            <td align="left" inline-class="item">
                <?php echo $options['text_' . $i] ?>
            </td>
        </tr>
        <?php
    }
    ?>
</table>


