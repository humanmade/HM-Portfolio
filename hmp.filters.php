<?php
/**
*
*	Append gallery images to post content for out of the box functionality.
*
*/

if( get_option( 'hmp_append_gallery', 1 ) == true )
	add_filter( 'the_content', 'hmp_content_filter' );

function  hmp_content_filter( $content ) {
	global $post;
	
	if( get_post_type() != 'hmp-entry' )
		return $content;
	
	$content .= hmp_the_gallery(  );
	
	return $content; 
}

?>