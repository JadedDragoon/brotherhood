<?php
	header( 'Content-type: text/css; charset: UTF-8' );


	/*************
	 * Variables *
	 *************/
	$font_family = '
		destroyregular,
		"Libre Franklin",
		"Helvetica Neue",
		helvetica,
		arial,
		sans-serif';

	$color_dark_text     = '#000000';
	$color_light_text    = '#FFFFFF';
	$color_lightish_text = '#CCCCCC';

	$stroke_dark_text  = '
		-1px -1px 0 #FFF,
		 1px -1px 0 #FFF,
		-1px  1px 0 #FFF,
		 1px  1px 0 #FFF';
	$stroke_light_text = '
		-1px -1px 0 #000,
		 1px -1px 0 #000,
		-1px  1px 0 #000,
		 1px  1px 0 #000';
	$stroke_light_svg  = '
		drop-shadow(-1px -1px 0 #FFF)
		drop-shadow( 1px -1px 0 #FFF)
		drop-shadow(-1px  1px 0 #FFF)
		drop-shadow( 1px  1px 0 #FFF)';

	$anti_glow_text = '
		-0.1875em -0.1875em 1.25em #666,
		-0.1875em  0.1875em 1.25em #666,
		 0.1875em -0.1875em 1.25em #666,
		 0.1875em  0.1875em 1.25em #666';
	$anti_glow_svg  = '
		drop-shadow(0 0 1.25em #666)
		drop-shadow(0 0 1.25em #666)';

	// for highlighting
	// phpcs:disable
	if ( FALSE ) { ?><style><?php }
?>

body.attachment p.attachment svg {
	fill: url(#crosshatch);
}

.so_widget_sow_editor p:last-child {
	margin-bottom: 0;
}
.so-panel {
	padding-bottom: 0;
}

figure.wp-block-embed-youtube.aligncenter iframe {
	display: block;
	margin: 0 auto;
}

#contact-form .sow-contact-form > p,
#contact-form .sow-form-field-description,
#contact-form .sow-recaptcha > div,
#contact-form .sow-submit-wrapper input {
	margin-left: 1em;
}

#tscta .sow-cta-base {
	border-radius: 1em;
}
#tscta .sow-cta-title {
	position: relative;
	top: 9.6px;
	font-family: <?=$font_family?>;
	font-size: 2em;
}
#tscta .ow-icon-placement-left > span {
	font-family: <?=$font_family?>;
}
#tscta .sow-cta-subtitle {
	display: none;
}

.navigation-top,
.entry-title,
.site-branding-text {
	font-family: <?=$font_family?>;
}

.colors-dark .page .panel-content .entry-title {
	color: <?=$color_dark_text?> !important;
	text-shadow: <?=$stroke_dark_text?>;
}

.widget_media_image img {
	border: solid 1px rgba(255, 255, 255, 0.25);
}

.colors-dark .so-widget-sow-editor h3 {
	font-family: <?=$font_family?>;
	color: <?=$color_lightish_text?>;
}

.page-title,
.page .panel-content .entry-title,
body.page:not(.twentyseventeen-front-page) .entry-title {
	font-size: 1.25rem;
}

header.entry-header .edit-link,
body.home #main article:first-of-type header.entry-header {
	display: none;
}

body.has-header-image .site-title,
body.has-header-video .site-title,
body.has-header-image .site-title a,
body.has-header-video .site-title a,
nav#site-navigation li.menu-item a:hover {
	color: <?=$color_dark_text?>;
	text-shadow: <?=$stroke_dark_text?>,<?=$anti_glow_text?>;
}

body.has-header-image .site-description,
body.has-header-video .site-description {
	color: <?=$color_light_text?>;
	opacity: 100%;
	text-shadow: <?=$stroke_light_text?>,<?=$anti_glow_text?>;
}

