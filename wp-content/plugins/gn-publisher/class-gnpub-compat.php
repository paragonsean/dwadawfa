<?php

/**
 * Resolves known conflicts with other plugins.
 * 
 * @since 1.0.8
 */

class GNPUB_Compat {

	public static function init() {
		add_action( 'plugins_loaded', array( 'GNPUB_Compat', 'seo_plugins_strip_category_base' ), 20 );
	}

	/**
	 * Strip category base feature has a known issue where it
	 * will only work for default WordPress feed types. This function solves
	 * this issue.
	 * 
	 * Fix for Yoast SEO , Rank Math and AIOSEO
	 * 
	 * @since 1.5.2
	 * 
	 */

	public static function seo_plugins_strip_category_base() {
		
		$add_rewrite=false;
		// FIX for Yoast Plugin
		if ( defined( 'WPSEO_VERSION' ) ) {
			// Next, check if the strip category base feature is enabled.
			if ( is_callable( array( 'WPSEO_Options', 'get' ) ) && WPSEO_Options::get( 'stripcategorybase' ) == true ) {
				$add_rewrite=true;
			}
		}

		//FIX for Rank Math
		if (class_exists('RankMath') ) {
			// Next, check if the strip category base feature is enabled.
			if (class_exists('\RankMath\Helper') && \RankMath\Helper::get_settings( 'general.strip_category_base' ) ) {
				$add_rewrite=true;
			}
		}

		/**
		 * No Category Base Plugin Compatiblity
		 * for enable rewrite rules
		 * 
		 * @since 1.5.8
		 */
		if( in_array( 'no-category-base-wpml/no-category-base-wpml.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && function_exists( 'no_category_base_rewrite_rules' ) ) {
			$add_rewrite = true;
		}

		//FIX for AIOSEO
		if (function_exists('aioseo') ) {
			// Next, check if the strip category base feature is enabled.
			if (aioseo()->options->searchAppearance->advanced->removeCatBase) {
				$add_rewrite=true;

			}
		
		}

		if(get_option( 'category_base' )==".")
		{
			$add_rewrite=true;
		}
		
		if($add_rewrite)
		{
			add_filter( 'category_rewrite_rules', array( 'GNPUB_Compat', 'seo_plugins_gn_feed_fix' ), 20 );
		}

	}

	/**
	 * Iterates through the categories and creates a new rewrite rule for the gn publisher feed
	 * which is not created by SEO plguins .
	 * 
	 * @param array $category_rewrite_rules
	 * 
	 * @since 1.0.8
	 * 
	 * @see WPSEO_Rewrite::category_rewrite_rules()
	 * 
	 * @return array
	 */
	public static function seo_plugins_gn_feed_fix( $category_rewrite_rules ) {
		global $wp_rewrite;

		$taxonomy = get_taxonomy( 'category' );
		$permalink_structure = get_option( 'permalink_structure' );
		update_option('cus_rewrite_update_time',time());
		$blog_prefix = '';
		if ( is_multisite() && ! is_subdomain_install() && is_main_site() && strpos( $permalink_structure, '/blog/' ) === 0 ) {
			$blog_prefix = 'blog/';
		}	
		$categories = get_categories( [ 'hide_empty' => false ] );
		if ( is_array( $categories ) && ! empty( $categories ) ) {
			foreach ( $categories as $category ) {
				$category_nicename = $category->slug;
				if ( $category->parent === $category->cat_ID ) {
					$category->parent = 0;
				} elseif ( $taxonomy->rewrite['hierarchical'] !== false && $category->parent !== 0 ) {
					$parents = get_category_parents( $category->parent, false, '/' ,true);
					if ( ! is_wp_error( $parents ) ) {
						$category_nicename = $parents . $category_nicename;
					}

					unset( $parents );
				}

				$category_rewrite_rules = GNPUB_Compat::add_gn_feed_category_rewrite( $category_rewrite_rules, $category_nicename, $blog_prefix, $wp_rewrite->pagination_base );

				if ( strpos( $category_nicename, '%') !== false ) {
					$names = explode( '/', $category_nicename );
					$names = array_map( function( $name ) {
						return ( strpos( $name, '%' ) !== false ) ? strtoupper( $name ) : $name;
					}, $names );

					$category_nicename_filtered = implode( '/', $names );

					if ( $category_nicename_filtered !== $category_nicename ) {
						$category_rewrite_rules = GNPUB_Compat::add_gn_feed_category_rewrite( $category_rewrite_rules, $category_nicename_filtered, $blog_prefix, $wp_rewrite->pagination_base );
					}

					unset( $names );
				}
			}

			unset( $categories, $category, $category_nicename, $category_nicename_filtered );
		}
		
		return $category_rewrite_rules;
	}

	/**
	 * Adds required category rewrites rules.
	 *
	 * @since 1.0.8
	 * 
	 * @param array  $rewrites        The current set of rules.
	 * @param string $category_name   Category nicename.
	 * @param string $blog_prefix     Multisite blog prefix.
	 * @param string $pagination_base WP_Query pagination base.
	 *
	 * @return array The added set of rules.
	 */
	public static function add_gn_feed_category_rewrite( $rewrites, $category_name, $blog_prefix, $pagination_base ) {
		$rewrite_name = $blog_prefix . '(' . $category_name . ')';

		$rewrites[ $rewrite_name . '/(?:feed/)?gn/?$' ] = 'index.php?category_name=$matches[1]&feed=gn';
		if (function_exists('aioseo') && !empty(get_option('permalink_structure'))) {
			$rewrites[  '(' . $category_name . ')/(?:feed/)?gn/?$' ] = 'index.php?category_name=$matches[1]&feed=gn';
		}

		return $rewrites;
	}

}