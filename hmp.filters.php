<?php

add_filter( "the_content", "hmp_content_filter" );

/**
*
*	Append gallery images to post content for out of the box functionality.
*
*/
function  hmp_content_filter( $content ) {

	global $post;

	

	if ( 'hmp-entry' == get_post_type() && is_single() ) {

		// Look into this in the morning.

		//$gallery = hmp_get_gallery_images etc etc;
		//$gallery = get_post_meta( $post->ID, '_hmp_main_image', true ); 
	
		if( $gallery ) {
			foreach( $gallery as $attachment_id ) {
				$images .= wp_get_attachment_image($attachment_id, 'full' );
			}
			echo $images;
			$content .= $images;
		}
	
	}
	
	// Tests.
	$r .= '<img src="' . hmp_get_main_image( $post, 'thumbnail' ) . '"/>';
	$r .= '<img src="' . hmp_get_main_image( $post, array( 230,150), 0, $crop = true ) . '"/>';
	$r .= '<img src="' . hmp_get_main_image( $post, 150, 50, true ) . '"/>';
	
	$content .= $r;
	
	return $content;

}



?>