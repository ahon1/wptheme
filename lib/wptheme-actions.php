<?php

// This is called during each page load, after the theme is initialized.
// See http://codex.wordpress.org/Plugin_API/Action_Reference/after_setup_theme
function ironbwp_action_setup() {
	
    add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails', array( 'post', 'page', 'event' ) );

	register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'wptheme' ),
		'secondary' => __( 'Secondary menu above primary', 'wptheme' ),
		'footer'	=> __( 'Footer menu', 'wptheme' ),
	) );

}

// Runs after WordPress has finished loading but before any headers are sent.
// See http://codex.wordpress.org/Plugin_API/Action_Reference/init
function ironbwp_action_init() {
    
    add_post_type_support(
    	'page',
    	array( 'thumbnail', 'excerpt' )
    );

	ironbwp_register_cpt(array(
		'single'        =>	'event',
		'menu_icon'     =>	'dashicons-calendar',
		'menu_position' =>	6,
		'supports'      =>	array( 'title', 'excerpt', 'editor', 'thumbnail', 'revisions' )
	));
	
	register_taxonomy( 'event_type', 'event',  array(
		'hierarchical'		=>	false,
		'label'				=>	'Event Types',
		'singular_label'	=>	'Event Type',
		'show_ui'			=>	true,
		'query_var'			=>	true,
		'rewrite'			=>	array( 'slug' => 'event_type' ),
		'has_archive'		=>	true
	));

	# wp_deregister_style('open-sans');
	# wp_deregister_style('login');

}

function ironbwp_action_widgets_init() {
	register_sidebar(array(
		'name'				=>	'Default Sidebar',
		'before_widget'		=>	'<div id="%1$s" class="widget %2$s clearfix">',
		'after_widget'		=>	'</div>',
		'before_title'		=>	'<h4>',
		'after_title'		=>	'</h4>'
	));
}

function ironbwp_action_enqueue_scripts() {

	global $is_IE;
	
	// De-register WP-bundled version of jQuery
	wp_deregister_script('jquery');

	wp_register_style( 'webfonts-google', '//fonts.googleapis.com/css?family=Lato', false, false, 'screen' );
	wp_register_style( 'webfonts', STYLES . '/fonts.css', array( 'webfonts-google' ), '1.0', 'screen');
	wp_register_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css', false, false, 'screen' );
	wp_register_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css', array( 'bootstrap' ), false, 'screen' );
	wp_register_style( 'animate', '//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css', false, false, 'screen' );
	wp_register_style( 'wptheme', THEMEROOT . '/style.css', array( 'bootstrap', 'webfonts', 'font-awesome', 'animate'), '1.0', 'screen' );
	
	// Re-register a CDN-hosted, minified version of jQuery for slight speed improvements
	wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', false, false, true );
	wp_register_script( 'bootstrap-js', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js', array( 'jquery' ), false, true );
	wp_register_script( 'wptheme', SCRIPTS . '/wptheme.js', array( 'bootstrap-js' ), '1.0', true );

	if ( $is_IE ) {
		wp_enqueue_script( 'respondjs', '//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js', array( 'bootstrap-js' ), false, true );
	}
	
	// All dependent CSS and JS will be loaded automatically
	wp_enqueue_style('wptheme');
	wp_enqueue_script('wptheme');

	// No fancy CSS3 animation/transitions for IE
	global $wp_styles;
	$wp_styles->add_data( 'animate', 'conditional', '!IE' );

}

function ironbwp_action_login_enqueue_styles() {
	wp_register_style( 'wptheme-login', STYLES . 'login-style.css', array( 'login' ), '1.0', 'screen' );
	wp_enqueue_style( 'wptheme-login' );
}

// Exposes the query-variables object before a query is executed.
// See http://codex.wordpress.org/Plugin_API/Action_Reference/pre_get_posts
function ironbwp_action_override_main_query( $query ) {

	$query->set( 'update_post_meta_cache', false );
	$query->set( 'update_post_term_cache', false );

	if ( is_admin() ) {
		return;
	}

	// This query is not on the home page
	if ( ! $query->is_home() ) {

		if ( is_search() ) {

			// $query->set( 'posts_per_page', '10' );

			return;
		}

		if ( is_tax() ) {

			$arr = $query->tax_query->queries;

			return;
		}

		return;
	}

	if ( ! $query->is_main_query() ) {
		return;
	}

	$query->set( 'ignore_sticky_posts', true );
	$query->set( 'update_post_meta_cache', false );
	$query->set( 'update_post_term_cache', false );
	$query->set( 'posts_per_page', '2' );

	return;	
}