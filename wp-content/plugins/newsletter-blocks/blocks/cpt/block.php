<?php
/*
 * Name: Custom Post Type
 * Section: content
 * Description: Extracts custom post types
 * Type: dynamic
 *
 */

/* @var $options array */
/* @var $wpdb wpdb */

$default_options = array(
    'language' => '',
    'post_type' => 'post',
    'max' => 10,
    'private' => '',
    'reverse' => '0',
    'image' => 1,
    'date' => 1,
    'author' => 1,
    'nocrop' => 0,
    'title_font_family' => '',
    'title_font_size' => '',
    'title_font_color' => '',
    'title_font_weight' => '',
    'font_family' => '',
    'font_size' => '',
    'font_color' => '',
    'font_weight' => '',
    'block_background' => '',
    'block_padding_left' => 15,
    'block_padding_right' => 15,
    'block_padding_top' => 15,
    'block_padding_bottom' => 15,
    'button_label' => __('Read more...', 'newsletter'),
    'button_background' => '',
    'button_font_color' => '',
    'button_font_family' => '',
    'button_font_size' => '',
    'button_font_weight' => '',
    'show_read_more_button' => true,
    'automated_include' => 'new',
    'automated_no_contents' => 'No new posts by now!',
    'automated' => '',
    'layout' => 'one',
    'inline_edits' => [],
    'excerpt_length' => 30,
);

// Backward compatibility
if (isset($options['automated_required'])) {
    $defaults['automated'] = '1';
}

$options = array_merge($default_options, $options);

$filters = array('post_type' => $options['post_type'], 'posts_per_page' => $options['max']);

if (!empty($options['private'])) {
    $filters['post_status'] = ['publish', 'private'];
}

$tax_query = [];
$taxonomies = get_object_taxonomies($options['post_type'], 'object');
if ($taxonomies) {
    foreach ($taxonomies as $taxonomy) {
        /* @var $taxonomy WP_Taxonomy */
        if (!empty($options['tax_' . $taxonomy->name])) {
            $tax_query[] = array(
                'taxonomy' => $taxonomy->name,
                'terms' => $options['tax_' . $taxonomy->name]
            );
        }

        if (!empty($options['tag_' . $taxonomy->name])) {
            $tags = explode(',', $options['tag_' . $taxonomy->name]);

            $tax_query[] = array(
                'taxonomy' => $taxonomy->name,
                'field'=>'slug',
                'terms' => array_unique(array_map('sanitize_title', $tags))
            );
        }
    }
}

if (!empty($tax_query)) {
    $filters['tax_query'] = $tax_query;
}

if ($context['type'] != 'automated') {
    $posts = Newsletter::instance()->get_posts($filters, $options['language']);
} else {

    if (!empty($options['automated_disabled'])) {
        $posts = Newsletter::instance()->get_posts($filters, $options['language']);
    } else {
        // Can be empty when composing...
        if (!empty($context['last_run'])) {
            $filters['date_query'] = array(
                'after' => gmdate('c', $context['last_run'])
            );
        }

        $posts = Newsletter::instance()->get_posts($filters, $options['language']);
        if (empty($posts)) {
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
                unset($filters['date_query']);
                $posts = Newsletter::instance()->get_posts($filters, $options['language']);
            }
        }
    }
}

if ($posts) {
    $out['subject'] = $posts[0]->post_title;
}

$text_align = 'left';
if (is_rtl()) {
    $text_align = 'right';
}

$current_language = Newsletter::instance()->get_current_language();
Newsletter::instance()->switch_language($current_language);

remove_all_filters('excerpt_more');

$image_placeholder_url = plugins_url('newsletter') . '/emails/blocks/posts/images/blank-240x160.png';

$excerpt_length = (int)$options['excerpt_length'];

$show_image = isset($options['image']) && (bool) $options['image'];
$show_date = isset($options['date']) && (bool) $options['date'];
$show_author = isset($options['author']) && (bool) $options['author'];
$show_read_more_button = (bool) $options['show_read_more_button'];

$title_font_family = empty($options['title_font_family']) ? $global_title_font_family : $options['title_font_family'];
$title_font_size = empty($options['title_font_size']) ? $global_title_font_size : $options['title_font_size'];
$title_font_color = empty($options['title_font_color']) ? $global_title_font_color : $options['title_font_color'];
$title_font_weight = empty($options['title_font_weight']) ? $global_title_font_weight : $options['title_font_weight'];

$text_font_family = empty($options['font_family']) ? $global_text_font_family : $options['font_family'];
$text_font_size = empty($options['font_size']) ? $global_text_font_size : $options['font_size'];
$text_font_color = empty($options['font_color']) ? $global_text_font_color : $options['font_color'];
$text_font_weight = empty($options['font_weight']) ? $global_text_font_weight : $options['font_weight'];

$button_options = $options;
$button_options['button_font_family'] = empty($options['button_font_family']) ? $global_button_font_family : $options['button_font_family'];
$button_options['button_font_size'] = empty($options['button_font_size']) ? $global_button_font_size : $options['button_font_size'];
$button_options['button_font_color'] = empty($options['button_font_color']) ? $global_button_font_color : $options['button_font_color'];
$button_options['button_font_weight'] = empty($options['button_font_weight']) ? $global_button_font_weight : $options['button_font_weight'];
$button_options['button_background'] = empty($options['button_background']) ? $global_button_background_color : $options['button_background'];

$excerpt_length_in_chars = false;

Newsletter::instance()->switch_language($options['language']);

// Preprocessing
foreach ($posts as $post) {
    $post->url = tnp_post_permalink($post);

    $post->title = TNP_Composer::is_post_field_edited_inline($options['inline_edits'], 'title', $post->ID) ?
            TNP_Composer::get_edited_inline_post_field($options['inline_edits'], 'title', $post->ID) :
            tnp_post_title($post);

    $post->title_linked = '<a href="' . esc_attr($post->url) . '" inline-class="title" class="tnpc-inline-editable"'
            . ' data-type="title" data-id="' . esc_attr($post->ID) . '" dir="' . esc_attr($dir) . '">'
            . $post->title . '</a>';

    $post->excerpt = TNP_Composer::is_post_field_edited_inline($options['inline_edits'], 'text', $post->ID) ?
            TNP_Composer::get_edited_inline_post_field($options['inline_edits'], 'text', $post->ID) :
            tnp_post_excerpt($post, $excerpt_length, $excerpt_length_in_chars);

    $post->excerpt_linked = '<a href="' . esc_attr($post->url) . '" inline-class="excerpt" class="tnpc-inline-editable" '
            . 'data-type="text" data-id="' . esc_attr($post->ID) . '" dir="' . esc_attr($dir) . '">'
            . $post->excerpt . '</a>';
}

if (!empty($options['reverse'])) {
    $posts = array_reverse($posts);
}

?>

<?php
if ($options['layout'] == 'one') {
    include __DIR__ . '/layout-one.php';
} else if ($options['layout'] == 'one-2') {
    include __DIR__ . '/layout-one-2.php';
} else if ($options['layout'] == 'two') {
    include __DIR__ . '/layout-two.php';
} else if ($options['layout'] == 'full-post') {
    include __DIR__ . '/layout-full-post.php';
} else {
    include __DIR__ . '/layout-big-image.php';
}

