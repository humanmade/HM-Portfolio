<?php
/*
Plugin Name: PHP Thumb
Description: 
Version: 3.0
Author: Joe Hoyle
*/

/**
 * Resizes a given image (local).
 * 
 * @param mixed absolute path to the image
 * @param int $width.
 * @param int $height.
 * @param bool $crop. (default: false)
 * @return (string) url to the image
 */
function tw_phpthumb_it( $url, $width = 0, $height = 0, $crop = false, $resize = true, $watermark_options = array() ) {
	$uploads = wp_upload_dir();
		
	//check if it is a remote file (url) if so then download it and call this function on that file
	if( strpos( $url, 'http://' ) === 0 ) {
		
		$ext = '.' . end( explode( '.', $url ) );
		$sanitized_file = $uploads['basedir'] . '/remote-downloaded/' . sanitize_title($url) . $ext;
		
		if( !file_exists( $sanitized_file ) ) {
			if ( !is_dir( $uploads['basedir'] . '/remote-downloaded/' ) )
			@mkdir ($uploads['basedir'] . '/remote-downloaded/');
			include_once( ABSPATH . 'wp-includes/rss.php' );
			
			$file = _fetch_remote_file( $url );
			$handle = fopen( $sanitized_file,"w");
			fwrite($handle,$file->results);
			fclose($handle);
		}
		return tw_phpthumb_it( $sanitized_file, $width, $height, $crop, $resize, $watermark_options );
	}
	
	if( $width === 0 ) $width = 9999;
	if( $height === 0 ) $height = 9999;
	
	include_once( 'ThumbLib.inc.php' );
	
	$filename = end( explode( '/', $url ) );

	$ext = '.' . end( explode( '.', $filename ) );
	
	$filename = str_ireplace( $ext, '', $filename );
	$filename = str_ireplace( '_' . $width . '_' . $height, '', $filename );
	
	$new_name = $filename . '_' . $width . '_' . $height . ( $crop ? '_crop' : '') . ($resize ? '_resize' : '') . ($watermark_options['mask'] ? '_watermarked' : '') . '.png';
	
	// Attempt to create the cache directory
	if ( !is_dir( $uploads['basedir'] . '/cache/' ) )
		@mkdir ($uploads['basedir'] . '/cache/');
		
	$cache_dir = $uploads['basedir'] . '/cache/';
		
	// Only create the resized version if one hasn't already been created.
	if ( !file_exists( $cache_dir . $new_name ) ) :
		
		$url = str_replace( get_bloginfo('url'), ABSPATH, $url );
	
		try {
		     $thumb = PhpThumbFactory::create( $url );
		}
		catch (Exception $e) {
			error_log( $e );
			return false;
		}
		
		// Convert all images to png before resizing
		if ( $ext == '.gif' ) :
			
			// Save the converted image
			$thumb->save( $cache_dir . $filename . '.png', 'png' );
			
			// Pass the new file back through the function so they are resized
			return tw_phpthumb_it( $cache_dir . $filename . '.png', $width, $height, $crop, $resize ); 
		
		endif;
		
		// Remove the old version converted version if it exists
		if ( file_exists( $cache_dir . $filename . '.png' ) )
			unlink( $cache_dir . $filename . '.png' );
		
		// Resize and save the image
		
		if( $crop === true && $resize === true )
			$thumb->adaptiveResize( $width, $height );
		elseif( $crop === true && $resize === false ) {
			$thumb->cropFromCenter($width, $height);
		}
		else
			$thumb->resize( $width, $height );
		
		//watermarking
		if( $watermark_options['mask'] ) {
			$defaults = array( 'padding' => 0, 'position' => 'cc' );
			$watermark_options = wp_parse_args( $watermark_options, $defaults );
			$thumb->createWatermark($watermark_options['mask'], $watermark_options['position'], $watermark_options['padding']);
		}
		
		$thumb->save( $cache_dir . $new_name );
		
	endif;
	
	return str_replace( ABSPATH, get_bloginfo('url') . '/', $cache_dir . $new_name );
}

function tw_watermark_it( $image, $mask, $position = 'cc', $padding = 0 ) {

}
?>