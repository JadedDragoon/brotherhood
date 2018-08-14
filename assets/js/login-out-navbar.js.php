<?php
	header( 'Content-type: text/javascript; charset: UTF-8' );

	// for highlighting
	// phpcs:disable
	if ( FALSE ) { ?><script><?php }
?>

jQuery( document ).ready(() => {

	jQuery( "nav#site-navigation" )
		.find("a[href='<?php echo get_site_url(); ?>/login']")
		.parent()
		.hide();

});
