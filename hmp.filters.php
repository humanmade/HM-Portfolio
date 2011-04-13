<?php
/**
*
*	Append gallery images to post content for out of the box functionality.
*
*/


add_filter( "the_content", "hmp_content_filter" );

function  hmp_content_filter( $content ) {
	global $post;

	//$content .= hmp_the_gallery( $post, array( 250, 100, true), '<p>', '</p>', false );
	//$content .= hmp_the_gallery( $post, 'thumbnail' );
	
	$content .= hmp_the_gallery(  );
	return $content; 

}



?>