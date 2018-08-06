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
