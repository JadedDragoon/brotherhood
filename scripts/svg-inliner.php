<?php
/**
 * initialize sgv sanitizer
 * https://github.com/darylldoyle/svg-sanitizer
 */
use enshrined\svgSanitize\Sanitizer;

add_filter( 'the_content', 'svg_inliner' );
function svg_inliner( $content ) {
	if ( '' === $content ) return '';
	$post      = new DOMDocument();
	$sanitizer = new Sanitizer();
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
		$src_ext = pathinfo( $src_url, PATHINFO_EXTENSION );
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
		$svg_local_path = WP_CONTENT_DIR . substr( parse_url( $src_url, PHP_URL_PATH ), strpos( parse_url( $src_url, PHP_URL_PATH ), 'wp-content/', 1 ) + 10 );
		$clean_svg      = $sanitizer->sanitize( file_get_contents( $svg_local_path ) );
		/* phpcs:ignore Generic.ControlStructures.InlineControlStructure.NotAllowed */
		if ( ! $clean_svg ) {
			$i--;
			continue;
		}
		$svg->loadXML( $clean_svg );

		// swap svg in for image
		$img->parentNode->replaceChild(
			$post->importNode(
				$svg->getElementsByTagName( 'svg' )->item( 0 ),
				true
			),
			$img
		);

		// inc loop counter
		$i--;
	};

	return $post->saveHTML();
}

add_action( 'wp_footer', 'svg_fill' );
function svg_fill() {
	echo '<svg height="8" width="8" xmlns="http://www.w3.org/2000/svg" version="1.1"> <defs> <pattern id="crosshatch" patternUnits="userSpaceOnUse" width="8" height="8"> <image xlink:href="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHdpZHRoPSc4JyBoZWlnaHQ9JzgnPgogIDxyZWN0IHdpZHRoPSc4JyBoZWlnaHQ9JzgnIGZpbGw9JyNmZmYnLz4KICA8cGF0aCBkPSdNMCAwTDggOFpNOCAwTDAgOFonIHN0cm9rZS13aWR0aD0nMC41JyBzdHJva2U9JyNhYWEnLz4KPC9zdmc+Cg==" x="0" y="0" width="8" height="8"> </image> </pattern> </defs> </svg>';
}
