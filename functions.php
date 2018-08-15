<?php
require __DIR__ . '/vendor/autoload.php';
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( get_stylesheet_directory() . '/scripts/import-theme.php' );
require_once( get_stylesheet_directory() . '/scripts/svg-inliner.php' );

add_filter( 'wp_nav_menu_items', 'add_login_logout_link', 10, 2 );
function add_login_logout_link( $items, $args ) {
	ob_start();
	wp_loginout( 'index.php' );
	$log_in_out_link = ob_get_contents();
	ob_end_clean();
	$items .= '<li id="login-out-link" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-65">' . $log_in_out_link . '</li>';
	return $items;
}
