<?php
add_action( 'wp_enqueue_scripts', 'brotherhood_enqueue_styles' );
function brotherhood_enqueue_styles() {

	# set enqueue names
	$parent_style = 'twentyseventeen-style';
	$child_style  = 'brotherhood-style';

	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( $child_style,
		get_stylesheet_directory_uri() . '/style.css',
		array( $parent_style ),
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
