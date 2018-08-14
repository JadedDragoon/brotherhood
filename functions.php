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
		'cond' => true,
		'type' => 'style',
	],
];

# explicitly add theme style to ajax imports
add_action( 'wp_ajax_brotherhood_css', 'brotherhood_dynamic' );
add_action( 'wp_ajax_brotherhood_css', 'brotherhood_dynamic' );
function brotherhood_dynamic() {
	global $bos_local_dir;
	require( $bos_local_dir . '/style.css.php' );
	exit;
}

# add dynamic styles and scripts to ajax imports
foreach ( $bos_dynamic_imports as $import_name => $bos_import_options ) {
	if ( $bos_import_options['cond'] ) {
		error_log( print_r( $bos_import_options, true ) );
		# define axaj include function
		function dynamic_import() {
			global $bos_local_dir,$bos_dynamic_imports;
			require( $bos_local_dir . '/' . $bos_dynamic_imports[ sanitize_key( $_GET['import_name'] ) ]['path'] );
			exit;
		};

		# register ajax action
		add_action( 'wp_ajax_dynamic_import', 'dynamic_import' );
		add_action( 'wp_ajax_nopriv_dynamic_import', 'dynamic_import' );

		# add to dependencies
		switch ( $bos_import_options['type'] ) {
			case 'style':
				$bos_style_deps[] = $import_name;
				break;
			case 'script':
				$bos_script_deps[] = $import_name;
				break;
			default:
				throw new Exception( 'Unknown import type: ' . $bos_import_options['type'] . ' for ' . $import_name );
		}
	}
}
unset( $import_name, $bos_import_options );

# load theme
add_action( 'wp_enqueue_scripts', 'brotherhood_enqueue_styles' );

function brotherhood_enqueue_styles() {
	global $bos_style_deps, $bos_script_deps, $bos_theme_dir, $bos_parent_dir, $bos_dynamic_imports;

	# set enqueue names
	$parent_style = 'twentyseventeen-style';
	$child_style  = 'brotherhood-style';

	/**********************
	 * Style Dependencies *
	 **********************/

	# plugin styles
	$plugin_style_array = array(
		'asgaros-forum' => 'asgaros-forum/asgaros-forum.php',
	);

	# font styles
	$font_style_array = array(
		'destroy_regular',
		'topsecret_bold',
	);

	# load plugin styles
	foreach ( $plugin_style_array as $key => $value ) {
		if ( is_plugin_active( $value ) ) {
			wp_enqueue_style(
				$key,
				$bos_theme_dir . '/plugins/' . $key . '/style.css',
				array(),
				wp_get_theme()->get( 'Version' )
			);
			array_push( $bos_style_deps, $key );
		}
	}
	unset( $key, $value );

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

	/***************************
	 * JavaScript Dependencies *
	 ***************************/

	# javascript files
	$script_array = array(
		'one-page',
	);

	# load scripts
	foreach ( $script_array as $value ) {
		wp_enqueue_script(
			$value,
			$bos_theme_dir . '/assets/js/' . $value . '/script.js',
			array(),
			wp_get_theme()->get( 'Version' )
		);
		array_push( $bos_script_deps, $value );
	}
	unset( $value );

	/************************
	 * Dynamic Dependencies *
	 ************************/

	foreach ( $bos_dynamic_imports as $import_name => $bos_import_options ) {
		if ( $bos_import_options['cond'] ) {
			switch ( $bos_import_options['type'] ) {
				case 'style':
					wp_enqueue_style(
						$import_name,
						admin_url( 'admin-ajax.php' ) . '?action=dynamic_import&import_name=' . $import_name,
						isset( $bos_import_options['deps'] ) ? $bos_import_options['deps'] : array(),
						wp_get_theme()->get( 'Version' )
					);
					break;
				case 'script':
					wp_enqueue_scripts(
						$import_name,
						admin_url( 'admin-ajax.php' ) . '?action=dynamic_import&import_name=' . $import_name,
						isset( $bos_import_options['deps'] ) ? $bos_import_options['deps'] : array(),
						wp_get_theme()->get( 'Version' )
					);
					break;
				default:
					throw new Exception( 'Unknown import type: ' . $bos_import_options['type'] . ' for ' . $import_name . '. Previous check missed!' );
			}
		}
	}
	unset( $import_name, $bos_import_options );

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
