<?php

/*
Plugin Name: HM Portfolio
Plugin URI: https://github.com/humanmade/HM-Portfolio
Description: Web/Print Portfolio plugin
Author: humanmade limited, Joe Hoyle, Tom Wilmott, Matthew Haines-Young
Version: 1.0.1
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


//HM Core setup
define( 'HM_ENABLE_ACCOUNTS', false );
include_once('HM Core/hm_core.php');

//Template rewrite
include_once('hmp.functions.php');
include_once('hmp.rewrite.php');
include_once('admin/admin.php');
include_once('hmp.hooks.php');
include_once('hmp.upgrade.php');

//Filters
include_once('hmp.filters.php');

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
		'rewrite' => array( 'slug' =>  get_option('hmp_url_base', 'portfolio') ),
		'query_var' => 'term',
		'labels' => array( 
			'name' => 'Portfolio Categories',
			'singular_name' => 'Portfolio Category',
			'search_items' => 'Search Portfolio Categories',
			'edit_item' => 'Edit Portfolio Category',
			'all_items' => 'All Portfolio Categories',
			'add_new_item' => 'Add Portfolio Category',
			'new_item_name' => 'New Portfolio Category Name',
			'view' => 'View Entry' ),
		));	
	register_post_type( 'hmp-entry', array( 
			'singular_label' => 'Report',
			'public' => true,
			'inherit_type' => 'post',
			'taxonomies' => array( 'hmp-entry-category', 'post_tag' ),
			'supports' => array( 'editor', 'title', 'revisions', 'custom-fields', 'thumbnail' ),
			'labels' => array( 
				'name' => 'Portfolio',
				'singular_name' => 'Entry',
				'not_found' => 'No entries found',
				'not_found_in_trash' => 'No entries found in Trash',
				'search_items' => 'Search Entries',
				'edit_item' => 'Edit Entry',
				'add_new_item' => 'Add New Entry' ),
			'rewrite' => array( 'slug' => get_option('hmp_url_base', 'portfolio') . '/%hmp-entry-category%' ),
			'has_archive' => true	
		)
	);
}
// Admin Icons
add_action( 'admin_head', 'hmp_icons' );
function hmp_icons() {
	$url = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
    ?>
    <style type="text/css" media="screen">
        #menu-posts-hmp-entry .wp-menu-image {
            background: url(<?php echo $url; ?>/admin/icon.png) no-repeat 0 top !important;
        }
		#menu-posts-hmp-entry:hover .wp-menu-image, #menu-posts-hmp-entry.wp-has-current-submenu .wp-menu-image {
            background-position:0 bottom !important;
        }
        #icon-options-hmp-entry { background: url(<?php echo $url; ?>/admin/icon_large.png) no-repeat; }
        <?php if (($_GET['post_type'] == 'hmp-entry') || ($post_type == 'hmp-entry')) : ?>
			#icon-edit { background: url(<?php echo $url; ?>/admin/icon_large.png) no-repeat; }		
			.icon32 { margin: 11px 6px 3px 0; }
		<?php endif; ?>
    </style><?php
}