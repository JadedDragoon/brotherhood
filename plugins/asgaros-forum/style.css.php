<?php
	header( 'Content-type: text/css; charset: UTF-8' );

	// for highlighting
	// phpcs:disable
	if ( FALSE ) { ?><style><?php }
?>

div#af-wrapper,
div#af-wrapper .main-title {
	color: #FFFFFF !important;
}

div#af-wrapper  {
	background-color: #1a2632;
	border: solid 1em #1a2632;
	border-radius: 1em;
}

div#af-wrapper .title-element {
	background-color: #1a2632 !important;
}

div#af-wrapper h1.main-title {
	margin-left: 1em;
}
div#af-wrapper div.main-description {
	margin-left: 2em;
}

div#af-wrapper a,
div#af-wrapper div.post-message a,
div#af-wrapper .unread:before,
div#af-wrapper #topic-subscription,
div#af-wrapper #forum-subscription,
div#af-wrapper .forum-post-menu a,
div#af-wrapper #forum-profile .display-name,
div#af-wrapper input[type="checkbox"]:checked:before {
	color: #9bb2ca !important
}

div#af-wrapper small.forum-description {
	color: #eeeeee !important;
}

div#af-wrapper #read-unread span.unread{
	background-color: #195ca8 !important;
}
div#af-wrapper .unread:before {
	color: #195ca8 !important;
}

div#af-wrapper div#read-unread span.read {
	background-color: #FFFFFF !important;
}
div#af-wrapper .read:before {
	color: #FFFFFF !important;
}

div#af-wrapper input,
div#af-wrapper #forum-search input,
div#af-wrapper #forum-search {
	background-color: #333;
	color: #FFFFFF !important;
}
div#af-wrapper #forum-search {
	border-radius: 1em;
}

div#af-wrapper body {
	background-color: #333;
}

div#af-wrapper div#forum-header {
	border-radius: 1em 1em 0 0;
}

div#af-wrapper div#forum-breadcrumbs {
	border-radius: 0 0 1em 1em;
}

div#af-wrapper div.content-element {
	border-radius: 1em;
	border-top: 1px solid #2468af !important;
}

div#af-wrapper div.title-element {
	border-bottom: none !important;
}
div.af-wrapper .member-avatar img {
	outline: none;
	box-shadow:
		 1px  1px 0 #CCC,
		-1px  1px 0 #CCC,
		 1px -1px 0 #CCC,
		-1px -1px 0 #CCC;
}
div#af-wrapper .user-online img.avatar {
	outline: none;
	box-shadow:
		 1px  1px 0 #82f338,
		-1px  1px 0 #82f338,
		 1px -1px 0 #82f338,
		-1px -1px 0 #82f338;
}

div#af-wrapper img.avatar {
	border-radius: 10%;
	outline: none;
}

div#af-wrapper span.last-post-headline {
	display: none;
}

div#af-wrapper div.post-author {
	font-size: 16px;
	word-wrap: normal;

	width: 200px;
}

div#af-wrapper div.post-author span.af-usergroup-tag {
	margin: 0 auto;
	display: inline-block;
	background-color: gray;
}
