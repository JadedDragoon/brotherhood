<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
/**
 * https://wordpress.org/support/topic/best-way-to-create-a-css-file-dynamically/page/2/
 * For importing WordPress functions into dynamic css
 */

# init needed vars
$bos_style_deps  = [];
$bos_script_deps = [];
$bos_theme_dir   = get_stylesheet_directory_uri();
$bos_local_dir   = get_stylesheet_directory();
$bos_parent_dir  = get_template_directory_uri();

$bos_dynamic_imports = [
	'front-page' => [
		'path' => 'assets/css/front-page.css.php',
		'cond' => function() {
			return is_front_page();
		},
		'type' => 'style',
	],

	'one-page'  => [
		'path' => 'assets/js/one-page.js.php',
		'cond' => function() {
			return is_front_page();
		},
		'type' => 'script',
	],

	'login-out-navbar' => [
		'path' => 'assets/js/login-out-navbar.js.php',
		'cond' => is_user_logged_in(),
		'type' => 'script',
	],
];

$bos_plugin_imports = [
	'asgaros-forum' => [
		'plugin_path' => 'asgaros-forum/asgaros-forum.php',
		'type'        => 'style',
		'cond'        => true,
	],
];

# explicitly add theme style to ajax imports
add_action( 'wp_ajax_brotherhood_css', 'brotherhood_dynamic' );
add_action( 'wp_ajax_nopriv_brotherhood_css', 'brotherhood_dynamic' );
function brotherhood_dynamic() {
	global $bos_local_dir;
	require( $bos_local_dir . '/style.css.php' );
	exit;
}

# add dynamic styles and scripts to ajax imports
add_action( 'wp_ajax_dynamic_import', 'bos_dynamic_import' );
add_action( 'wp_ajax_nopriv_dynamic_import', 'bos_dynamic_import' );
foreach ( $bos_dynamic_imports as $import_name => $import_options ) {
	if ( $import_options['cond'] ) {
		bos_add_deps(
			$import_options['type'],
			$import_name
		);
	}
}
unset( $import_name, $import_options );

# add plugin styles and scripts to ajax imports
add_action( 'wp_ajax_plugin_import', 'bos_plugin_import' );
add_action( 'wp_ajax_nopriv_plugin_import', 'bos_plugin_import' );
foreach ( $bos_plugin_imports as $import_name => $import_options ) {
	if ( $import_options['cond'] && is_plugin_active( $import_options['plugin_path'] ) ) {
		bos_add_deps(
			$import_options['type'],
			$import_name
		);
	}
}
unset( $import_name, $import_options );

# load theme
add_action( 'wp_enqueue_scripts', 'brotherhood_enqueue_styles' );

function bos_dynamic_import() {
	global $bos_local_dir,$bos_dynamic_imports;
	require( $bos_local_dir . '/' . $bos_dynamic_imports[ sanitize_key( $_GET['import_name'] ) ]['path'] );
	exit;
};

function bos_plugin_import() {
	global $bos_local_dir,$bos_plugin_imports;
	$import_name    = sanitize_key( $_GET['import_name'] );
	$import_options = $bos_plugin_imports[ $import_name ];
	$file_path      = $bos_local_dir . '/plugins/' . sanitize_file_name( $import_name );

	switch ( $import_options['type'] ) {
		case 'style':
			require( $file_path . '/style.css.php' );
			break;
		case 'script':
			require( $file_path . '/script.js.php' );
			break;
		default:
			throw new Exception( 'Unknown import type: ' . $import_options['type'] . ' for ' . $import_name );
	}
	exit;
};

function brotherhood_enqueue_styles() {
	global
		$bos_style_deps,
		$bos_script_deps,
		$bos_theme_dir,
		$bos_parent_dir,
		$bos_dynamic_imports,
		$bos_plugin_imports;

	# set enqueue names
	$parent_style = 'twentyseventeen-style';
	$child_style  = 'brotherhood-style';

	/**********************
	 * Style Dependencies *
	 **********************/

	# font styles
	$font_style_array = [
		'destroy_regular',
		'topsecret_bold',
	];

	# load font styles
	foreach ( $font_style_array as $value ) {
		wp_enqueue_style(
			$value,
			$bos_theme_dir . '/assets/fonts/' . $value . '/stylesheet.css',
			array(),
			wp_get_theme()->get( 'Version' )
		);
		array_push( $bos_style_deps, $value );
	}
	unset( $value );

	# load parent theme
	wp_enqueue_style( $parent_style, $bos_parent_dir . '/style.css' );
	array_push( $bos_style_deps, $parent_style );

	/************************
	 * Dynamic Dependencies *
	 ************************/

	foreach ( $bos_dynamic_imports as $import_name => $import_options ) {
		if ( $import_options['cond'] ) {
			bos_do_ajax_import(
				$import_options['type'],
				$import_name,
				isset( $import_options['deps'] )
					? $import_options['deps']
					: array()
			);
		}
	}
	unset( $import_name, $import_options );

	foreach ( $bos_plugin_imports as $import_name => $import_options ) {
		if ( $import_options['cond'] ) {
			bos_do_ajax_import(
				$import_options['type'],
				$import_name,
				isset( $import_options['deps'] )
					? $import_options['deps']
					: array(),
				true
			);
		}
	}
	unset( $import_name, $import_options );

	/**********
	 * Finish *
	 **********/

	# load theme style
	wp_enqueue_style(
		$child_style,
		/*get_stylesheet_directory_uri() . '/style.css.php',*/
		admin_url( 'admin-ajax.php' ) . '?action=brotherhood_css',
		$bos_style_deps,
		wp_get_theme()->get( 'Version' )
	);
}

function bos_do_ajax_import( $type, $name, $deps, $plugin = false ) {
	$url          = admin_url( 'admin-ajax.php' ) . '?action=' . ( $plugin ? 'plugin' : 'dynamic' ) . '_import&import_name=' . $name;
	$dependencies = isset( $deps ) ? $deps : array();
	#$version      =

	switch ( $type ) {
		case 'style':
			wp_enqueue_style(
				$name,
				$url,
				$dependencies,
				wp_get_theme()->get( 'Version' )
			);
			break;
		case 'script':
			wp_enqueue_script(
				$name,
				$url,
				$dependencies,
				wp_get_theme()->get( 'Version' )
			);
			break;
		default:
			throw new Exception( 'Unknown import type: ' . $type . ' for ' . $name . '. Previous check missed!' );
	}
}

function bos_add_deps( $type, $name ) {
	global $bos_style_deps,$bos_script_deps;
	switch ( $type ) {
		case 'style':
			$bos_style_deps[] = $name;
			break;
		case 'script':
			$bos_script_deps[] = $name;
			break;
		default:
			throw new Exception( 'Unknown import type: ' . $type . ' for ' . $name );
	}
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

/*************
 * Functions *
 *************/
/*if ( is_front_page() ) {*/
	/* Front Page Only Css */
	/*'
a.anchor {
	display: block;
	position: relative;
	top: <?php echo ( is_admin_bar_showing() ? '-96px' : '-72px' ); ?>;
	visibility: hidden;
}'
}*/
