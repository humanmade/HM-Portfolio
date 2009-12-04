<?php
/**
 * ShrinkTheWeb Url Thumbnail Utility Package
 *
 * Version: 1.0.2
*/
function shrinktheweb($size, $url, $show_exists = false){
	$access_key_id=get_option('jh_portfolio_access_key_id'); // Replace [Access_Key_Id] with your actual Access_Key_Id
	$secret_access_key=get_option('jh_portfolio_secret_key'); // Replace [Secret_Access_Key] with your actual Secret_Access_Key
	$default_image="http://www.neobus.net/images/thumbs/nothumb.jpg"; // Enter the default image you would like shown if no thumbnail
	$cache=0; // Set to 1, if you want to save thumbnails locally (config function get_html_snippet also)
	
	$url_enc = urlencode($url);

	$request_url =  "http://www.shrinktheweb.com/xino.php?"
					. "Service=".           "ShrinkWebUrlThumbnail"
					. "&Action=".           "Thumbnail"
					. "&STWAccessKeyId=".   $access_key_id
					. "&Size=" .            $size
					. "&stwu=" .			$secret_access_key
					. "&stwUrl=" .          $url;

	$line=make_http_request($request_url);
	$num_matches = preg_match('/<[^:]*:Thumbnail\\s*(?:Exists=\"((?:true)|(?:false))\")?[^>]*>([^<]*)<\//', $line, $matches);
	if($num_matches == 1){
		$exists = $matches[1];
		$thumbnail = $matches[2];
	}else{
		$exists = NULL;
		$thumbnail = NULL;
	}
	
	if( $show_exists == true )
		return $exists;
		
	return $thumbnail;
}

// Make an http request to the specified URL and return the result
function make_http_request($url){
	$lines = file($url);
	return implode("", $lines);
}

function website_thumbnail_exists( $url ) {
	return shrinktheweb( 'xlg', $url, true );
}

function request_website_thumbnail( $url ) {
	$image = shrinktheweb( 'xlg', $url );
	return $image;
}

function get_website_thumbnail( $url, $post_id ) {
	if( strpos( $url, 'http://' ) !== 0 )
		$url = 'http://' . $url;
		
	$url = untrailingslashit($url);
	
	$image = shrinktheweb( $size, $url );
	
	//if exists download and attach to post
	if( $image ) {
		return attach_image_to_post( $url, $post_id );
	}
	return $image;
}

function attach_image_to_post( $url, $post_id ) {
	$image_url = request_website_thumbnail( $url );
	$http = wp_remote_request( $image_url );
	
	if ( is_wp_error( $http ) )
	    return false;
	
	$file = $http['body'];
	
	$uploads_path = wp_upload_dir();
	
	if ( $uploads_path['error'] )
	    $uploads_path['basedir'] = ABSPATH . '/wp-content/uploads';
	
	$image_path = $uploads_path['basedir'] . '/' . sanitize_title($url) . '.jpg';
	        
	if ( $file )			
	    $bytes = file_put_contents( $image_path, $file );
	   
	//create the attachment
	return wp_insert_attachment( array( 'post_parent' => $post_id ), $image_path );
	
}



?>