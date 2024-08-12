<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* Trait: Cache
*/
trait Wtn_Cache
{
    /**
     * Delete all transients from the database whose keys have a specific prefix.
     *
     * @param string $prefix The prefix. Example: 'my_cool_transient_'.
     */
    function wtn_delete_transients_with_prefix( $prefix ) {

        foreach ( $this->wtn_get_transient_keys_with_prefix( $prefix ) as $key ) {
            delete_transient( $key );
        }

        return true;
    }

    /**
     * Gets all transient keys in the database with a specific prefix.
     *
     * Note that this doesn't work for sites that use a persistent object
     * cache, since in that case, transients are stored in memory.
     *
     * @param  string $prefix Prefix to search for.
     * @return array          Transient keys with prefix, or empty array on error.
     */
    protected function wtn_get_transient_keys_with_prefix( $prefix ) {
        global $wpdb;

        $prefix = $wpdb->esc_like( '_transient_' . $prefix );
        $sql    = "SELECT `option_name` FROM $wpdb->options WHERE `option_name` LIKE '%s'";
        $keys   = $wpdb->get_results( $wpdb->prepare( $sql, $prefix . '%' ), ARRAY_A );

        if ( is_wp_error( $keys ) ) {
            return [];
        }
        
        return array_map( function( $key ) {
            // Remove '_transient_' from the option name.
            return ltrim( $key['option_name'], '_transient_' );
        }, $keys );
    }

}