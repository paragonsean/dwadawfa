<?php
/*
 * Name: EDD products
 * Section: content
 * Description: Add some Easy Digital Downloads files to your newsletter
 * Type: dynamic
 *
 * A single block of CSS can be added where one or more classes can be definied as
 *
 * .classname {
 *   option: value;
 *   option: value;
 * }
 *
 * each element with class="classname" will be modified replacing the previous attribute with a style="..."
 * with all CSS values. This is called inlining CSS.
 * The CSS block is removed after the inlining.
 *
 * Some variables are available:
 * - $options contains all the options collected with the block configuration form
 * - $wpdb is the global WP object to access the database
 */

/* @var $options array */
/* @var $wpdb wpdb */

$defaults = array(
    'block_background' => '',
    'block_padding_left' => 15,
    'block_padding_right' => 15,
    'block_padding_top' => 20,
    'block_padding_bottom' => 20,
    'show_price' => 1,
    'product_button' => 'view',
    'product_button_text' => 'View download',
    'show_excerpt' => 1,
    'max' => 3,
    'size' => 'medium',
    'button_background' => '#256F9C',
    'columns' => 1,
    'automated_include' => 'new',
    'automated_no_contents' => 'No new downloads by now!',
    'automated' => '',
    'language' => '',
    'font_family' => '',
    'font_size' => '',
    'font_color' => '',
    'title_weight' => '',
    'title_font_family' => '',
    'title_font_size' => '',
    'title_font_color' => '',
    'title_font_weight' => '',
);

$options = array_merge($defaults, $options);

// check if EDD is installed and active
if (!class_exists('EDD_Download')) {
    ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td bgcolor="#F5F7FA" align="center" style="padding: 20px 15px 20px 15px;" class="section-padding">
                EDD plugin is not active, please install and activate it.
            </td>
        </tr>
    </table>
    <?php
    return;
}

include_once NEWSLETTER_INCLUDES_DIR . '/helper.php';

$args = array('post_type' => 'download');

$args['tax_query'] = array();

if (!empty($options['categories'])) {
    $args['tax_query'][] = array(
        'taxonomy' => 'download_category',
        'field' => 'term_id',
        'terms' => $options['categories'],
        'operator' => 'IN'
    );
}

if (!empty($options['tags'])) {
    $args['tax_query'][] = array(
        'taxonomy' => 'download_tag',
        'field' => 'slug',
        'terms' => $options['tags'],
        'operator' => 'IN'
    );
}

if (!empty($options['ids'])) {
    $args['post__in'] = explode(",", $options['ids']);
}

if (!empty($options['max'])) {
    $args['posts_per_page'] = (int)$options['max'];
}

if ($context['type'] != 'automated') {

    $downloads = Newsletter::instance()->get_posts($args, $options['language']);

} else {

    if (!empty($options['automated_disabled'])) {

        $downloads = Newsletter::instance()->get_posts($args, $options['language']);

    } else {

        // Can be empty when composing...
        if (!empty($context['last_run'])) {
            $args['date_query'] = array(
                'after' => gmdate('c', $context['last_run'])
            );
        }

        $downloads = Newsletter::instance()->get_posts($args, $options['language']);

        if (empty($downloads)) {
            if ($options['automated'] == '1') {
                $out['stop'] = true;
                return;
            } else if ($options['automated'] == '2') {
                $out['skip'] = true;
                return;
            } else {
                echo '<div inline-class="nocontents">', $options['automated_no_contents'], '</div>';
                return;
            }
        } else {
            if ($options['automated_include'] == 'max') {
                unset($args['date_query']);
                $downloads = Newsletter::instance()->get_posts($args, $options['language']);
            }
        }
    }
}

if (!empty($downloads)) {
    $out['subject'] = $downloads[0]->post_title;
}

// Style variables
$button_background = $options['button_background'];

$scaled_title_font_size = floor( $global_title_font_size * ( 1.1 - 0.15 * $options['columns'] ) );

$title_font_family = empty( $options['title_font_family'] ) ? $global_title_font_family : $options['title_font_family'];
$title_font_size   = empty( $options['title_font_size'] ) ? $scaled_title_font_size : $options['title_font_size'];
$title_font_color  = empty( $options['title_font_color'] ) ? $global_title_font_color : $options['title_font_color'];
$title_font_weight = empty( $options['title_font_weight'] ) ? $global_title_font_weight : $options['title_font_weight'];

