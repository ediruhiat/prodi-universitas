<?php
/**
 * @package  Prodi
 */
namespace Inc\Base;

if( ! defined( 'ABSPATH' ) )
    die( 'Restricted Access' );

class Activate extends BaseController
{
	public static function activate() {
		Activate::runSQL();
		Activate::addSubMenu();
		flush_rewrite_rules();
	}
	
	static private function runSQL() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'mata_kuliah';

		$query = "CREATE TABLE IF NOT EXISTS $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			kode_mk varchar(255) UNIQUE,
			mata_kuliah varchar(255),
			sks int(1),
			semester int(1),
			major varchar(3),
			PRIMARY KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $query );

		$table_name = $wpdb->prefix . 'dosen';
		$query = "CREATE TABLE IF NOT EXISTS $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			nip varchar(255) UNIQUE,
			nama_dosen varchar(255),
			email varchar(255),
			jabatan varchar(255),
			alamat varchar(255),
			riwayat_pend longtext,
			seminar longtext,
			penelitian longtext,
			artikel longtext,
			pengmas longtext,
			PRIMARY KEY id (id)
		) $charset_collate;";

		dbDelta( $query );

		$table_name = $wpdb->prefix . 'rest_keys';
		$query = "CREATE TABLE IF NOT EXISTS $table_name ( 
			'id' INT NOT NULL AUTO_INCREMENT , 
			'username' VARCHAR(255) NOT NULL , 
			'the_key' VARCHAR(255) NOT NULL , 
			PRIMARY KEY ('id'), 
			UNIQUE ('username'), 
			UNIQUE ('the_key'))
		) $charset_collate;";

		dbDelta( $query );
	}

	static private function addSubMenu(){
		add_submenu_page(
			'tools.php',
			'WPOrg Options',
			'WPOrg Options',
			'manage_options',
			'wporg',
			'wporg_options_page_html'
		);
		add_action('admin_menu', 'wporg_options_page');
	}
}