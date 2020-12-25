<?php
/**
 * @package  Prodi
 */
/*
Plugin Name: Prodi Plugin
Plugin URI: https://github.com/edrhyt/prodi-universitas/
Description: Plugin Prodi untuk pengelolaan website prodi di Universitas.
Version: 1.0.0
Author: Edi Ruhiat
Author URI: https://github.com/edrhyt/
License: GPLv2 or later
Text Domain: prodi-unjani-plugin
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

// If this file is called directly, abort!!!
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );

use Inc\Classes\RestProdi;

// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation
 */
function activate_prodi_plugin() {
	Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_prodi_plugin' );

/**
 * The code that runs during plugin deactivation
 */
function deactivate_alecaddd_plugin() {
	Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_prodi_plugin' );

/**
 * Initialize all the core classes of the plugin
 */
if ( class_exists( 'Inc\\Init' ) ) {
	Inc\Init::register_services();
}


/**
 * Function to register our new routes from the controller.
 */

function register_prodi_api_controller() {
	$controller = new RestProdi();
	$controller->register_routes();
}

add_action( 'rest_api_init', 'register_prodi_api_controller' );
