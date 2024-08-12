=== Articles ===
Tags: articles, featured posts, highlight, best
Contributors: alexkingorg, crowdfavorite
Requires at least: 2.3
Tested up to: 5.9
Stable tag: 1.4.0


The Articles plugin allows you to display a list of posts you wish to feature/highlight.

== Installation ==

1. Download the plugin archive and expand it (you've likely already done this).
2. Put the 'articles.php' file into your wp-content/plugins/ directory.
3. Go to the Plugins page in your WordPress Administration area and click 'Activate' for Articles.
4. Go to Options > Articles to configure your Articles settings.

== Upgrading ==

If you used Articles version 1.2 or earlier, please use the Upgrade button on the settings page to upgrade your data for version 1.3.

== Choosing Articles ==

To add post to your Articles list, simply add a custom field (below the big text field on the post/page edit form) to the post:

Key: article
Value: 1

== Showing the Articles List ==

There are two methods for showing the articles list.

= Token Method =

The token method is the easier way to show your articles list, and is enabled by default. To show your articles list, simply add the following to a page or post:

`###articles###`

and your articles list will appear in this place in the page/post.

= Template Tag Method =

You can always add a template tag to your theme (in a page template perhaps) to show your articles list:

`<?php if (function_exists('aka_show_articles')) { aka_show_articles(); } ?>`

== Known Issues ==

= Token Processing Time =

Using the token method to show your Articles list will add *very* minor additional processing to each post display on your site.

== Frequently Asked Questions ==

= What is the custom field name? =

By default, Articles uses '_ak_article' as the custom field name. You can change this by changing the following line at the top of the plugin (in the plugin code):

`define('AKA_META_KEY', '_ak_article');`

If you have used the default or another custom field name, you'll need to upgrade your data to your new custom field name. The plugin does not do this for you.

= Can I change the custom field name? =

ArIf you need to change

= Anything else? =

That about does it - enjoy!

--Alex King

http://alexking.org/projects/wordpress
