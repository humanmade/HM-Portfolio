<?php
/**
 * Gets the current posts byline.
 * 
 * @param object $post. (default: global $post)
 * @return string
 */
function hmp_get_byline( $post = null ) {
	global $post;
	return (string) get_post_meta( $post->ID, '_byline', true );
}

/**
 * Gets the current posts brief.
 * 
 * @param object $post. (default: global $post)
 * @return string
 */
function hmp_get_brief( $post = null ) {
	if( $post === null ) global $post;
	return (string) get_post_meta( $post->ID, '_brief', true );
}

/**
 * Gets the current posts work url (not permalink).
 * 
 * @param object $post. (default: global $post)
 * @return string
 */
function hmp_get_url( $post = null ) {
	if( $post === null ) global $post;
	return (string) get_post_meta( $post->ID, '_url', true );
}

/**
 * Gets the current posts related work array (post ids).
 * 
 * @param object $post. (default: global $post)
 * @return array (post ids)
 */
function hmp_get_related_work( $post = null) {
	if( $post === null ) global $post;
	return array_filter((array) get_post_meta( $post->ID, '_related_work', true ));
}
/**
 * Checks whether the post has a set of meta info e.g. brief, url, related_work
 *
 * @param $post Post Object, default global $post; 
 * @param string comma seperated list of meta info. (default: 'url,related_work')
 * @return bool
 */
function hmp_has_info( $post = null, $string = '_url,_related_work' ) {
	if( $post === null ) global $post;
	$infos = explode( ',', $string );
	$return = false;
	foreach( $infos as $meta_key ) {
		//backwards compat for no underscores on meta_keys
		if( in_array( $meta_key, array( 'brief', 'byline', 'url', 'related_work', 'hmp_main_image', 'hmp_gallery_images' ) ) ) {
			$meta_key = '_' . $meta_key;
		}
		
	    return (bool) get_post_meta( $post->ID, $meta_key, true );
	}	
	return false;
}

// terms
/**
 * @see get_the_category()
*/
function hmp_get_the_category( $post = null ) {
	if( $post === null ) global $post;
	
	$categories = get_object_term_cache( $post->ID, 'hmp-entry-category' );
	if ( false === $categories ) {
		$categories = wp_get_object_terms( $post->ID, 'hmp-entry-category' );
		wp_cache_add($post->ID, $categories, 'hmp-entry-category_relationships');
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
	
	$r = is_object_in_term( $post->ID, 'hmp-entry-category', $category );
	if ( is_wp_error( $r ) )
		return false;
	
	return $r;
}

/**
 * @see the_category()
*/
function hmp_the_category(  $separator = '', $parents='', $post = null ) {
	if( $post === null ) global $post;
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
*	Get main image
*	$width_or_size: either a width value or a string keyword (thumbnail, medium, large or full) - if keyword, $h and $crop is ignored. 
*/
function hmp_get_main_image( $post = null, $width_or_size = 'full', $h = 0, $crop = false ) {
	if( $post === null ) global $post;

	$attachment_id = hmp_get_main_image_id($post);
	if( !$attachment_id )
		return null; 

	$crop =  $crop ? '1' : '0';
	
	if( is_numeric( $width_or_size ) ) { 
		$r = reset( wp_get_attachment_image_src( $attachment_id, "width=$width_or_size&height=$h&crop=$crop" ) );
	} else {
		$r = reset( wp_get_attachment_image_src( $attachment_id, $width_or_size ) );
	}
	
	return $r;
}
function hmp_get_main_image_id( $post = null ) {
	if( $post === null ) global $post;
	return (int) get_post_meta( $post->ID, '_hmp_main_image', true );
}

function hmp_get_gallery_images( $post = null, $w = 0, $h = 0, $crop = false ) {
	if( $post === null ) global $post;
	$images = array();
	$attachment_ids = hmp_get_gallery_ids($post);
	if( !$attachment_ids )
		return array();
	foreach( $attachment_ids as $id ) {
		$images[$id] = tj_phpthumb_it( get_attached_file( $id ), $w, $h, $crop );
	}
	return $images;
}

function hmp_get_gallery_image( $id, $w = 0, $h = 0, $crop = false ) {
	return tj_phpthumb_it( get_attached_file( $id ), $w, $h, $crop );
}

function hmp_get_gallery_ids( $post = null ) {
	if( $post === null ) global $post;
	return array_filter( (array) get_post_meta( $post->ID, '_hmp_gallery_images', true ) );
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