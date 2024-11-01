<?php

if( !defined( 'ABSPATH' ) ) { exit; }

function rs_woct_activate() {
	if( !rs_woct_option_exists() ) {
		$option = rs_woct_option_defaults();
		add_option( RS_WOCT__OPTION, $option );
	}
}