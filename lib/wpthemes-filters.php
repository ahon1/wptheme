<?php

function wptheme_filter_the_main_url() {
	return get_bloginfo( 'url' );
}

function wptheme_filter_excerpt_more_override( $more ) {
	if ( is_home() ||  'event' === get_post_type() ) {
		return '';
	}
	return ' &hellip;';
}

function wptheme_filter_excerpt_length_override() {
	if ( 'tmpl/tmpl.events.php' === get_page_template_slug( get_the_id() ) ) {
		return 50;
	}
	return ( wp_is_mobile() ) ? 12 : 20;
}

function wptheme_filter_delete_img_size_attr( $html ) {
	return preg_replace( '/(width|height)="\d*"\s/', '', $html );
}