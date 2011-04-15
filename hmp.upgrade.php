<?php

function hmp_upgrade() {
	hmp_upgrade_extra_taxonomy_to_tags();
	hmp_upgrade_post_meta_to_prepend_underscores();
}

function hmp_upgrade_extra_taxonomy_to_tags() {
	global $wpdb;
	$wpdb->query( "UPDATE $wpdb->term_taxonomy SET taxonomy='hmp-entry-tag' WHERE taxonomy='jh_portfolio_extra_taxonomy'" );
}

function hmp_upgrade_post_meta_to_prepend_underscores() {
	global $wpdb;
	
	//use "brief" as the indicater if it needs updating
	error_log( 'HMP: Checking if meta needs upgrade...' );
	if( $wpdb->get_var( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='brief'" ) ) {
		error_log( 'HMP: Upgrading meta keys...' );
		
		error_log( 'HMP: Upgrading meta key: brief...' );
		$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = '_brief' WHERE meta_key = 'brief';");
		
		error_log( 'HMP: Upgrading meta key: byline...' );
		$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = '_byline' WHERE meta_key = 'byline';");
		
		error_log( 'HMP: Upgrading meta key: url...' );
		$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = '_url' WHERE meta_key = 'url';");
		
		error_log( 'HMP: Upgrading meta key: related_work...' );
		$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = '_related_work' WHERE meta_key = 'related_work';");
		
		error_log( 'HMP: Upgrading meta key: hmp_gallery_images...' );
		$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = '_hmp_gallery_images' WHERE meta_key = 'hmp_gallery_images';");
		
		error_log( 'HMP: Upgrading meta key: hmp_main_image...' );
		$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = '_thumbnail_id' WHERE meta_key = 'thumbnail_id';");

		error_log( 'HMP: Upgrading meta keys done' );

	}
}

/**
*	Function to handle upgrading from JH Portfolio.
*
*	Change all references in database from JH or JHP to HMP
*
*/

function hmp_upgrade_jhp() {
	global $wpdb;
	
	//Change custom fields.
	$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key='_hmp_main_image' WHERE meta_key='_jhp_main_image'" );
	$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key='_thumbnail_id' WHERE meta_key='_hmp_main_image'" );
	$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key='_hmp_gallery_images' WHERE meta_key='_jhp_gallery_images'" );
	$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key='_hmp_brief' WHERE meta_key='_brief'" );
	$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key='_hmp_url' WHERE meta_key='_url'" );
	$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key='_hmp_related_work' WHERE meta_key='_related_work'" );
	
	//Change post type to new post type.
	$wpdb->query( "UPDATE $wpdb->posts SET post_type='hmp-entry' WHERE post_type='jh-portfolio'" );
	
	//Change Taxonomies
   	$wpdb->query( "UPDATE $wpdb->term_taxonomy SET taxonomy='hmp-entry-category' WHERE taxonomy='jh-portfolio-category'" );
	
	//Change portfolio-tags to normal tags.	
	//Need to register the old taxonomy so I can check for it. 
	register_taxonomy( 'jh-portfolio-tag', 'hmp-entry' );	
	
	$hmp_query = new WP_Query('post_type=hmp-entry');
	while( $hmp_query->have_posts() ) : $hmp_query->the_post(); 
		global $post; 
		$terms = wp_get_object_terms( $post->ID, 'jh-portfolio-tag' );
		
		if( is_array( $terms )) {
			$term_names = array();
			foreach( $terms as $term ) {
				$term_names[] = $term->name;								
			}
			$new_terms = wp_set_object_terms( $post->ID, $term_names, 'post_tag' );
		}
	endwhile;

	$args = array( 'hide_empty' => false );
	$terms = get_terms('jh-portfolio-tag', $args);
	
	foreach( $terms as $term ) {
		wp_delete_term( $term->term_id, 'jh-portfolio-tag'  );
	}
	
	//Change options
	$value = get_option( 'jhp_url_base' );
	if( $value ) {
		add_option( 'hmp_url_base', $value );
		delete_option('jhp_url_base');
	}
	$value = get_option( 'jhp_single_base' );
	if( $value ) {
		add_option( 'hmp_single_base', $value );
		delete_option('jhp_single_base');
	}
	$value = get_option( 'jhp_add_page_link' );
	if( $value ) {
		add_option( 'hmp_add_page_link', $value );
		delete_option('jhp_add_page_link');
	}
	$value = get_option( 'jhp_use_styles' );
	if( $value ) {
		add_option( 'hmp_use_styles', $value );
		delete_option('jhp_use_styles');
	}	
	$value = get_option( 'jhp_use_scripts' );
	if( $value ) {
		add_option( 'hmp_use_scripts', $value );
		delete_option('jhp_use_scripts');
	}	
	$value = get_option( 'jhp_title' );
	if( $value ) {
		add_option( 'hmp_title', $value );
		delete_option('jhp_title');
	}	
	$value = get_option( 'jhp_template_single' );
	if( $value ) {
		add_option( 'hmp_template_single', $value );
		delete_option('jhp_template_single');
	}	
	$value = get_option( 'jhp_template_home' );
	if( $value ) {
		add_option( 'hmp_template_home', $value );
		delete_option('jhp_template_home');
	}	
	$value = get_option( 'jhp_template_category' );
	if( $value ) {
		add_option( 'hmp_template_category', $value );
		delete_option('jhp_template_category');
	}	
	$value = get_option( 'jhp_template_tag' );
	if( $value ) {
		add_option( 'hmp_template_tag', $value );
		delete_option('jhp_template_tag');
	}	
	$value = get_option( 'jhp_portfolio_menu_order' );
	if( $value ) {
		add_option( 'hmp_portfolio_menu_order', $value );
		delete_option('jhp_portfolio_menu_order');
	}
}

?>