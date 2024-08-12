<?php

/**
 * Repurpose page feeds for category of same name feeds.
 */
class Gnpub_Rss_Url {

    static function on_load() {

        add_action( 'pre_get_posts', array( __CLASS__, 'pre_get_posts' ) );

        add_action( 'do_feed_rdf', array( __CLASS__, 'do_feed' ), 9 );
        add_action( 'do_feed_rss', array( __CLASS__, 'do_feed' ), 9 );
        add_action( 'do_feed_rss2', array( __CLASS__, 'do_feed' ), 9 );
        add_action( 'do_feed_atom', array( __CLASS__, 'do_feed' ), 9 );
    }

    /**
     * Change page's comment feed into category feed.
     *
     * @param WP_Query $query
     */
    static function pre_get_posts( $query ) {

        if ( $query->is_main_query() && $query->is_page() && $query->is_feed() ) {
            $name = $query->get( 'pagename' );

            require_once( ABSPATH . 'wp-admin/includes/taxonomy.php' );

            if ( category_exists( $name ) ) {
                $category = get_category_by_slug( $name );

                $query->set( 'category_name', $name );
                $query->set( 'cat', $category->term_id );
                $query->set( 'pagename', '' );

                $query->is_page         = false;
                $query->is_comment_feed = false;
                $query->is_category     = true;
                $query->is_singular     = false;


                remove_action( 'do_feed_rdf', array( __CLASS__, 'do_feed' ), 9 );
                remove_action( 'do_feed_rss', array( __CLASS__, 'do_feed' ), 9 );
                remove_action( 'do_feed_rss2', array( __CLASS__, 'do_feed' ), 9 );
                remove_action( 'do_feed_atom', array( __CLASS__, 'do_feed' ), 9 );

                remove_action( 'template_redirect', 'redirect_canonical' );
            }
        }
    }

    /**
     * Redirect real category feed to page feed.
     */
    static function do_feed() {

        if ( ! is_category() )
            return;

        $name = get_query_var( 'category_name' );
        $page = get_page_by_path( $name );

        if ( ! empty( $page ) ) {
            wp_safe_redirect( get_post_comments_feed_link( $page->ID ) );
            die;
        }
    }
}