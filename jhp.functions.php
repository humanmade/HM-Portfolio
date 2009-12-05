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

// image functions
function jhp_get_main_image( $post = null, $w = 0, $h = 0, $crop = false ) {
	if( $post === null ) global $post;
	$attachment_id = jhp_get_main_image_id($post);
	if( !$attachment_id )
		return null;
	return tw_phpthumb_it( get_attached_file( $attachment_id ), $w, $h, $crop );
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
		$images[$id] = tw_phpthumb_it( get_attached_file( $id ), $w, $h, $crop );
	}
	return $images;
}

function jhp_get_gallery_image( $id, $w = 0, $h = 0, $crop = false ) {
	return tw_phpthumb_it( get_attached_file( $id ), $w, $h, $crop );
}

function jhp_get_gallery_ids( $post = null ) {
	if( $post === null ) global $post;
	return array_filter( (array) get_post_meta( $post->ID, 'jhp_gallery_images', true ) );
}
?>