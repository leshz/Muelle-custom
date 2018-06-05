<?php
/**
	Plugin Name:	Muelle-wp-custom
	Plugin URI:		https://github.com/leshz/Wordpress-plugin-base
	Description:	Plugin para mostrar estado del muelle e informacion
	Version: 			0.1.3
	Author:				Jeffer Barragán
	Author URI:		github.com/leshz
	License:		GPLv2 or later
**/

/**
	Definiendo rutas base para el plugin
**/
define( 'WCPM_VERSION', '0.1.0' );
define( 'WCPM_PLUGIN', __FILE__ );
define( 'WCPM_PLUGIN_BASENAME', plugin_basename( WCPM_PLUGIN ) );
define( 'WCPM_PLUGIN_NAME', trim( dirname( WCPM_PLUGIN_BASENAME ), '/' ) );
define( 'WCPM_PLUGIN_DIR', untrailingslashit( dirname( WCPM_PLUGIN ) ) );
define( 'WCPM_PLUGIN_MAIN', WCPM_PLUGIN_DIR.'/muelle-custom.php'  );
require  WCPM_PLUGIN_DIR . '/settings.php';
require  WCPM_PLUGIN_DIR . '/database.php';
require  WCPM_PLUGIN_DIR . '/helpers.php';
require  WCPM_PLUGIN_DIR . '/adminview.php';
require  WCPM_PLUGIN_DIR . '/clientview.php';

register_deactivation_hook( __FILE__ , 'remove_tables' );
register_activation_hook( __FILE__ , 'installDB' );