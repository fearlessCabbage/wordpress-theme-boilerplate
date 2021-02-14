<?php
/*
 * @name Custom-post-type.php (Template)
 * @description This template is meant to speed up the process of adding custom post types. Use one file per type. This is loaded in functions.php
 * @version 1.0
 * @basedOff https://themble.com/bones/
 */

// Flush rewrite rules for custom post types
//

function wpt_flush_rewrite_rules() {
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'wpt_flush_rewrite_rules' );

// Custom post type
// http://codex.wordpress.org/Function_Reference/register_post_type
//
function custom_post_template() {
	register_post_type( 'custom_type',
		array(
		'labels' => array(
			'name' => __( 'Custom Types', 'wpTheme' ),
			'singular_name' => __( 'Custom Post', 'wpTheme' ),
			'all_items' => __( 'All Custom Posts', 'wpTheme' ),
			'add_new' => __( 'Add New', 'wpTheme' ),
			'add_new_item' => __( 'Add New Custom Type', 'wpTheme' ),
			'edit' => __( 'Edit', 'wpTheme' ),
			'edit_item' => __( 'Edit Post Types', 'wpTheme' ),
			'new_item' => __( 'New Post Type', 'wpTheme' ),
			'view_item' => __( 'View Post Type', 'wpTheme' ),
			'search_items' => __( 'Search Post Type', 'wpTheme' ),
			'not_found' =>  __( 'Nothing found in the Database.', 'wpTheme' ),
			'not_found_in_trash' => __( 'Nothing found in Trash', 'wpTheme' ),
			'parent_item_colon' => ''
		),
		'description' => __( 'This is the example custom post type', 'wpTheme' ),
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'show_ui' => true,
		'query_var' => true,
		'menu_position' => 8,
		'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png',
		'rewrite'	=> array( 'slug' => 'custom_type', 'with_front' => false ),
		'has_archive' => 'custom_type',
		'capability_type' => 'post',
		'hierarchical' => false,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
		)
	);

	register_taxonomy_for_object_type( 'category', 'custom_type' );
	register_taxonomy_for_object_type( 'post_tag', 'custom_type' );
}
add_action( 'init', 'custom_post_template');

// Register taxonomies
// http://codex.wordpress.org/Function_Reference/register_taxonomy
//
register_taxonomy( 'custom_cat',
	array('custom_type'),
	array(
		'hierarchical' => true,
		'labels' => array(
			'name' => __( 'Custom Categories', 'wpTheme' ),
			'singular_name' => __( 'Custom Category', 'wpTheme' ),
			'search_items' =>  __( 'Search Custom Categories', 'wpTheme' ),
			'all_items' => __( 'All Custom Categories', 'wpTheme' ),
			'parent_item' => __( 'Parent Custom Category', 'wpTheme' ),
			'parent_item_colon' => __( 'Parent Custom Category:', 'wpTheme' ),
			'edit_item' => __( 'Edit Custom Category', 'wpTheme' ),
			'update_item' => __( 'Update Custom Category', 'wpTheme' ),
			'add_new_item' => __( 'Add New Custom Category', 'wpTheme' ),
			'new_item_name' => __( 'New Custom Category Name', 'wpTheme' )
		),
		'show_admin_column' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'custom-slug' ),
	)
);

register_taxonomy( 'custom_tag',
	array('custom_type'),
	array(
		'hierarchical' => false,
		'labels' => array(
			'name' => __( 'Custom Tags', 'wpTheme' ),
			'singular_name' => __( 'Custom Tag', 'wpTheme' ),
			'search_items' =>  __( 'Search Custom Tags', 'wpTheme' ),
			'all_items' => __( 'All Custom Tags', 'wpTheme' ),
			'parent_item' => __( 'Parent Custom Tag', 'wpTheme' ),
			'parent_item_colon' => __( 'Parent Custom Tag:', 'wpTheme' ),
			'edit_item' => __( 'Edit Custom Tag', 'wpTheme' ),
			'update_item' => __( 'Update Custom Tag', 'wpTheme' ),
			'add_new_item' => __( 'Add New Custom Tag', 'wpTheme' ),
			'new_item_name' => __( 'New Custom Tag Name', 'wpTheme' )
		),
		'show_admin_column' => true,
		'show_ui' => true,
		'query_var' => true,
	)
);

?>