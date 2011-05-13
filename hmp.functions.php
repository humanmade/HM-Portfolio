<?php
/**
 * Gets the current posts byline.
 * 
 * @param object $post. (default: global $post)
 * @return string
 */
function hmp_get_byline( $post = null ) {
	global $post;
	
	if( !is_numeric( $post ) ) 
		$post = $post->ID;

		
	return (string) get_post_meta( $post, '_hmp_byline', true );
}

/**
 * Gets the current posts brief.
 * 
 * @param post ID or object $post. (default: global $post)
 * @return string
 */
function hmp_get_brief( $post = null ) {
	
	if( $post === null ) global $post;
	
	if( !is_numeric( $post ) ) 
		$post = $post->ID;

	return (string) get_post_meta( $post, '_hmp_brief', true );
}

/**
 * Gets the current posts work url (not permalink).
 * 
 * @param post ID or object $post. (default: global $post)
 * @return string
 */
function hmp_get_url( $post = null ) {

	if( $post === null ) global $post;
	
	if( !is_numeric( $post ) ) 
		$post = $post->ID;

	return (string) get_post_meta( $post, '_hmp_url', true );
}

/**
 * Gets the current posts related work array (post ids).
 * 
 * @param post id or object $post. (default: global $post)
 * @return array (post ids)
 */
function hmp_get_related_work( $post = null) {

	if( $post === null ) global $post;
	
	if( !is_numeric( $post ) ) 
		$post = $post->ID;

	return array_filter((array) get_post_meta( $post, '_hmp_related_work', true ));

}
/**
 * Checks whether the post has a set of meta info e.g. brief, url, related_work
 *
 * @param post id or $post Post Object, default global $post; 
 * @param string comma seperated list of meta info. (default: 'url,related_work')
 * @return bool
 */
function hmp_has_info( $post = null, $string = '_url,_related_work' ) {
	if( $post === null ) global $post;
	if( !is_numeric( $post ) ) 
		$post = $post->ID;
	$infos = explode( ',', $string );
	$return = false;
	foreach( $infos as $meta_key ) {
		//backwards compat for no underscores on meta_keys
		if( in_array( $meta_key, array( 'brief', 'byline', 'url', 'related_work', 'thumbnail_id', 'hmp_gallery_images' ) ) ) {
			$meta_key = '_' . $meta_key;
		}
		
	    return (bool) get_post_meta( $post, $meta_key, true );
	}	
	return false;
}

// terms
/**
 * @see get_the_category()
*/
function hmp_get_the_category( $post = null ) {

	if( $post === null ) global $post;
	
	if( !is_numeric( $post ) ) 
		$post = $post->ID;
	
	$categories = get_object_term_cache( $post, 'hmp-entry-category' );
	if ( false === $categories ) {
		$categories = wp_get_object_terms( $post, 'hmp-entry-category' );
		wp_cache_add($post, $categories, 'hmp-entry-category_relationships');
	}

	if ( !empty( $categories ) )
		usort( $categories, '_usort_terms_by_name' );
	else
		$categories = array();

	foreach ( (array) array_keys( $categories ) as $key ) {
		_make_cat_compat( $categories[$key] );
	}

	return $categories;
}

/**
 * @see get_category_link()
*/
function hmp_get_category_link( $id ) {
	return get_term_link( $id, 'hmp-entry-category' );
}


/**
 * @see in_category()
*/
function hmp_in_category( $category, $post = null ) {
	
	if( $post === null ) global $post;
	
	if( !is_numeric( $post ) ) 
		$post = $post->ID;
	
	$r = is_object_in_term( $post, 'hmp-entry-category', $category );
	if ( is_wp_error( $r ) )
		return false;
	
	return $r;
}

