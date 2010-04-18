<?php

function jhp_upgrade() {

	// check compatibility
	global $wp_version;
	$php_version = phpversion(); 
	if( version_compare( $wp_version, '2.9', '<') ) {
		deactivate_plugins(JHPPATH . '/plugin.php'); 
		die('JH Portfolio requires WordPress 2.9+');
  	} elseif( version_compare( $php_version, '5', '<') ) {
  		deactivate_plugins(JHPPATH . '/plugin.php'); 
		die('JH Portfolio requires PHP 5+');
  	}
  
	jhp_upgrade_extra_taxonomy_to_tags();
	jhp_upgrade_post_meta_to_prepend_underscores();
}

function jhp_upgrade_extra_taxonomy_to_tags() {
	global $wpdb;
	$wpdb->query( "UPDATE $wpdb->term_taxonomy SET taxonomy='jh-portfolio-tag' WHERE taxonomy='jh_portfolio_extra_taxonomy'" );
}

function jhp_upgrade_post_meta_to_prepend_underscores() {
	global $wpdb;
	
	//use "brief" as the indicater if it needs updating
	error_log( 'JHP: Checking if meta needs upgrade...' );
	if( $wpdb->get_var( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='brief'" ) ) {
		error_log( 'JHP: Upgrading meta keys...' );
		
		error_log( 'JHP: Upgrading meta key: brief...' );
		$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = '_brief' WHERE meta_key = 'brief';");
		
		error_log( 'JHP: Upgrading meta key: byline...' );
		$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = '_byline' WHERE meta_key = 'byline';");
		
		error_log( 'JHP: Upgrading meta key: url...' );
		$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = '_url' WHERE meta_key = 'url';");
		
		error_log( 'JHP: Upgrading meta key: related_work...' );
		$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = '_related_work' WHERE meta_key = 'related_work';");
		
		error_log( 'JHP: Upgrading meta key: jhp_gallery_images...' );
		$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = '_jhp_gallery_images' WHERE meta_key = 'jhp_gallery_images';");
		
		error_log( 'JHP: Upgrading meta key: jhp_main_image...' );
		$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = '_jhp_main_image' WHERE meta_key = 'jhp_main_image';");

		error_log( 'JHP: Upgrading meta keys done' );

	}
}

?>