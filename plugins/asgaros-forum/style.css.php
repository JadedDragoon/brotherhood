<?php
	ob_start( 'ob_gzhandler' );
	header( 'Content-type: text/css; charset: UTF-8' );
	header( 'Cache-Control: must-revalidate' );
	$offset = 60 * 60;

	$expire_string = 'Expires: ' . gmdate(
		'D, d M Y H:i:s',
		time() + $offset
	) . ' GMT';
	header( $expire_string );

	// for highlighting
	// phpcs:disable
	if ( FALSE ) { ?><style><?php }
?>
