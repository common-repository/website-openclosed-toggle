<?php

if( !defined( 'ABSPATH' ) ) { exit; }

function rs_woct_css() {
	wp_register_style( 'rs_woct_css', RS_WOCT__PLUGIN_URL.RS_WOCT__BASE.'css/style.css', array(), RS_WOCT__PLUGIN_VERSION, 'screen' );
	$path = rs_woct_get_current_path();
	if( strpos( $path['path'], '='.RS_WOCT__ADMIN_PAGE ) ) {
		wp_enqueue_style( 'rs_woct_css' );
	}
}

function rs_woct_get_current_path() {
	$protocol = explode( '//', home_url() );
	$domain = explode( '/', $protocol[1] );
	$website_root = $protocol[0].'//'.$domain[0];
	$current_path = $_SERVER['REQUEST_URI'];
	$current_path_exploded = explode( '/', $current_path );
	$current_path = array(
		'count' => count( $current_path_exploded ),
		'exploded' => $current_path_exploded,
		'full_uri' => $website_root.$current_path,
		'path' => $current_path,
		'top' => $current_path_exploded[1],
	);
	$no_query = explode( '?', $current_path['full_uri'] );
	$current_path['full_uri_no_query'] = $no_query[0];
	ksort( $current_path );
	return $current_path;
}

function rs_woct_plugin_links( $links, $file ) {
	$plugin_file = explode( RS_WOCT__PLUGIN_DIR_NAME.'/', RS_WOCT__PLUGIN_FILE );
	$plugin_file = RS_WOCT__PLUGIN_DIR_NAME.'/'.$plugin_file[1];
	if( $file == $plugin_file ) {
		$settings = '<a href="'.RS_WOCT__PLUGIN_ADMIN_URL.'">Settings</a>';
		array_unshift( $links, $settings );
	}
	return $links;
}