<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

add_action( 'wp_enqueue_scripts', 'brotherhood_enqueue_styles' );
function brotherhood_enqueue_styles() {

	# set enqueue names
	$parent_style = 'twentyseventeen-style';
	$child_style  = 'brotherhood-style';

	# init needed vars
	$style_deps = array();
	$theme_dir  = get_stylesheet_directory_uri();
	$parent_dir = get_template_directory_uri();

	/**********************
	 * Style Dependencies *
	 **********************/

	# plugin styles
	$plugin_style_array = array(
		'asgaros-forum' => 'asgaros-forum/asgaros-forum.php',
	);

	# load plugin styles
	foreach ( $plugin_style_array as $key => $value ) {
		if ( is_plugin_active( $value ) ) {
			wp_enqueue_style(
				$key,
				$theme_dir . '/plugins/' . $key . '/style.css.php'
			);
			array_push( $style_deps, $key );
		}
	}

	# load parent theme
	wp_enqueue_style( $parent_style, $theme_dir . '/style.css' );
	array_push( $style_deps, $parent_style );

	/***************************
	 * JavaScript Dependencies *
	 ***************************/

	# custom javascript files
	$plugin_script_array = array(
		'one-page' => 'one-page.js',
	);

	/**********
	 * Finish *
	 **********/
	/**
	 * https://wordpress.org/support/topic/best-way-to-create-a-css-file-dynamically/page/2/
	 * For importing WordPress functions into dynamic css
	 */
	wp_enqueue_style(
		'dynamic-css',
		admin_url( 'admin-ajax.php' ) . '?action=dynamic_css',
		$style_deps,
		wp_get_theme()->get( 'Version' )
	);
	add_action( 'wp_ajax_dynamic_css', 'dynaminc_css' );
	add_action( 'wp_ajax_nopriv_dynamic_css', 'dynaminc_css' );
	function dynaminc_css() {
		require( get_stylesheet_directory() . '/style.css.php' );
		exit;
	}

	# load this style
	/* wp_enqueue_style(
		$child_style,
		get_stylesheet_directory_uri() . '/style.css.php',
		$style_deps,
		wp_get_theme()->get( 'Version' )
	);*/
}



add_filter( 'wp_nav_menu_items', 'add_login_logout_link', 10, 2 );
function add_login_logout_link( $items, $args ) {
	ob_start();
	wp_loginout( 'index.php' );
	$log_in_out_link = ob_get_contents();
	ob_end_clean();
	$items .= '<li id="login-out-link" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-65">' . $log_in_out_link . '</li>';
	return $items;
}

