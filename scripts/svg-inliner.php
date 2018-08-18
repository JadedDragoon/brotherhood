<?php
/* https://github.com/darylldoyle/svg-sanitizer */
use enshrined\svgSanitize\Sanitizer;

add_filter( 'the_content', 'svg_inliner' );
function svg_inliner( $content ) {
	if ( '' === $content ) return '';
	$post      = new DOMDocument();
	$sanitizer = new Sanitizer();
	$sanitizer->removeRemoteReferences( true );

	$post->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' ) );
	$img_list = $post->getElementsByTagName( 'img' );

	/* regressive loop because http://php.net/manual/en/domnode.replacechild.php#50500 */
	$i = $img_list->length - 1;
	while ( $i > -1 ) {
		$img     = $img_list->item( $i );
		$src_url = parse_url( $img->getAttribute( 'src' ), PHP_URL_PATH );
		$src_ext = pathinfo( $src_url, PATHINFO_EXTENSION );
		if ( 'svg' !== $src_ext ) { $i--; continue; } /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace, Generic.Formatting.DisallowMultipleStatements.SameLine */

		// no x-site monkey business
		$svg_host  = parse_url( $img->getAttribute( 'src' ), PHP_URL_HOST );
		$this_host = parse_url( get_site_url(), PHP_URL_HOST );
		if ( $this_host !== $svg_host ) { $i--; continue; } /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace, Generic.Formatting.DisallowMultipleStatements.SameLine */

		$svg_local_path = WP_CONTENT_DIR . substr(
			parse_url( $src_url, PHP_URL_PATH ),
			strpos( parse_url( $src_url, PHP_URL_PATH ), 'wp-content/', 1 ) + 10
		);

		// load the SVG and parse it (and sanitize... obv)
		if ( ! file_exists( $svg_local_path ) ) { $i--; continue; } /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace, Generic.Formatting.DisallowMultipleStatements.SameLine */
		$clean_svg = $sanitizer->sanitize( file_get_contents( $svg_local_path ) );
		if ( ! $clean_svg ) { $i--; continue; } /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace, Generic.Formatting.DisallowMultipleStatements.SameLine */
		$svg = new DOMDocument();
		$svg->loadXML( mb_convert_encoding( $clean_svg, 'HTML-ENTITIES', 'UTF-8' ) );

		// replace img with svg
		$img->parentNode->replaceChild( /* phpcs:ignore WordPress.NamingConventions.ValidVariableName.NotSnakeCaseMemberVar */
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
