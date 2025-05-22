<?php
/*
Plugin Name: DB Readonly
Description: Prevents all writes to the WordPress database. This is necessary to prevent database corruption for failover locations or demo sites.
Version: 1.0
Author: CloudPress
Source: https://wordpress.stackexchange.com/questions/243438/configure-wordpress-to-read-from-database-only-never-write
*/

/**
 * Whitelist "SELECT" and "SHOW FULL COLUMNS" queries.
 */
function cldprs_stop_writes( $query ) {
    global $wpdb;
  
    if ( preg_match( '/^\s*select|show full columns\s+/i', $query ) ) {
      return $query;
    }
  
    // Return arbitrary query for everything else otherwise you get 'empty query' db errors.
    return "SELECT ID from $wpdb->posts LIMIT 1;";
  }
  add_filter( 'query', 'cldprs_stop_writes' );