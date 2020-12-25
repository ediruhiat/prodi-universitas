<?php

/**
 * Trigger this file on Plugin uninstall
 *
 * @package  Prodi
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// Access the database via SQL
global $wpdb;
$wpdb->query( "DROP TABLE wp_mata_kuliah");
$wpdb->query( "DROP TABLE wp_dosen");