$text_font_family = empty( $options['font_family'] ) ? $global_text_font_family : $options['font_family'];
$text_font_size   = empty( $options['font_size'] ) ? $global_text_font_size : $options['font_size'];
$text_font_color  = empty( $options['font_color'] ) ? $global_text_font_color : $options['font_color'];
$text_font_weight = empty( $options['font_weight'] ) ? $global_text_font_weight : $options['font_weight'];

?>

<style>
    .edd-price {
        font-family: <?php echo $text_font_family?>;
        font-size: <?php echo round($text_font_size * 1.2)?>px;
        color: <?php echo $text_font_color?>;
        font-weight: bold;
        line-height: 1.5em;
        padding: 15px 0 0 0;
    }

    .edd-title {
        font-family: <?php echo $title_font_family ?>;
        font-size: <?php echo $title_font_size ?>px;
        font-weight: <?php echo $title_font_weight ?>;
        color: <?php echo $title_font_color ?>;
        line-height: normal;
        padding: 15px 0 0 0;
    }

    .edd-excerpt {
        font-family: <?php echo $text_font_family ?>;
        font-size: <?php echo $text_font_size ?>px;
        font-weight: <?php echo $text_font_weight ?>;
        color: <?php echo $text_font_color ?>;
        line-height: 1.5em;
        padding: 5px 0 0 0;
    }

    .woocommerce-image {
        display: block;
        max-width: 100%;
    }
</style>
<?php

$button_template = file_get_contents(plugin_dir_path(__FILE__) . 'templates' . DIRECTORY_SEPARATOR . 'product-button.php');
$price_template = file_get_contents(plugin_dir_path(__FILE__) . 'templates' . DIRECTORY_SEPARATOR . 'product-price.php');
$excerpt_template = file_get_contents(plugin_dir_path(__FILE__) . 'templates' . DIRECTORY_SEPARATOR . 'product-excerpt.php');
$product_template = file_get_contents(plugin_dir_path(__FILE__) . 'templates' . DIRECTORY_SEPARATOR . 'product.php');

$container = new TNP_Composer_Grid_System($options['columns']);

foreach ($downloads as $idx => $p) {

    setup_postdata($p);
    // Product initialization
    $edddownload = new EDD_Download($p->ID);

    $price_html = '';

    if (!empty($options['show_price'])) {
        $price_html = str_replace('TNP_EDD_PRICE', edd_price($p->ID, false), $price_template);
    }

    if ($options['product_button'] == 'cart') {

        $button_url = add_query_arg(['edd_action' => 'add_to_cart', 'download_id' => $p->ID], home_url());

    } elseif ($options['product_button'] == 'view') {

        $button_url = add_query_arg(['p' => $p->ID], home_url());;

    }

    $button_html = '';
    if (!empty($options['product_button'])) {
        $button_html = str_replace(
            ['TNP_BUTTON_URL_PH', 'TNP_BUTTON_BACKGROUND_COLOR_PH', 'TNP_BUTTON_TEXT_PH'],
            [$button_url, $button_background, $options['product_button_text']],
            $button_template);
    }

    $excerpt_html = '';
    if (!empty($options['show_excerpt'])) {
        $excerpt_html = str_replace('TNP_EXCERPT_PH', tnp_post_excerpt($p), $excerpt_template);
    }

    $button_html = '';
    if (!empty($options['product_button'])) {
        $button_html = str_replace(
            ['TNP_BUTTON_URL_PH', 'TNP_BUTTON_BACKGROUND_COLOR_PH', 'TNP_BUTTON_TEXT_PH'],
            [$button_url, $button_background, $options['product_button_text']],
            $button_template);
    }


    $product_html = str_replace(
        [
            'TNP_PRODUCT_PERMALINK_PH',
            'TNP_PRODUCT_IMG_PH',
            'TNP_PRODUCT_IMG_ALT_PH',
            'TNP_PRODUCT_TITLE_PH',
            'TNP_PRODUCT_EXCERPT_PH',
            'TNP_PRODUCT_PRICE_PH',
            'TNP_PRODUCT_BUTTON_PH',
        ],
        [
            get_permalink($p),
            tnp_post_thumbnail_src($p, $options['size']),
            esc_attr(tnp_post_title($p)),
            tnp_post_title($p),
            $excerpt_html,
            $price_html,
            $button_html,
        ],
        $product_template);

    $cell = new TNP_Composer_Grid_Cell($product_html);
    $container->add_cell($cell);

}

echo $container;

?>