nav#site-navigation a.menu-scroll-down svg {
	color: white;
}
nav#site-navigation a.menu-scroll-down:hover svg {
	color: <?=$color_dark_text?>;
	-webkit-filter: <=$stroke_lightish_svg?><=$anti_glow_svg?>;
	filter: <=$stroke_light_svg?><=$anti_glow_svg?>;
}

.navigation-top a {
	transition-property: color, filter, text-shadow;
}

a.custom-logo-link {
	display: none;
}

@media screen and (min-width: 30em) {
	.panel-content .entry-header {
		margin-bottom: 3.5em;
	}

	.page-one-column .panel-content .wrap {
		max-width: none;
	}
}

@media screen and (min-width: 48em) {
	.panel-image {
		max-height: 400px;
	}

	.page.page-one-column .entry-header,
	.twentyseventeen-front-page.page-one-column .entry-header,
	.archive.page-one-column:not(.has-sidebar) .page-header {
		margin-bottom: 3em;
	}

	a.custom-logo-link {
		display: inline-block;
	}
}

@media screen and (min-width: 55em) {
	#login-out-link {
		position: absolute;
		right: 50px;
	}

	.wrap {
		max-width: 1000px;
		padding-left: 3em;
		padding-right: 3em;
	}
}

@media screen and (min-width: 64em) {
	/* Layout */
	.page-one-column .panel-content .wrap,
	.wrap {
		max-width: 1500px !important;
	}
}

/*******************************************************************************
***************************************************************** Width Fixes **
*******************************************************************************/
.single-post:not(.has-sidebar) #primary,
.page.page-one-column:not(.twentyseventeen-front-page) #primary,
.archive.page-one-column:not(.has-sidebar) .page-header,
.archive.page-one-column:not(.has-sidebar) #primary {
	max-width: 1500px;
}

@media screen and (min-width: 48em) {
	.has-header-image.twentyseventeen-front-page .custom-header,
	.has-header-video.twentyseventeen-front-page .custom-header,
	.has-header-image.home.blog .custom-header,
	.has-header-video.home.blog .custom-header {
		display: table;
		height: 300px;
		height: 75vh;
	}

	.admin-bar.twentyseventeen-front-page.has-header-image .custom-header-media,
	.admin-bar.twentyseventeen-front-page.has-header-video .custom-header-media,
	.admin-bar.home.blog.has-header-image .custom-header-media,
	.admin-bar.home.blog.has-header-video .custom-header-media {
		height: auto;
	}

	.twentyseventeen-front-page.has-header-image .custom-header-media,
	.twentyseventeen-front-page.has-header-video .custom-header-media,
	.home.blog.has-header-image .custom-header-media,
	.home.blog.has-header-video .custom-header-media {
		height: auto;
		max-height: auto;
	}

	.twentyseventeen-front-page.has-header-image .custom-header-media:before,
	.twentyseventeen-front-page.has-header-video .custom-header-media:before,
	.home.blog.has-header-image .custom-header-media:before,
	.home.blog.has-header-video .custom-header-media:before {
		height: auto;
	}

	.custom-header-media {
		height: auto;
		position: absolute;
	}

	.wrap {
		max-width: 700px;
		padding-left: 2em;
		padding-right: 2em;
	}

	.custom-logo-link {
		padding-right: 1em;
	}

	.site-title {
		font-size: 24px;
		font-size: 1.5rem;
	}

	.login-out-link {
		float: right;
	}

	.site-description {
		font-size: 13px;
		font-size: 0.8125rem;
	}

	.navigation-top {
		font-size: 16px;
		font-size: 1rem;
		position: relative;
		bottom: auto;
		left: auto;
		right: auto;
		width: auto;
		z-index: auto;
	}

	.navigation-top .wrap {
		max-width: 1000px;
		padding: 0;
	}

	.navigation-top nav {
		margin-left: 0;
	}

	.js .menu-toggle, .js .dropdown-toggle {
		display: block;
	}

	.js .main-navigation ul, .js .main-navigation ul ul, .js .main-navigation > div > ul {
		display: none;
	}

	.main-navigation > div > ul {
		padding: 0.75em 1.695em;
		border-top: 1px solid #333;
	}

	.main-navigation li {
		display: block;
		border-bottom: 1px solid #eee;
		position: relative;
	}

	.main-navigation a {
		display: block;
		padding: 0.5em 0;
		text-decoration: none;
	}
}