/**
 * @see the_category()
*/
function hmp_the_category(  $separator = '', $parents='', $post = null ) {

	if( $post === null ) global $post;
	
	if( !is_numeric( $post ) ) 
		$post = $post->ID;

	$categories = hmp_get_the_category( $post );
	
	$thelist = '';
	if ( '' == $separator ) {
		$thelist .= '<ul class="post-categories">';
		foreach ( $categories as $category ) {
			$thelist .= "\n\t<li>";
			switch ( strtolower( $parents ) ) {
				case 'single':
					$thelist .= '<a href="' . hmp_get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( "View all entries in %s" ), $category->name ) ) . '">';
					if ( $category->parent )
						$thelist .= get_category_parents( $category->parent, false, $separator );
					$thelist .= $category->name.'</a></li>';
					break;
				case '':
				default:
					$thelist .= '<a href="' . hmp_get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( "View all entries in %s" ), $category->name ) ) . '">' . $category->cat_name.'</a></li>';
			}
		}
		$thelist .= '</ul>';
	} else {
		$i = 0;
		foreach ( $categories as $category ) {
			if ( 0 < $i )
				$thelist .= $separator . ' ';
			switch ( strtolower( $parents ) ) {
				case 'single':
					$thelist .= '<a href="' . hmp_get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( "View all entries in %s" ), $category->name ) ) . '">';
					$thelist .= "$category->cat_name</a>";
					break;
				case '':
				default:
					$thelist .= '<a href="' . hmp_get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( "View all entries in %s" ), $category->name ) ) . '">' . $category->name.'</a>';
			}
			++$i;
		}
	}
	
	return apply_filters( 'the_category', $thelist, $separator, $parents );
	
}

/**
 * @see get_the_tags
 */
function hmp_get_the_tags( $id = 0 ) {
	return apply_filters( 'get_the_tags', get_the_terms( $id, 'hmp-entry-tag' ) );
}

/**
 * @see get_the_tag_list
 */
function hmp_get_the_tag_list( $before = '', $sep = '', $after = '' ) {
	return apply_filters( 'the_tags', get_the_term_list( 0, 'hmp-entry-tag', $before, $sep, $after ), $before, $sep, $after);
}

/**
 * @see the_tags
 */
function hmp_the_tags( $before = null, $sep = ', ', $after = '' ) {
	if ( null === $before )
		$before = __('Tags: ');
	echo hmp_get_the_tag_list($before, $sep, $after);
}


// image functions


/**
*
*	Easy function
*
*	Output the whole gallery.
*
*	Size is either keyword or array($width, $height, $crop [true/false])
*/

function hmp_the_gallery ( $post = null, $size = 'full', $before = null, $after = null, $show_main = true ) {
	
	if( $post === null ) global $post;
	
	if( !is_numeric( $post ) ) 
		$post = $post->ID;

	$r = '';
	
	if( is_array( $size ) ) {
		$size = 'width=' . $size[0] . '&height=' . $size[1] . '&crop=' . $size[2];
	} 
		
	if( $show_main ) {
		$r .= $before;
		$r .= hmp_get_the_main_image( $post, $size, $h = null );
		$r .= $after;
	}
		
	$gallery = hmp_get_the_gallery_images( $post, $size );
	if( is_array( $gallery )) {
		foreach ( $gallery as $img ) { 
			$r .= $before;
			$r .= $img;
			$r .= $after;
		}
	}
	
	return $r;

}


/**
*	Deprecated. Use hmp_get_the_main_image() instead.
*	Get main image
*	$width_or_size: either a width value or a string keyword (thumbnail, medium, large or full) - if keyword, $h and $crop is ignored. 
*/
function hmp_get_main_image( $post = null, $width_or_size = 'full', $h = 0, $crop = false ) {

	if( $post === null ) global $post;
	
	if( !is_numeric( $post ) ) 
		$post = $post->ID;

	$attachment_id = hmp_get_main_image_id($post);
	if( !$attachment_id )
		return null; 

	$crop =  $crop ? '1' : '0';
	
	if( is_numeric( $width_or_size ) ) { 
		return reset( wp_get_attachment_image_src( $attachment_id, "width=$width_or_size&height=$h&crop=$crop" ) );
	} else {
		return reset( wp_get_attachment_image_src( $attachment_id, $width_or_size ) );
	}
}


