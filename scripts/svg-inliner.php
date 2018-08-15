<?php
/**
 * initialize sgv sanitizer
 * https://github.com/darylldoyle/svg-sanitizer
 */
use enshrined\svgSanitize\Sanitizer;

add_filter( 'the_content', 'svg_inliner' );
function svg_inliner( $content ) {
	if ( '' === $content ) return '';
	$post       = new DOMDocument();
	$sanitizer  = new Sanitizer();
	$sanitizer->removeRemoteReferences( true );

	$post->loadHTML( $content );
	$img_list = $post->getElementsByTagName( 'img' );

	/**
	 * Iteration time
	 * (regressive loop because http://php.net/manual/en/domnode.replacechild.php#50500)
	*/
	$i = $img_list->length - 1;
	while ( $i > -1 ) {
		$img     = $img_list->item( $i );
		$src_url = parse_url( $img->getAttribute( 'src' ), PHP_URL_PATH );
		$src_ext = pathinfo( $scr_url, PATHINFO_EXTENSION );
		if ( 'svg' !== $src_ext ) {
			$i--;
			continue;
		}

		$svg_host  = parse_url( $img->getAttribute( 'src' ), PHP_URL_HOST );
		$this_host = parse_url( get_site_url(), PHP_URL_HOST );
		if ( $this_host !== $svg_host ) {
			$i--;
			continue; // no x-site monkey business
		}
		$svg = new DOMDocument();

		// load the SVG and parse it (and sanitize... obv)
		$svg_local_path = ABSPATH . parse_url( $src, PHP_URL_PATH );
		$clean_svg      = $sanitizer->sanitize( file_get_contents( $svg_local_path ) );
		/* phpcs:ignore Generic.ControlStructures.InlineControlStructure.NotAllowed */
		if ( ! $clean_svg ) {
			$i--;
			continue;
		}
		$svg->loadXML( $clean_svg );

		// swap svg in for image
		$img->parentNode->replaceChild( $svg, $img );

		// inc loop counter
		$i--;
	};

	return $post->saveHTML();
}
