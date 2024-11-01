<?php

if( !defined( 'ABSPATH' ) ) { exit; }

function rs_woct_output() {
	if( ( !is_admin() ) && ( strpos( $_SERVER['REQUEST_URI'], 'wp-login' ) == FALSE ) ) {
		$option = rs_woct_get_option();
		$redirect_url = $option['redirect_url'];
		$website_open = $option['website_open'];
		if( ( $option['redirect_url'] == '' ) && ( $website_open != 'yes' ) ) {
			$proceed = rs_woct_proceed( $option );
			if( $proceed != 1 ) {
				$closed = get_stylesheet_directory().'/closed.php';
				$closed_message = $option['closed_message'];
				$closed_html = $option['closed_html'];
				$closed_html = str_replace( '&quot;', '"', str_replace( '&gt;', '>', str_replace( '&lt;', '<', $closed_html ) ) );
				if( file_exists( $closed ) == TRUE ) { include( $closed ); exit(); }
				elseif( $closed_html != '' ) { echo stripslashes( ltrim( rtrim( $closed_html ) ) ); exit(); }
				else {
					if( $closed_message != '' ) { $message = stripslashes( $closed_message ); }
					else { $message = 'Website not found.'; }
					$args = array( 'response' => 404 );
					$title = rtrim( $message, "." ).' | '.get_bloginfo( 'name', 'display' );
					wp_die( $message, $title, $args );
				}
			}
		} else { return; }
	}
}

function rs_woct_redirect() {
	if( ( !is_admin() ) && ( strpos( $_SERVER['REQUEST_URI'], 'wp-login' ) == FALSE ) ) {
		$option = rs_woct_get_option();
		$redirect_url = $option['redirect_url'];
		$website_open = $option['website_open'];
		if( ( $option['redirect_url'] != '' ) && ( $website_open != 'yes' ) ) {
			$redirect_get = wp_remote_get( esc_url_raw( $redirect_url, array( 'http', 'https' ) ), array( 'user-agent' => '' ) );
			if( ( !is_wp_error( $redirect_get ) ) && ( $redirect_get['response']['code'] == 200 ) ) {
				$proceed = rs_woct_proceed( $option );
				if( $proceed != 1 ) { wp_redirect( $redirect_url, 302 ); exit(); }
			} elseif( is_wp_error( $redirect_get ) ) {
				$error_message = $redirect_get->get_error_message();
				echo 'Something went wrong: <strong>'.$error_message.'</strong><br />';
				echo 'There\'s a problem with your redirect URL, please try another.'; exit();
			} else {
				echo 'Redirect response code: <strong>'.$redirect_get['response']['code'].' '.$redirect_get['response']['message'].'</strong><br />';
				echo 'There\'s a problem with your redirect URL, please try another.'; exit();
			}
		} else { return; }
	}
}

function rs_woct_proceed( $option ) {
	$proceed = 0;
	$bypass_paths = $option['bypass_paths'];
	$bypass_paths = explode( "\n", $bypass_paths );
	$bypass_get_key = $option['bypass_get_key'];
	rs_woct_set_bypass_sustain( $bypass_get_key );
	if( is_user_logged_in() == TRUE ) { $proceed = 1; }
	elseif( ( isset( $_SESSION[$bypass_get_key] ) ) && ( $_SESSION[$bypass_get_key] == 1 ) ) { $proceed = 1; }
	elseif( ( is_array( $bypass_paths ) ) && ( !empty( $bypass_paths ) ) ) {
		$path = rs_woct_get_current_path();
		foreach( $bypass_paths as $key => $value ) { if( $proceed != 1 ) { if( $value == $path['path'] ) { $proceed = 1; } } }
	}
	return $proceed;
}

function rs_woct_set_bypass_sustain( $bypass_get_key ) {
	if( did_action( 'template_redirect' ) === 1 ) {
		if( session_status() === PHP_SESSION_NONE ) { session_start(); }
		if( ( is_array( $_GET ) ) && ( isset( $_GET[$bypass_get_key] ) ) ) {
			if( $_GET[$bypass_get_key] == '1' ) { $_SESSION[$bypass_get_key] = 1; }
			elseif( $_GET[$bypass_get_key] == 'unset' ) { unset( $_SESSION[$bypass_get_key] ); }
		}
	}
}