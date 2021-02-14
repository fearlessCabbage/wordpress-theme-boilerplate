<?php
/*
 * @name Admin.php
 * @description This file contains functions that affect the admin panel. It is loaded in functions.php.
 * @version 1.0
 * @basedOff https://themble.com/bones/
 */



// Admin footer
//
function wpt_admin_footer() {
	_e( '<span id="footer-thankyou">Developed by <a href="http://fearlesscabbage.com" target="_blank">Mike Bowen</a></span>.' );
}
add_filter( 'admin_footer_text', 'wpt_admin_footer' );



// Allowed Block Types
//
// https://developer.wordpress.org/block-editor/developers/filters/block-filters/#hiding-blocks-from-the-inserter
// https://developer.wordpress.org/reference/hooks/allowed_block_types/
function wpt_allowed_block_types( $allowed_block_types, $post ) {
    return array(
    	// text
    	'core/code',
    	'core/heading',
    	// 'core/freeform',
    	'core/list',
    	'core/paragraph',
    	'core/preformatted',
    	// 'core/pullquote',
    	'core/quote',
    	'core/table',
    	// 'core/verse',

    	// media
    	'core/audio',
    	// 'core/cover',
    	'core/file',
    	'core/gallery',
    	'core/image',
    	// 'core/media-text',
    	'core/video',

    	// design
    	'core/buttons',
    	// 'core/columns',
    	// 'core/group',
    	// 'core/more',
    	// 'core/nextpage',
    	'core/separator',
    	'core/spacer',

    	// widgets
    	'core/archives',
    	'core/calendar',
    	'core/categories',
    	'core/html',
    	// 'core/latest-comments',
    	'core/latest-posts',
    	// 'core/rss',
    	'core/shortcode',
    	// 'core/social-links',
    	'core/tag-cloud',
    	// 'core/search',

    	// embeds
    	// 'core/embed'
    );
}
add_filter( 'allowed_block_types', 'wpt_allowed_block_types', 10, 2 );



// Disable dashboard widgets
//

function wpt_disable_default_dashboard_widgets() {
	global $wp_meta_boxes;
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);    		// Right Now Widget
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);        	// Activity Widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); 		// Comments Widget
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);  	// Incoming Links Widget
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);         	// Plugins Widget
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);    		// Quick Press Widget
	// unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);     	// Recent Drafts Widget
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);           		//
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);         		//

	// remove plugin dashboard boxes
	// unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);          	// Yoast's SEO Plugin Widget
	// unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);       	// Gravity Forms Plugin Widget
	// unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);  	// bbPress Plugin Widget
}
add_action( 'wp_dashboard_setup', 'wpt_disable_default_dashboard_widgets' );



// Login page style
//

//http://codex.wordpress.org/Plugin_API/Action_Reference/login_enqueue_scripts
function wpt_get_login_css() {
	wp_enqueue_style( 'login_css', get_template_directory_uri() . '/library/css/login.css', false );
}

function set_login_logo_url() {  return home_url(); }
function set_login_logo_title() { return get_option( 'blogname' ); }
add_action( 'login_enqueue_scripts', 'wpt_get_login_css', 10 );
add_filter( 'login_headerurl', 'set_login_logo_url' );
add_filter( 'login_headertitle', 'set_login_logo_title' );



// Customizer
//
/*
  A good tutorial for creating your own Sections, Controls and Settings:
  http://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722

  Good articles on modifying the default options:
  http://natko.com/changing-default-wordpress-theme-customization-api-sections/
  http://code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162
*/
function wpt_theme_customizer($wp_customize) {
	// $wp_customize calls go here.
	//

	// Uncomment the below lines to remove the default customize sections
	// $wp_customize->remove_section('title_tagline');
	// $wp_customize->remove_section('colors');
	// $wp_customize->remove_section('background_image');
	// $wp_customize->remove_section('static_front_page');
	// $wp_customize->remove_section('nav');

	// Uncomment the below lines to remove the default controls
	// $wp_customize->remove_control('blogdescription');

	// Uncomment the following to change the default section titles
	// $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
	// $wp_customize->get_section('background_image')->title = __( 'Images' );
}
add_action( 'customize_register', 'wpt_theme_customizer' );