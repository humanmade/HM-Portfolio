<?php
// flush the rewrite rules
function flush_rewrite_rules() {
	global $wp_rewrite;
   	$wp_rewrite->flush_rules(); 	
}
add_action( 'init', 'flush_rewrite_rules' );

// Generate the custom rewrite rules
function create_custom_rewrite_rules() {
	global $wp_rewrite;
 	
	// Define custom rewrite tokens
	$subtable_tag = '%subtable%';
	
	// Add the rewrite tokens
	$wp_rewrite->add_rewrite_tag( $subtable_tag, '(.+?)', 'subtable=' );
 	
 	// Define the custom permalink structure
	$subtable_keywords_structure = $wp_rewrite->root . "%pagename%/$subtable_tag/";
	
	// Generate the rewrite rules
	$subtable_rewrite = $wp_rewrite->generate_rewrite_rules( $subtable_keywords_structure );
 
	$wp_rewrite->rules = $subtable_rewrite + $wp_rewrite->rules;
	//tw( $wp_rewrite );
	return $wp_rewrite->rules;
}
//add_action( 'generate_rewrite_rules', 'create_custom_rewrite_rules' );

// Add the custom tokens as allowed query vars
function add_custom_page_variables( $public_query_vars ) {
	$public_query_vars[] = 'subtable';
	return $public_query_vars;
}
//add_filter( 'query_vars', 'add_custom_page_variables' );

// Load the correct theme files for the custom pages
function load_custom_templates() {

	if ( is_custom_page('subtable') ) :
		include( get_template_directory() . '/template.tables.php' );
		exit;
	endif;
	
	if ( is_custom_page('company') ) :
		include( get_template_directory() . '/template.company.php' );
		exit;
	endif;
	
	
}
add_action( 'template_redirect', 'load_custom_templates', 99, 2 );

function is_custom_page( $page_var, $slug = null ) {
	global $wp_query, $wp_rewrite;

	if ( $wp_rewrite->using_permalinks() ) :
		$custom_var = $wp_query->query_vars[$page_var];
	else :
		$custom_var = $_GET[$page_var];
	endif;
	
	if ( empty( $custom_var ) )
		$custom_var = $_GET[$page_var];
	
	if ( !is_null( $slug ) && $slug == $custom_var )
		return true;
		
	if ( !is_null( $custom_var ) && is_null( $slug ) )
		return true;
		
	return false;
}

function get_custom_var( $var = false ) {
	global $wp_query, $wp_rewrite;

	if ( $wp_rewrite->using_permalinks() ) :
		$info = $wp_query->query_vars[$var];
	else :
		$info = $_GET[$var];
	endif;
	
	return $info;
}
//remove_filter( 'template_redirect', 'redirect_canonical' ); 

?>