<?php

if( !defined( 'ABSPATH' ) ) { exit; }

function rs_woct_option_defaults() {
	$array = array(
		'website_open' => 'yes',
		'redirect_url' => '',
		'closed_message' => 'Our website is currently closed. Please try again soon.',
		'closed_html' => '',
		'bypass_paths' => '',
		'bypass_get_key' => 'bypass_',
		'delete_option_on_deactivate' => '0',
	);
	return $array;
}

function rs_woct_get_option() {
	return get_option( RS_WOCT__OPTION );
}

function rs_woct_update_option( $new_option ) {
	$update = update_option( RS_WOCT__OPTION, $new_option );
	return $update;
}

function rs_woct_option_exists() {
	if( !rs_woct_get_option() ) { return FALSE; }
	else { return TRUE; }
}

function rs_woct_update_settings() {
	if( array_key_exists( '_wpnonce', $_POST ) ) {
		if( !wp_verify_nonce( $_POST['_wpnonce'], 'rs_woct_update_settings' ) ) { return; }
		else {
			$option = rs_woct_get_option();
			$new_option = array();
			$new_option['website_open'] = sanitize_text_field( $_POST['website_open'] );
			$new_option['redirect_url'] = esc_url_raw( $_POST['redirect_url'], array( 'http', 'https' ) );
			$new_option['closed_message'] = sanitize_text_field( $_POST['closed_message'] );
			$new_option['closed_html'] = str_replace( "\n", '---NEWLINE---', $_POST['closed_html'] );
			$new_option['closed_html'] = str_replace( "\t", '---TAB---', $new_option['closed_html'] );
			$new_option['closed_html'] = str_replace( "\r", '', $new_option['closed_html'] );
			$new_option['closed_html'] = esc_html( $new_option['closed_html'] );
			$new_option['closed_html'] = str_replace( '---TAB---', "\t", $new_option['closed_html'] );
			$new_option['closed_html'] = str_replace( '---NEWLINE---', "\n", $new_option['closed_html'] );
			$new_option['bypass_paths'] = str_replace( "\n", '---NEWLINE---', $_POST['bypass_paths'] );
			$new_option['bypass_paths'] = str_replace( "\t", '', $new_option['bypass_paths'] );
			$new_option['bypass_paths'] = str_replace( "\r", '', $new_option['bypass_paths'] );
			$new_option['bypass_paths'] = esc_html( $new_option['bypass_paths'] );
			$new_option['bypass_paths'] = str_replace( '---NEWLINE---', "\n", $new_option['bypass_paths'] );
			$new_option['bypass_get_key'] = sanitize_text_field( $_POST['bypass_get_key'] );
			if( array_key_exists( 'delete_option_on_deactivate', $_POST ) ) { $new_option['delete_option_on_deactivate'] = sanitize_text_field( $_POST['delete_option_on_deactivate'] ); }
			else { $new_option['delete_option_on_deactivate'] = $option['delete_option_on_deactivate']; }
			foreach( $new_option as $key => $value ) {
				if( $value !== $option[$key] ) {
					$update_option = 1;
					if( $key == 'website_open' ) {
						$delete_cache = 1;
					}
				}
			}
			if( isset( $update_option ) ) {
				if( $update_option == 1 ) {
					$update = rs_woct_update_option( $new_option );
					if( isset( $delete_cache ) ) {
						if( $delete_cache == 1 ) {
							if( function_exists( 'w3tc_pgcache_flush' ) ) { w3tc_pgcache_flush(); } // delete w3 total cache content
							if( function_exists( 'wp_cache_clear_cache' ) ) { wp_cache_clear_cache(); } // delete wp super cache content
						}
					}
					return $update;
				}
			}
		}
	}
}