@media screen and (min-width: 55em) {
	.has-header-image.twentyseventeen-front-page .custom-header,
	.has-header-video.twentyseventeen-front-page .custom-header,
	.has-header-image.home.blog .custom-header,
	.has-header-video.home.blog .custom-header {
		display: block;
		height: auto;
	}

	.admin-bar.twentyseventeen-front-page.has-header-image .custom-header-media,
	.admin-bar.twentyseventeen-front-page.has-header-video .custom-header-media,
	.admin-bar.home.blog.has-header-image .custom-header-media,
	.admin-bar.home.blog.has-header-video .custom-header-media {
		height: calc(100vh - 32px);
	}

	.twentyseventeen-front-page.has-header-image .custom-header-media,
	.twentyseventeen-front-page.has-header-video .custom-header-media,
	.home.blog.has-header-image .custom-header-media,
	.home.blog.has-header-video .custom-header-media {
		height: 1200px;
		height: 100vh;
		max-height: 100%;
		overflow: hidden;
	}

	.twentyseventeen-front-page.has-header-image .custom-header-media:before,
	.twentyseventeen-front-page.has-header-video .custom-header-media:before,
	.home.blog.has-header-image .custom-header-media:before,
	.home.blog.has-header-video .custom-header-media:before {
		height: 33%;
	}

	.custom-header-media {
		height: 165px;
		position: relative;
	}

	.wrap {
		max-width: 1000px;
		padding-left: 3em;
		padding-right: 3em;
	}

	.custom-logo-link {
		padding-right: 2em;
	}

	.site-title {
		font-size: 36px;
		font-size: 2.25rem;
	}

	.site-description {
		font-size: 16px;
		font-size: 1.25rem;
	}

	.navigation-top {
		bottom: 0;
		font-size: 14px;
		font-size: 0.875rem;
		left: 0;
		position: absolute;
		right: 0;
		width: 100%;
		z-index: 3;
	}

	.navigation-top .wrap {
		max-width: 1000px;
		padding: 0.75em 3.4166666666667em;
	}

	.navigation-top nav {
		margin-left: -1.25em;
	}

	.js .menu-toggle, .js .dropdown-toggle {
		display: none;
	}

	.js .main-navigation ul, .js .main-navigation ul ul, .js .main-navigation > div > ul {
		display: block;
	}

	.main-navigation > div > ul {
		padding: 0;
		border-top: 0;
	}

	.main-navigation li {
		border: 0;
		display: inline-block;
	}

	.main-navigation a {
		padding: 1em 1.25em;
	}

}

@media screen and (min-width: 64em) {

	/* Navigation */
	.navigation-top .wrap {
		padding: 0.75em 2em;
	}

	.navigation-top nav {
		margin-left: 0;
	}

	/* Sticky posts */

	.sticky .icon-thumb-tack {
		font-size: 32px;
		font-size: 2rem;
		height: 22px;
		left: -1.25em;
		top: 0.75em;
		width: 32px;
	}

	/* Pagination */

	.page-numbers {
		display: inline-block;
	}

	.page-numbers.current {
		font-size: 15px;
		font-size: 0.9375rem;
	}

	.page-numbers.current .screen-reader-text {
		clip: rect(1px, 1px, 1px, 1px);
		height: 1px;
		overflow: hidden;
		position: absolute !important;
		width: 1px;
	}

	/* Comments */

	.comment-body {
		margin-left: 0;
	}
}
