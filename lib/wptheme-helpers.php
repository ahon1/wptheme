<?php

require_once( 'bootstrap-classes.php' );	// custom walker class

function ironbwp_set_cpt_args( $args = array() ) {
	
	$args = wp_parse_args(
		$args,
		array(
			'single' 		=>	'',
			'plural' 		=>	'',
			'menu_position' =>	null,
			'menu_icon' 	=>	'dashicons-admin-post',
			'supports' 		=>	array('title')
	));
	
	$n 			=	ucwords($args['single']);
	$p 			=	ucwords($args['plural']);
	$pos 		=	$args['menu_position'];
	$icon 		=	$args['menu_icon'];
	$supports 	=	$args['supports'];
	 
	if ( ! strlen($n) ) return array();
	if ( ! strlen($p) ) $p	=	$n . 's';
	
	return array(
		'public'		=>	true,
		'menu_position' =>	$pos,
		'menu_icon' 	=>	$icon,
		'supports' 		=>	$supports,
		'labels' 		=>	array(
			'name' 					=>	$p,
			'singular_name' 		=>	$n,
			'add_new'		 		=>	'Add New ' . $n,
			'add_new_item' 			=>	'Add New ' . $n,
			'edit_item' 			=>	'Edit ' . $n,
			'new_item' 				=>	'New ' . $n,
			'all_items' 			=>	'All ' . $p,
			'view_item' 			=>	'View ' . $p,
			'search_items' 			=>	'Search ' . $p,
			'not_found' 			=>	'No ' . $p . ' found',
			'not_found_in_trash' 	=>	'No ' . $p . ' found in Trash',
			'parent_item_colon' 	=>	'',
			'menu_name' 			=>	$p
	));
}

function ironbwp_register_cpt( $args = array() ) {
	$args = wp_parse_args(
				$args,
				array( 'single' => '' ));
	register_post_type(
		$args['single'],
		ironbwp_set_cpt_args($args));
}

function ironbwp_main_nav() {
	wp_nav_menu(array( 
		'menu' 				=>	'primary',				/* menu name */
		'menu_class' 		=>	'nav navbar-nav',
		'theme_location' 	=>	'primary',				/* where in the theme it's assigned */
		'container' 		=>	'false',				/* container class */
		'items_wrap'		=>	'%3$s',
		'walker' 			=>	new Bootstrap_Navbar_Walker()
	));
}

function ironbwp_hex2rgb( $color ) {
	if ( $color[0] == '#' ) {
		$color = substr( $color, 1 );
	}
	if ( strlen( $color ) == 6 ) {
		list( $r, $g, $b ) = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		list( $r, $g, $b ) = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return false;
	}
	$r = hexdec( $r );
	$g = hexdec( $g );
	$b = hexdec( $b );
	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}