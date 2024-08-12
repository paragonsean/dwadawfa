=== GN Publisher: Google News Compatible RSS Feeds ===
Contributors: gnpublisher
Tags: google news, news, rss, feed, feeds
Requires at least: 3.5
Tested up to: 6.6
Requires PHP: 5.4
Stable tag: 1.5.16
License: GPLv3 
License URI: https://www.gnu.org/licenses/gpl-3.0.html


== Description ==

GN Publisher makes RSS feeds that comply with the [Google News RSS Feed Technical Requirements](https://support.google.com/news/publisher-center/answer/9545420) for including your site in the [Google News Publisher Center](https://publishercenter.google.com/).

The plugin addresses common RSS compatiblity issues publishers experience when using the Google News Publisher Center, including:

-  Incomplete articles
-  Duplicate images
-  Missing images or media
-  Missing content (usually social media/Instagram embeds)
-  Title errors (missing or repeated titles)
-  Cached RSS feeds causing slow updating
-  Delayed crawling by Google

After installing, click on the *'Dashboard'* under GN Publisher on your plugins page for additional information about applying and troubleshooting issues related to the Google News Publisher Center.

**New in 1.5.11**
Google Reader Revenue Manager support.Reader Revenue Manager provides publisher solutions to deepen audience engagement and convert subscribers or contributors.

**New in 1.0.9**

GN Publisher now displays the time of the most recent ping and feed fetch from Google. This helps when troubleshooting the dreaded 'empty sections' issue in the Google News Publisher Center.

**New in 1.0.6**

GN Publisher now pings Google when feeds are updated. This can help with faster updates in your Google News Publication.


### Support

We try our best to provide support on [WordPress GN Publisher plugin support forum](https://wordpress.org/support/plugin/gn-publisher/) forums. However, We have a special [team support](https://gnpublisher.com/contact-us/) where you can ask us questions and get help. Delivering a good user experience means a lot to us and so we try our best to reply each and every question that gets asked.


### Bug Reports

Bug reports for GN Publisher: Google News Compatible RSS Feeds are [welcomed on GitHub](https://github.com/ahmedkaludi/gn-publisher/issues/). Please note GitHub is not a support forum, and issues that aren't properly qualified as bugs will be closed.

### PRO Version

Take you Google News Feed experience to next level by using our [GN Publisher PRO](https://gnpublisher.com/pricing/#pricing) plugin which contains the following features.

* Content Scraping Protection 
* Exclude Categories From Main Feed 
* Google News Sitemap 
* Compatibility with Flipboard.com
* Compatibility with PublishPress Authors
* Compatibility with Translate Press

== Frequently Asked Questions ==

= How to install and use this GnPublisher plugin? =

After you Active this plugin, just go to Dashboard > Settings > GN Publisher, and after that, You can check feed url and all other settings there!  

= How do I report bugs and suggest new features? =

You can report the bugs for this GN Pub plugin [here](https://github.com/ahmedkaludi/gn-publisher/issues/)

= Will you include features to my request? =

Yes, Absolutely! We would suggest you send your feature request by creating an issue in [Github](https://github.com/ahmedkaludi/gn-publisher/issues/new/) . It helps us organize the feedback easily.

= How do I get in touch? =
You can contact us from [here](https://gnpublisher.com/contact-us/)


== Installation ==

GN Publisher is a standard WordPress plugin and can be installed and activated through your WordPress admin section. Just search for GN Publisher in the WP plugins repository and install and activate.

GN Publisher may also be downloaded to your computer and uploaded, installed, and activated through your WP Admin plugins section.

= Minimum Requirements =

* PHP 5.4 or greater is required, PHP 7.2 or newer is recommended
* This plugin is compatible with all MySQL versions supported by WordPress


== Changelog ==

= 1.5.16 - (09 August 2024) =

* Fixed : Reload issue on tab click #96
* Fixed : PHP fatal error on feed #98
* Tested with WordPress v6.6 and updated readme.txt #99

= 1.5.15 - (10 June 2024) =

* Remove ad tags from feed #88

= 1.5.14 - (23 April 2024) =

* Test with WordPress v6.5 and update readme #92

= 1.5.13 - (19 February 2024) =

* Fixed : Guid is not being changed based on language feed in translatpress #89
* Improved : Code improvement #90

= 1.5.12 - (26 December 2023) =

* Feature : Added option to include pages in google news Feed (pro) #76
* Fixed : Issue with the sitemap date formatting #82
* Tweak : Fixed PHP warnings #83
* Tweak : Enclosure Tag is getting duplicated in feed #85
* Fixed : Error message with Version 1.5.11.1 #86

= 1.5.11.1 - (24 November 2023) =

* Fixed : Warning after recent update Version 1.5.11 #79

= 1.5.11 - (23 November 2023) =

* Added : Reader Revenue Manager support #73
* Feature : Add 'rss2_item' Action Hook to Feed Template for Media Content #67
* Fixed : The network deactivate button is not working on the wp-multisite #75


= 1.5.10 - (12 September 2023) =

* Tweak : Displayed proper message on license activation/deactivation timeout #64
* Fixed : Multi language compatibility in multisite #68
* Feature : Added compatibility for Molongui author profile plugin #70

Full changelog available at [changelog.txt](https://plugins.svn.wordpress.org/gn-publisher/trunk/changelog.txt)
