<?php
/*
Plugin Name: Website Open/Closed Toggle
Description: This plugin allows you to easily open and close your website and display a custom message or HTML page when closed.
Version: 0.3.9.1
Author: RS
Author URI: https://rs.scot
Author Email: wordpress.plugins@rs.scot
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

	Copyright 2015-2022 RS (wordpress.plugins@rs.scot)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 3, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA

*/

if( !defined( 'ABSPATH' ) ) { exit; }

define( 'RS_WOCT__ADMIN_FUNC', 'rs_woct_admin_init' );
define( 'RS_WOCT__ADMIN_PAGE', 'rs-woct' );
define( 'RS_WOCT__ADMIN_REQCAP', 'add_users' );
define( 'RS_WOCT__BASE', 'woct/' );
define( 'RS_WOCT__OPTION', 'rs_woct_settings' );
define( 'RS_WOCT__PLUGIN_ADMIN_URL', admin_url( 'admin.php?page='.RS_WOCT__ADMIN_PAGE ) );
define( 'RS_WOCT__PLUGIN_DIR', plugin_dir_path( __FILE__ ).RS_WOCT__BASE );
define( 'RS_WOCT__PLUGIN_DIR_NAME', end( explode( '/', dirname( __FILE__ ) ) ) );
define( 'RS_WOCT__PLUGIN_FILE', __FILE__ );
define( 'RS_WOCT__PLUGIN_ICON', 'dashicons-lock' );
define( 'RS_WOCT__PLUGIN_MENU_POS', '80.00000000000001' );
define( 'RS_WOCT__PLUGIN_NAME', 'Website Open/Closed Toggle' );
define( 'RS_WOCT__PLUGIN_SHORT_NAME', 'Open/Closed' );
define( 'RS_WOCT__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'RS_WOCT__PLUGIN_VERSION', '0.3.9.1' );

foreach( glob( RS_WOCT__PLUGIN_DIR.'*.php' ) as $file ) { require_once( $file ); }

add_action( 'admin_enqueue_scripts', 'rs_woct_css' );
add_action( 'admin_menu', 'rs_woct_setup_menu' );
add_action( 'template_redirect', 'rs_woct_output' );
add_action( 'template_redirect', 'rs_woct_redirect' );

add_filter( 'plugin_action_links', 'rs_woct_plugin_links', 10, 2 );

register_activation_hook( RS_WOCT__PLUGIN_FILE, 'rs_woct_on_activation' );
register_deactivation_hook( RS_WOCT__PLUGIN_FILE, 'rs_woct_on_deactivation' );

function rs_woct_on_activation() { rs_woct_activate(); }
function rs_woct_on_deactivation() { rs_woct_deactivate(); }