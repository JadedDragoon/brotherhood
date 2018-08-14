<?php
	header( 'Content-type: text/css; charset: UTF-8' );

	// for highlighting
	// phpcs:disable
	if ( FALSE ) { ?><style type="text/css"><?php }
?>

a.anchor {
	display: block;
	position: relative;
	top: <?php echo ( is_admin_bar_showing() ? '-104px' : '-72px' ); ?>;
	visibility: hidden;
}
