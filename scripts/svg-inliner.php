<?php
/**
 * initialize sgv sanitizer
 * https://github.com/darylldoyle/svg-sanitizer
 */
use enshrined\svgSanitize\Sanitizer;

add_filter( 'the_content', 'svg_inliner' );
function svg_inliner( $content ) {
	$post       = new DOMDocument();
	$sanitizer  = new Sanitizer();
	$sanitizer->removeRemoteReferences( true );

	$post->loadHTML( $content );
	$img_array = array_filter( $post->getElementsByTagName( 'img' ), function( $img_tag ) {
		$ext = pathinfo( parse_url( $img_tag->getAttribute( 'src' ), PHP_URL_PATH ), PATHINFO_EXTENSION );
		/* phpcs:ignore Generic.ControlStructures.InlineControlStructure.NotAllowed */
		if ( 'svg' === $ext ) return true;
	} );

	/**
	 * Iteration time
	 * (regressive loop because http://php.net/manual/en/domnode.replacechild.php#50500)
	*/
	$i = $img_array->length - 1;
	while ( $i > -1 ) {
		$img       = $img_array->item( $i );
		$src_url   = $img->getAttribute( 'src' );
		$svg_host  = parse_url( $src_url, PHP_URL_HOST );
		$this_host = parse_url( get_site_url(), PHP_URL_HOST );
		/* phpcs:ignore Generic.ControlStructures.InlineControlStructure.NotAllowed */
		if ( $this_host !== $svg_host ) continue; // no x-site monkey business
		$svg = new DOMDocument();

		// load the SVG and parse it (and sanitize... obv)
		$svg_local_path = ABSPATH . parse_url( $src, PHP_URL_PATH );
		$clean_svg      = $sanitizer->sanitize( file_get_contents( $svg_local_path ) );
		/* phpcs:ignore Generic.ControlStructures.InlineControlStructure.NotAllowed */
		if ( ! $clean_svg ) continue;
		$svg->loadXML( $clean_svg );

		// swap svg in for image
		$img->parentNode->replaceChild( $svg, $img );

		// inc loop counter
		$i--;
	};

	return $post->saveHTML();
}
