<?php

/*
Plugin Name: Articles
Plugin URI: http://alexking.org/projects/wordpress
Description: Display posts in an 'Articles' list. To include a post in the list, check the Article radio button for the post. Questions on configuration, upgrading, etc.? Make sure to read the README.
Version: 1.4.0
Author: Alex King
Author URI: http://alexking.org
*/

load_plugin_textdomain('articles');

define('AKA_META_KEY', '_ak_article');

function aka_upgrade_1_3()
{
	if (!current_user_can('manage_options')) {
		wp_die('Permission denied.');
	}
	global $wpdb;
	$wpdb->query("
		UPDATE $wpdb->postmeta
		SET meta_key = '" . AKA_META_KEY . "'
		WHERE (
			meta_key = 'article'
			AND meta_value = '1'
		)
	");
	header('Location: ' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=' . basename(__FILE__) . '&updated=true');
	die();
}

function aka_plugin_action_links($links, $file)
{
	$plugin_file = basename(__FILE__);
	if (basename($file) == $plugin_file) {
		$settings_link = '<a href="options-general.php?page=' . $plugin_file . '">' . __('Settings', '') . '</a>';
		array_unshift($links, $settings_link);
	}
	return $links;
}
add_filter('plugin_action_links', 'aka_plugin_action_links', 10, 2);

function aka_request_handler()
{
	if (isset($_POST['ak_action'])) {
		switch ($_POST['ak_action']) {
			case 'aka_update_settings':
				aka_update_settings();
				break;
			case 'aka_upgrade_1_3':
				aka_upgrade_1_3();
				break;
		}
	}
}
add_action('init', 'aka_request_handler');

function aka_head()
{
	if (get_option('aka_columns') == 2) {
		print('
<style type="text/css">
div.aka_half {
	float: left;
	overflow: auto;
	width: 45%;
}
div.aka_clear {
	clear: both;
	float: none;
}
</style>
		');
	}
}
add_action('wp_head', 'aka_head');

function aka_update_settings()
{
	if (!current_user_can('manage_options')) {
		wp_die('Permission denied.');
	}
	$settings = array('aka_columns', 'aka_token');
	foreach ($settings as $setting) {
		if (isset($_POST[$setting])) {
			if (get_option($setting)) {
				update_option($setting, intval($_POST[$setting]));
			} else {
				add_option($setting, intval($_POST[$setting]));
			}
		}
	}
	header('Location: ' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=' . basename(__FILE__) . '&updated=true');
	die();
}

function aka_get_articles()
{
	global $wpdb, $post;

	$original_post = $post;

	if (!($columns = get_option('aka_columns'))) {
		$columns = 1;
	}

	$query = new WP_Query('meta_key=' . AKA_META_KEY . '&meta_value=1&posts_per_page=99999999');
	if (!count($query->posts)) {
		return '';
	}

	$posts = array();
	$post_ids = array();

	foreach ($query->posts as $post) {
		$posts['post_' . $post->ID] = $post;
		$post_ids[] = $post->ID;
	}

	$cats = $wpdb->get_results("
		SELECT $wpdb->term_relationships.object_id, $wpdb->terms.term_id, $wpdb->terms.name, $wpdb->terms.slug
		FROM $wpdb->term_relationships
		LEFT JOIN $wpdb->term_taxonomy
		ON $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id
		LEFT JOIN $wpdb->terms
		ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id
		WHERE $wpdb->term_relationships.object_id IN (" . implode(',', $post_ids) . ")
		AND $wpdb->term_taxonomy.taxonomy = 'category'
		ORDER BY $wpdb->terms.slug, $wpdb->term_relationships.object_id DESC
	");

	$output = '';
	$current = '';
	$open = false;
	$i = 0;

	if ($columns == '2') {
		$half = 0;
		$next = false;
		$output .= '
		<div class="aka_half">
		';
	}

	foreach ($cats as $cat) {
		$slug = $cat->slug;
		if ($current != $slug) {
			if ($next) {
				$output .= '
			</ul>
		</div>
		<div class="aka_half">
			';
				$half++;
				$open = false;
				$next = false;
			}
			if ($i > 0 && $open) {
				$output .= '
				</ul>
				';
			}
			$output .= '
				<h3 id="cat_' . $slug . '">' . $cat->name . '</h3>
				<ul>
			';
			$open = true;
		}
		$current = $slug;
		$post = $posts['post_' . $cat->object_id];
		$output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>' . "\n";
		$i++;

		if ($columns == '2' && $half == 0 && $i > count($cats) / 2) {
			$next = true;
		}
	}

	if ($open) {
		$output .= '
			</ul>
		';
	}

	if ($columns == '2') {
		$output .= '
		</div>
		<div class="aka_clear"></div>
		';
	}

	$post = $original_post;

	return $output;
}

function aka_show_articles()
{
	echo aka_get_articles();
}

function aka_the_content($content)
{
	if (strstr($content, '###articles###')) {
		$content = str_replace('###articles###', aka_get_articles(), $content);
	}
	return $content;
}
function aka_the_excerpt($content)
{
	return str_replace('###articles###', '', $content);
}
if (get_option('aka_token') == '1') {
	add_action('the_content', 'aka_the_content');
	add_action('the_excerpt', 'aka_the_excerpt');
}

function aka_post_options()
{
	global $post;
	echo '<div class="postbox">
		<h3>' . __('Articles', 'articles') . '</h3>
		<div class="inside">
		<p>' . __('Mark as an Article?', 'articles') . '
		';
	$article = get_post_meta($post->ID, AKA_META_KEY, true);
	if ($article == '') {
		$article = '0';
	}
	echo '
	<input type="radio" name="aka_article" id="aka_article_1" value="1" ',checked('1', $article),' /> <label for="aka_article_1">' . __('Yes', 'articles') . '</label> &nbsp;&nbsp;
	<input type="radio" name="aka_article" id="aka_article_0" value="0" ',checked('0', $article),' /> <label for="aka_article_0">' . __('No', 'articles') . '</label>
	';
	echo '
		</p>
		</div><!--.inside-->
		</div><!--.postbox-->
	';
}
add_action('edit_form_advanced', 'aka_post_options');

function aka_store_post_options($post_id)
{
	if (!isset($_POST['aka_article'])) {
		return;
	}
	$post = get_post($post_id);
	if (!$post || $post->post_type == 'revision') {
		return;
	}
	$meta = get_post_meta($post->ID, AKA_META_KEY, true);
	$posted = intval($_POST['aka_article']);
	switch ($posted) {
		case 1:
			if (intval($meta) == 1) { // already set
				return;
			}
			add_post_meta($post_id, AKA_META_KEY, 1);
			break;
		case 0:
			delete_post_meta($post_id, AKA_META_KEY, 1); // turn it off
			break;
	}
}
add_action('draft_post', 'aka_store_post_options');
add_action('publish_post', 'aka_store_post_options');
add_action('save_post', 'aka_store_post_options');

function aka_options_form()
{
	if (get_option('aka_columns') == '2') {
		$column_options = '<option value="1">1</option><option selected="selected" value="2">2</option>';
	} else {
		$column_options = '<option value="1" selected="selected">1</option><option value="2">2</option>';
	}
	if (get_option('aka_token') == '0') {
		$token_options = '<option value="1">' . __('Yes', 'articles') . '</option><option value="0" selected="selected">' . __('No', 'articles') . '</option>';
	} else {
		$token_options = '<option value="1" selected="selected">' . __('Yes', 'articles') . '</option><option value="0">' . __('No', 'articles') . '</option>';
	}
	print('
		<div class="wrap">
			<h2>' . __('Articles Options', 'articles') . '</h2>
			<form name="ak_articles" action="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php" method="post">
				<fieldset class="options">
					<p>
						<label for="aka_columns">' . __('List articles in how many columns:', 'articles') . '</label>
						<select name="aka_columns" id="aka_columns">' . $column_options . '</select>
					</p>
					<p>
						<label for="aka_token">' . __('Enable <a href="#token">token method</a> for showing the articles list:', 'articles') . '</label>
						<select name="aka_token" id="aka_token">' . $token_options . '</select>
					</p>
					<input type="hidden" name="ak_action" value="aka_update_settings" />
				</fieldset>
				<p class="submit">
					<input type="submit" name="submit_button" value="' . __('Update Articles Settings', 'articles') . '" class="button-primary" />
				</p>
			</form>
			<h2>' . __('Upgrade from Version 1.2 (or earlier)', 'articles') . '</h2>
			<form name="ak_articles" action="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php" method="post">
				<fieldset class="options">
					<p>' . __('If you used Articles version 1.2 or earlier, you will need to upgrade your data for it to display correctly.', 'articles') . '</p>
					<input type="hidden" name="ak_action" value="aka_upgrade_1_3" />
				</fieldset>
				<p class="submit">
					<input type="submit" name="submit_button_upgrade" value="' . __('Upgrade from Version 1.2 (or earlier)', 'articles') . '" class="button" />
				</p>
			</form>
			<h2>' . __('Adding Articles to Your List', 'articles') . '</h2>
			<p>' . __('To add post to your Articles list, simply select the Yes option for the Article setting on a post-by-post basis.', 'articles') . '</p>
			<h2>' . __('Showing the Articles List', 'articles') . '</h2>
			<h3 id="token">' . __('Token Method', 'articles') . '</h3>
			<p>' . __('If you have enabled the token method above, you can simply add <strong>###articles###</strong> to any post or page and your articles list will be inserted at that place in the post/page.', 'articles') . '</p>
			<h3 id="template">' . __('Template Tag Method', 'articles') . '</h3>
			<p>' . __('You can always add a template tag to your theme (in a page template perhaps) to show your articles list.', 'articles') . '</p>
			<p><strong><code>&lt;php aka_show_articles(); ?&gt;</code></strong></p>
		</div>
	');
}

function aka_options()
{
	if (function_exists('add_options_page')) {
		add_options_page(
			__('Articles Options', 'articles'),
			__('Articles', 'articles'),
			'manage_options',
			basename(__FILE__),
			'aka_options_form'
		);
	}
}
add_action('admin_menu', 'aka_options');
