<?php
/**
 * WPTheme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage wptheme
 * @since wptheme 1.0
 */

/**
 * ----------------------------------------------------------------------------------------
 * Include dependencies
 * ----------------------------------------------------------------------------------------
 */

require_once( 'lib/wptheme-constants.php' );
require_once( 'lib/wptheme-helpers.php' );
require_once( 'lib/wptheme-actions.php' );
require_once( 'lib/wptheme-filters.php' );

/**
 * ----------------------------------------------------------------------------------------
 * WordPress Action Hooks
 * ----------------------------------------------------------------------------------------
 */

add_action( 'after_setup_theme', 'wptheme_action_setup' );
add_action( 'init', 'wptheme_action_init' );
add_action( 'widgets_init', 'wptheme_action_widgets_init' );
add_action( 'pre_get_posts', 'wptheme_action_override_main_query');
add_action( 'wp_enqueue_scripts', 'wptheme_action_enqueue_scripts' );
add_action( 'login_enqueue_scripts', 'wptheme_action_login_enqueue_styles', 10 );
// add_action( 'admin_head', 'wptheme_action_admin_head' );
// add_action( 'admin-init', 'wptheme_action_admin_init' );


/**
 * ----------------------------------------------------------------------------------------
 * WordPress Filter Hooks
 * ----------------------------------------------------------------------------------------
 */

// add_filter( 'login_headerurl', 'wptheme_filter_the_main_url' );
// add_filter( 'excerpt_more', 'wptheme_filter_excerpt_more_override' );
// add_filter( 'excerpt_length', 'wptheme_filter_excerpt_length_override' );
// add_filter( 'post_thumbnail_html', 'wptheme_filter_delete_img_size_attr', 10 );
// add_filter( 'image_send_to_editor', 'wptheme_filter_delete_img_size_attr', 10 );
