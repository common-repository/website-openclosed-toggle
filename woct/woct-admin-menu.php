<?php

if( !defined( 'ABSPATH' ) ) { exit; }

function rs_woct_setup_menu() {
	add_menu_page(
		RS_WOCT__PLUGIN_NAME,
		RS_WOCT__PLUGIN_SHORT_NAME,
		RS_WOCT__ADMIN_REQCAP,
		RS_WOCT__ADMIN_PAGE,
		RS_WOCT__ADMIN_FUNC,
		RS_WOCT__PLUGIN_ICON,
		RS_WOCT__PLUGIN_MENU_POS
	);
}