<?php

/*
Plugin Name: HM Portfolio
Plugin URI: https://github.com/humanmade/HM-Portfolio
Description: Web/Print Portfolio plugin
Author: humanmade, Joe Hoyle, Matthew Haines-Young
Version: 0.9.8
Author URI: http://www.humanmade.co.uk/
*/

define( 'HMPURL', str_replace( ABSPATH, trailingslashit(get_bloginfo('wpurl')), dirname( __FILE__ ) ) . '/' );
define( 'HMPPATH', dirname( __FILE__ ) );

//check comaptibility before anything
hmp_check_plugin_compatibility();

function hmp_check_plugin_compatibility() {

	// check compatibility
	global $wp_version;
	$php_version = phpversion();
	
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );  
	
	if( version_compare( $wp_version, '3.0', '<') ) {
		deactivate_plugins(HMPPATH . '/plugin.php'); 
		die('HM Portfolio 0.9.7+ requires WordPress 3.0+, please download HM Portfolio 0.9.6 <a href="http://downloads.wordpress.org/plugin/hmp-portfolio.0.9.6.zip">here</a> for older versions of WordPress. ');
  	} elseif( version_compare( $php_version, '5', '<') ) {
  		deactivate_plugins(HMPPATH . '/plugin.php'); 
		die('HM Portfolio requires PHP 5+');
  	}
  	
}


//helper setup
define( 'TJ_ENABLE_ACCOUNTS', false );
include_once('helper/helper.php');

//Template rewrite
include_once('hmp.functions.php');
include_once('hmp.rewrite.php');
include_once('admin/admin.php');
include_once('hmp.hooks.php');
include_once('hmp.upgrade.php');

//Widgets etc
include_once('hmp.widgets.php');

// upgrade old data
register_activation_hook( __FILE__, 'hmp_upgrade' );
register_activation_hook( __FILE__, 'hmp_activate_plugin' );
// deprecated functions
include_once('hmp.functions.deprecated.php');

add_action( 'init', 'hmp_register_post_types' );
function hmp_register_post_types() {
	//register extra taxonomy
	register_taxonomy( 'hmp-entry-category', 'hmp-entry', array( 
		'hierarchical' => true,
		'show-ui' => true,
		'labels' => array( 
			'name' => 'Categories',
			'singular_name' => 'Category',
			'search_items' => 'Search Categories',
			'edit_item' => 'Edit Category',
			'all_items' => 'All Categories',
			'add_new_item' => 'Add Category',
			'new_item_name' => 'New Category Name',
			'view' => 'View Entry' ),
			
		));
		
	register_taxonomy( 'hmp-entry-tag', 'hmp-entry', array( 
		'hierarchical' => false,
		'show-ui' => true,
		'labels' => array( 
			'name' => 'Tags',
			'singular_name' => 'Tag',
			'search_items' => 'Search Tags',
			'edit_item' => 'Edit Tag',
			'all_items' => 'All Tags',
			'add_new_item' => 'Add Tag',
			'new_item_name' => 'New Tag Name',
			'view' => 'View Entry' ),
		));
	
	register_post_type( 'hmp-entry', array( 
			'singular_label' => 'Report',
			'public' => true,
			'inherit_type' => 'post',
			'taxonomies' => array( 'hmp-entry-category', 'hmp-entry-tag' ),
			'supports' => array( 'editor', 'title', 'revisions', 'custom-fields' ),
			'labels' => array( 
				'name' => 'Portfolio',
				'singular_name' => 'Entry',
				'not_found' => 'No entries found',
				'not_found_in_trash' => 'No entries found in Trash',
				'search_items' => 'Search Entries',
				'edit_item' => 'Edit Entry',
				'add_new_item' => 'Add New Entry' ),
			'menu_icon' => str_replace( ABSPATH , trailingslashit(get_bloginfo('wpurl')), dirname( __FILE__ ) . '/admin/icon.png' ),
			'rewrite' => array( 'slug' => hmp_get_single_permalink_structure() )
		
		)
	);
}
?>