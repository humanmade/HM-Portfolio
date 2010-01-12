<?php
/**
 * Gets the current posts byline.
 * 
 * @param object $post. (default: global $post)
 * @return string
 */
function jhp_get_byline( $post = null ) {
	global $post;
	return (string) get_post_meta( $post->ID, 'byline', true );
}

/**
 * Gets the current posts brief.
 * 
 * @param object $post. (default: global $post)
 * @return string
 */
function jhp_get_brief( $post = null ) {
	if( $post === null ) global $post;
	return (string) get_post_meta( $post->ID, 'brief', true );
}

/**
 * Gets the current posts work url (not permalink).
 * 
 * @param object $post. (default: global $post)
 * @return string
 */
function jhp_get_url( $post = null ) {
	if( $post === null ) global $post;
	return (string) get_post_meta( $post->ID, 'url', true );
}

/**
 * Gets the current posts related work array (post ids).
 * 
 * @param object $post. (default: global $post)
 * @return array (post ids)
 */
function jhp_get_related_work( $post = null) {
	if( $post === null ) global $post;
	return array_filter((array) get_post_meta( $post->ID, 'related_work', true ));
}
/**
 * Checks whether the post has a set of meta info e.g. brief, url, related_work
 *
 * @param $post Post Object, default global $post; 
 * @param string comma seperated list of meta info. (default: 'url,related_work')
 * @return bool
 */
function jhp_has_info( $post = null, $string = 'url,related_work' ) {
	if( $post === null ) global $post;
	$infos = explode( ',', $string );
	$return = false;
	foreach( $infos as $meta_key ) {
	    return (bool) get_post_meta( $post->ID, $meta_key, true );
	}	
	return false;
}
	
// image functions
function jhp_get_main_image( $post = null, $w = 0, $h = 0, $crop = false ) {
	if( $post === null ) global $post;
	$attachment_id = jhp_get_main_image_id($post);
	if( !$attachment_id )
		return null;
	return tj_phpthumb_it( get_attached_file( $attachment_id ), $w, $h, $crop );
}

function jhp_get_main_image_id( $post = null ) {
	if( $post === null ) global $post;
	return (int) get_post_meta( $post->ID, 'jhp_main_image', true );
}
function jhp_get_gallery_images( $post = null, $w = 0, $h = 0, $crop = false ) {
	if( $post === null ) global $post;
	$images = array();
	$attachment_ids = jhp_get_gallery_ids($post);
	if( !$attachment_ids )
		return array();
	foreach( $attachment_ids as $id ) {
		$images[$id] = tj_phpthumb_it( get_attached_file( $id ), $w, $h, $crop );
	}
	return $images;
}

function jhp_get_gallery_image( $id, $w = 0, $h = 0, $crop = false ) {
	return tj_phpthumb_it( get_attached_file( $id ), $w, $h, $crop );
}

function jhp_get_gallery_ids( $post = null ) {
	if( $post === null ) global $post;
	return array_filter( (array) get_post_meta( $post->ID, 'jhp_gallery_images', true ) );
}

/**
 * Get the array of wp_query vars that jh portfolio uses
 * 
 * @return array
 */
function jhp_default_query_vars() {
	$vars = array( 'post_type' => 'jh-portfolio' );
	return $vars;
}

function jhp_is_home() {
	global $wp_query;
	return (bool) $wp_query->is_portfolio;
}

function jhp_is_single() {
	global $wp_query;
	return (bool) $wp_query->is_portfolio_single;
}

function jhp_is_portfolio() {
	return jhp_is_home() || jhp_is_single();
}