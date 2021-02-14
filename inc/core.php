<?php
/*
 *	core.php
 *
 *	This is the configuration file for the theme. It does the following:
 *		1. Inits the core after theme setup, running all the functions on this file.
 *		2. Cleans junk out of the <head> tags.
 *		3. Configures all theme support.
 *		4. Improves ARIA attributes on WP elements (Read more linke, etc)
 *		5. Adds common ratios to image size options.
 *		6. Enqueues scripts and styles
 */



// 1. Init Core
//

add_action( 'after_setup_theme', 'cabbage_init_core' );
function cabbage_init_core() {
	add_editor_style( get_stylesheet_directory_uri().'/assets/css/editor.css' );
  
  	cabbage_cleanup();
  	cabbage_theme_support();
  	cabbage_aria_improvements();
  	add_filter( 'image_size_names_choose', 'cabbage_custom_image_sizes' );
}



// 2. Clean <head>
//

// some functions used here can be found after this declaration.
function cabbage_cleanup() {
	// category feeds
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// remove WP version from css
	add_filter( 'style_loader_src', 'cabbage_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
	add_filter( 'script_loader_src', 'cabbage_remove_wp_ver_css_js', 9999 );
	// remove Wp emoji code
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
	// remove oembed API
	remove_action( 'wp_head', 'rest_output_link_wp_head');
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links');
	remove_action( 'template_redirect', 'rest_output_link_header', 11);
	// remove WP version from rss
	add_filter( 'the_generator', 'cabbage_rss_version' );
	// remove recent comments style
	add_filter( 'wp_head', 'cabbage_remove_wp_widget_recent_comments_style', 1 );
	add_action( 'wp_head', 'cabbage_remove_recent_comments_style', 1 );
	// remove gallery style
	add_filter( 'gallery_style', 'cabbage_gallery_style' );
	// remove p tags around images
	add_filter( 'the_content', 'cabbage_filter_ptags_on_images' );
}

function cabbage_rss_version() { return ''; }

function cabbage_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

function cabbage_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

function cabbage_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}

function cabbage_gallery_style($css) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}

function cabbage_filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}



// 3. Theme support
//

