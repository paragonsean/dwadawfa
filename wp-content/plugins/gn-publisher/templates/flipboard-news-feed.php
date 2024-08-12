<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$last_deactivation = get_option( 'gnpub_last_deactivation', 0 );
$last_activation = get_option( 'gnpub_last_activation', 0 );

/**
 * RSS2 Feed Template for displaying RSS2 Posts feed specifically for Google News Publisher.
 * 
 * This template is based on wp-includes/feed-rss2.php
 */

header( 'Content-Type: ' . feed_content_type( 'rss2' ) . '; charset=' . get_option( 'blog_charset' ), true );
$more = 1;

///////////////
// Disable caching @since 1.0.2 -ca
//////////////
header('Expires: Wed, 01 Jan 2014 00:00:00 GMT');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

define( 'DONOTCACHEPAGE', true);

echo '<?xml version="1.0" encoding="' . get_option( 'blog_charset' ) . '"?' . '>';
/**
 * Fires between the xml and rss tags in a feed.
 *
 * @since 4.0.0
 *
 * @param string $context Type of feed. Possible values include 'rss2', 'rss2-comments',
 *                        'rdf', 'atom', and 'atom-comments'.
 */
do_action( 'rss_tag_pre', 'rss2' );
?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
<?php
	/**
	 * Fires at the end of the RSS root to add namespaces.
	 *
	 * @since 2.0.0
	 */
	do_action( 'rss2_ns' );
	echo '>';
	?> 

	<channel>
		<title><?php gnpub_wp_title_rss(); ?></title>
		<link><?php gnpub_feed_channel_link(); ?></link>
		<description><?php gnpub_bloginfo_rss( 'description' ); ?></description>
		<language><?php bloginfo_rss( 'language' ); ?></language>
<?php
	while ( have_posts() ) :
		the_post();

		$mod_counter = intval( get_post_meta( get_the_ID(), 'gnpub_modified_count', true ) );

		$last_modified = get_post_modified_time( 'U', true );
		if ( $last_modified > $last_deactivation && $last_modified < $last_activation ) {
			$mod_counter++;
		}

		if ( $mod_counter ) {
			$pub_date_object = new DateTime;
			$pub_date_object->setTimestamp( get_post_time( 'U', true ) );
			$pub_date_object->modify( '+' . $mod_counter . ' seconds' );

			$pub_date = date( 'D, d M Y H:i:s +0000', $pub_date_object->getTimestamp() );
		} else {
			 $pub_date = mysql2date( 'D, d M Y H:i:s +0000', get_post_time( 'Y-m-d H:i:s', true ), false );

		}
		
		
		
		$category = get_the_category(get_the_ID());
		if ( ! empty( $category ) ) {
			$namees = array();
			foreach ($category  as $nameCategory) {
				$namees[] = $nameCategory->name;   
			  }                                      
		 }
		 ?>

		<item>
			<title><?php gnpub_the_title_rss(); ?></title>
			<link><?php gnpub_feed_post_link(get_the_permalink()); ?></link>
			<guid isPermaLink="false"><?php the_guid(); ?></guid>
			<pubDate><?php echo $pub_date; ?></pubDate>
			<?php $gnpub_authors = '<dc:creator><![CDATA['.get_the_author().']]></dc:creator>'; ?>
			
			<?php $gnpub_authors = apply_filters('gnpub_pp_authors_compat',$gnpub_authors );
				  $gnpub_authors = apply_filters('gnpub_molongui_authors_compat',$gnpub_authors );
				  echo $gnpub_authors;
			?>
			
<?php 
$content = get_the_content_feed( GNPUB_Feed::FEED_ID );
$content = gnpub_remove_potentially_dangerous_tags($content);

if( function_exists( 'gnpub_flipboard' ) )
	$content = gnpub_flipboard( $content );
 if ( $content && strlen( $content ) > 0 ) : 
?>
			<description><![CDATA[<?php echo wp_trim_words($content,15,'...');?>]]></description>
			<?php if (has_post_thumbnail( get_the_ID() ) ){ ?>
				<enclosure url="<?php esc_url( the_post_thumbnail_url() ); ?>" length="1000" type="image/jpeg" />
			<?php } ?>

			<?php if ( ! empty( $category ) ) { ?> 
				<category><?php echo implode(", ",$namees); ?></category>
			<?php } ?>

			<content:encoded><![CDATA[<?php echo $content; ?>]]></content:encoded>
<?php 		else : ?>
			<content:encoded><![CDATA[<?php the_excerpt_rss(); ?>]]></content:encoded>
<?php 		endif; ?>
<?php 		rss_enclosure(); ?>
		</item>
<?php 	endwhile; ?>
	</channel>
</rss>