/**
*
*	Returns Main <img>
*
*/
function hmp_get_the_main_image( $post = null, $width_or_size = 'full', $h = 0, $crop = false ) {
	
	if( $post === null ) global $post;
	
	if( !is_numeric( $post ) ) 
		$post = $post->ID;

	$attachment_id = hmp_get_main_image_id( $post );
	if( !$attachment_id )
		return null; 

	$crop =  $crop ? '1' : '0';
	
	if( is_numeric( $width_or_size ) ) { 
		return wp_get_attachment_image( $attachment_id, "width=$width_or_size&height=$h&crop=$crop" );
	} else {
		return wp_get_attachment_image( $attachment_id, $width_or_size );
	}
}


function hmp_get_main_image_id( $post = null ) {

	if( $post === null ) global $post;
	
	if( !is_numeric( $post ) ) 
		$post = $post->ID;

	return (int) get_post_meta( $post, '_thumbnail_id', true );
}

/**
*	Deprecated.
*
*	Use hmp_get_the_gallery_images() instead
*
*/
function hmp_get_gallery_images( $post = null, $width_or_size = 'full', $h = 0, $crop = false ) {

	if( $post === null ) global $post;
	
	if( !is_numeric( $post ) ) 
		$post = $post->ID;

	$images = array();
	
	$attachment_ids = hmp_get_gallery_ids($post);
	if( !$attachment_ids )
		return array();
	
	if( is_numeric( $width_or_size ) ) {
		$crop =  $crop ? '1' : '0'; 
		foreach( $attachment_ids as $id ) {
			if( $image = wp_get_attachment_image_src( $id, "width=$width_or_size&height=$h&crop=$crop" ) )
				$images[$id] = reset( $image );
		}
	} else {
		foreach( $attachment_ids as $id ) {
			if( $image = wp_get_attachment_image_src( $id, $width_or_size ) )
				$images[$id] = reset( $image );
		}
	}
	return $images;
}

/**
*
*	Return an array of <img> for gallery. 
*	Does not return main image. 
*
*/
function hmp_get_the_gallery_images( $post = null, $width_or_size = 'full', $h = 0, $crop = false ) {

	if( $post === null ) global $post;
	
	if( !is_numeric( $post ) ) 
		$post = $post->ID;

	$images = array();
	
	$attachment_ids = hmp_get_gallery_ids($post);
	if( !$attachment_ids )
		return array();
	
	if( is_numeric( $width_or_size ) ) {
		$crop =  $crop ? '1' : '0'; 
		foreach( $attachment_ids as $id ) {
			$images[$id] = wp_get_attachment_image( $id, "width=$width_or_size&height=$h&crop=$crop" );
		}
	} else {
		foreach( $attachment_ids as $id ) {
			$images[$id] = wp_get_attachment_image( $id, $width_or_size );
		}
	}
	return $images;
}


function hmp_get_gallery_image( $id, $w = 0, $h = 0, $crop = false ) {
	return hm_phpthumb_it( get_attached_file( $id ), $w, $h, $crop );
}

function hmp_get_gallery_ids( $post = null ) {

	if( $post === null ) global $post;
	
	if( !is_numeric( $post ) ) 
		$post = $post->ID;

	return array_filter( (array) get_post_meta( $post, '_hmp_gallery_images', true ) );
}

/**
 * Get the array of wp_query vars that HMP Portfolio uses
 * 
 * @return array
 */
function hmp_default_query_vars() {
	$vars = array( 'post_type' => 'hmp-entry' );
	return $vars;
}

function hmp_is_home() {
	global $wp_query;
	return (bool) $wp_query->is_portfolio || $wp_query->query['is_portfolio'];
}

function hmp_is_single() {
	global $wp_query;
	return (bool) $wp_query->is_portfolio_single || $wp_query->query['is_portfolio_single'];
}

function hmp_is_portfolio() {
	return hmp_is_home() || hmp_is_single();
}

function hmp_get_single_permalink_structure() {
	
	$single_base = get_option( 'hmp_single_base', '/%category%/' );
	$single_base = '/' . trim( $single_base, '/' );
	
	$single_base = str_replace( array( '%category%' ), '%hmp-entry-category%', $single_base );
	
	return get_option('hmp_url_base', 'portfolio') . $single_base;
}