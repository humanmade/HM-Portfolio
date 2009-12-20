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
}

function jhp_upgrade_extra_taxonomy_to_tags() {
	global $wpdb;
	$wpdb->query( "UPDATE $wpdb->term_taxonomy SET taxonomy='jh-portfolio-tag' WHERE taxonomy='jh_portfolio_extra_taxonomy'" );
}

?>