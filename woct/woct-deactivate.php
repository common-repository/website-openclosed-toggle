<?php

if( !defined( 'ABSPATH' ) ) { exit; }

function rs_woct_deactivate() {
	$option = rs_woct_get_option();
	if( $option['delete_option_on_deactivate'] === '1' ) {
		delete_option( RS_WOCT__OPTION );
	}
}