add_action( 'wp_enqueue_scripts', 'cabbage_scripts_and_styles', 999 );
function cabbage_theme_support() {
	// custom background
	// add_theme_support( 'custom-background' );

	// custom logo
	add_theme_support( 'custom-logo', array(
	    'height'      => 100,
	    'width'       => 400,
	    'flex-height' => true,
	    'flex-width'  => true,
	    'header-text' => array( 'site-title', 'site-description' ),
	));

	// Make sure featured images are enabled
	add_theme_support( 'post-thumbnails' );

	// rss
	add_theme_support('automatic-feed-links');

	// post format support
	add_theme_support( 'post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat') );

	// wp menus
	add_theme_support( 'menus' );

	// register menus
	register_nav_menus(
		array(
			'primary-nav' => __( 'Primary Navigation', 'wpTheme' ),   	// main nav in header
			'footer-nav' => __( 'Footer Navigation', 'wpTheme' ) 		// secondary nav in footer
		)
	);

	// support for HTML5 markup.
	add_theme_support( 'html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script') );

	// custom units
	add_theme_support( 'custom-units', 'rem', 'em' );

	// Editor color palette - match to colors in scss
	add_theme_support( 'disable-custom-gradients' );
	add_theme_support( 'disable-custom-colors' );
	// add_theme_support( 'editor-color-palette', array(
	//     array(
	//         'name' => esc_attr__( 'strong magenta', 'themeLangDomain' ),
	//         'slug' => 'strong-magenta',
	//         'color' => '#a156b4',
	//     ),
	//     array(
	//         'name' => esc_attr__( 'light grayish magenta', 'themeLangDomain' ),
	//         'slug' => 'light-grayish-magenta',
	//         'color' => '#d0a5db',
	//     ),
	//     array(
	//         'name' => esc_attr__( 'very light gray', 'themeLangDomain' ),
	//         'slug' => 'very-light-gray',
	//         'color' => '#eee',
	//     ),
	//     array(
	//         'name' => esc_attr__( 'very dark gray', 'themeLangDomain' ),
	//         'slug' => 'very-dark-gray',
	//         'color' => '#444',
	//     ),
	// ));

	// editor font sizes - match font scale in assets/scss/base/_mixins
	add_theme_support( 'disable-custom-font-sizes' );
	add_theme_support( 'editor-font-sizes', array(
	    array(
	        'name' => esc_attr__( '12 pixels (smallest)', 'themeLangDomain' ),
	        'size' => 12,
	        'slug' => 'fs-xs'
	    ),
	    array(
	        'name' => esc_attr__( '14 pixels', 'themeLangDomain' ),
	        'size' => 14,
	        'slug' => 'fs-s'
	    ),
	    array(
	        'name' => esc_attr__( '16 pixels (default size)', 'themeLangDomain' ),
	        'size' => 16,
	        'slug' => 'fs-0'
	    ),
	    array(
	        'name' => esc_attr__( '18 pixels', 'themeLangDomain' ),
	        'size' => 18,
	        'slug' => 'fs-1'
	    ),
	    array(
	        'name' => esc_attr__( '20 pixels', 'themeLangDomain' ),
	        'size' => 20,
	        'slug' => 'fs-2'
	    ),
	    array(
	        'name' => esc_attr__( '24 pixels', 'themeLangDomain' ),
	        'size' => 24,
	        'slug' => 'fs-3'
	    ),
	    array(
	        'name' => esc_attr__( '30 pixels', 'themeLangDomain' ),
	        'size' => 30,
	        'slug' => 'fs-4'
	    ),
	    array(
	        'name' => esc_attr__( '36 pixels', 'themeLangDomain' ),
	        'size' => 36,
	        'slug' => 'fs-5'
	    ),
	    array(
	        'name' => esc_attr__( '48 pixels', 'themeLangDomain' ),
	        'size' => 48,
	        'slug' => 'fs-6'
	    ),
	    array(
	        'name' => esc_attr__( '60 pixels', 'themeLangDomain' ),
	        'size' => 60,
	        'slug' => 'fs-7'
	    ),
	    array(
	        'name' => esc_attr__( '72 pixels (largest)', 'themeLangDomain' ),
	        'size' => 72,
	        'slug' => 'fs-8'
	    ),
	));

	// remove default block patterns
	remove_theme_support( 'core-block-patterns' );

	// editor style sheet
	add_theme_support( 'editor-styles');
	add_editor_style( 'style-editor.css' );
}



// 4. ARIA improvements
//

// some functions used here can be found after this declaration.
function cabbage_aria_improvements() {
	add_filter( 'excerpt_more', 'cabbage_excerpt_more' );
}

function cabbage_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a class="excerpt-read-more" href="'. get_permalink( $post->ID ).'" aria-label="'.__( 'Read ', 'wpTheme' ).esc_attr( get_the_title( $post->ID ) ).'">'.__( 'Read more &raquo;', 'wpTheme' ).'</a>';
}



// 5. Add more image sizes
//

add_image_size( 'ratio-16-9', 1200, 675, true );
add_image_size( 'ratio-4-3', 1024, 768, true );
add_image_size( 'ratio-3-2', 1080, 720, true );
add_image_size( 'ratio-1-1', 600, 600, true );

function cabbage_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'ratio-16-9' => __( 'Ratio 16:9' ),
        'ratio-4-3' => __( 'Ratio 4:3' ),
        'ratio-3-2' => __( 'Ratio 3:2' ),
        'ratio-1-1' => __( 'Ratio 1:1' ),
    ));
}




// 6. Enqueue scripts and styles
//
function cabbage_scripts_and_styles() {
	if (!is_admin()) {
		// Register assets
		wp_register_style( 'wpt-stylesheet', get_stylesheet_directory_uri().'/assets/css/style.min.css', array(), '', 'all' );
		wp_register_script( 'wpt-js', get_stylesheet_directory_uri().'/assets/js/main.js', array(), '', true );

		// Remove fluff
		wp_deregister_script( 'wp-embed' );
		wp_dequeue_style( 'wp-block-library' );

		// Enqueue theme assets
		wp_enqueue_style( 'wpt-stylesheet' );
		wp_enqueue_script( 'wpt-js' );
	}
}


?>