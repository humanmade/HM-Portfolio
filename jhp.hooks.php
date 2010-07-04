<?php

//add the portfolio link to wp_list_pages
if( get_option( 'jhp_add_page_link', 'on' ) )
	add_filter( 'get_pages', 'jhp_add_link_to_get_pages', 10, 2);

/**
 * Hooks into get_pages to spoof a link to the Portfolio page when using wp_list_pages().
 *
 * @param array $data - pages
 * @param mixed $arg
 * @return array
 */
function jhp_add_link_to_get_pages( $data, $arg ) {

	$found = false;
	foreach( debug_backtrace() as $call ) {

		if( $call['function'] == 'wp_list_pages' ) {
			$args = wp_parse_args( $call['args'][0] );

			if( !isset( $args['child_of'] ) || !$args['child_of'] )
				$found = true;
			break;
		}
	}

	if( !$found )
		return $data;

	$menu_order = (int) get_option('jhp_portfolio_menu_order', 0);

	$item = (object) array(
		'ID' => 987654321,
		'post_name' => 'portfolio',
		'post_title' => get_option( 'jhp_title', 'Portfolio' ) ,
		'menu_order' => $menu_order,
		'post_parent' => 0
	);

	if( $menu_order === 0 ) {
		array_unshift( $data, $item );
	} else {
		$data = array_merge( array_slice( $data, 0, $menu_order ), array( $item ), array_slice( $data, $menu_order ) );
	}

	//set the queried object for wp_query here to make current_page work in wp_list_pages
	global $wp_query;

	if( $wp_query->is_portfolio || $wp_query->is_portfolio_single ) {
		$wp_query->queried_object = $item;
		$wp_query->queried_object_id = $item->ID;
	}

	return $data;
}


add_filter( 'page_link', 'jhp_add_link_to_wp_list_pages_link', 10, 2 );
function jhp_add_link_to_wp_list_pages_link( $link, $id ) {
	if( $id !== 987654321 )
		return $link;
	$portfolio_base = get_option('jhp_url_base', 'portfolio');
	if( $portfolio_base != '' )
		 $portfolio_base .= '/';
	return trailingslashit( get_bloginfo('url') ) . $portfolio_base;
}


/**
 * jhp_post_link function.
 * 
 * @param string $link - supposed permalinks
 * @param object $post
 * @return string - new permalink
 */
function jhp_post_link( $link, $post ) {

	if ( strpos( $link, '%jh-portfolio-category%' ) === false )
		return $link;
		
	$terms = wp_get_object_terms( $post->ID, 'jh-portfolio-category' );

	if ( current( $terms ) ) :

		$new_parent = current( $terms );

		foreach ( $terms as $term ) {
		    if ( $term->parent == 0 ) {
		    	$new_parent = $term;
		    	break;
		    }
		}

		$new_parent = $new_parent ? $new_parent : $terms[0];

		$category_string = $new_parent->slug;

		$category_string = trim( $category_string, '/' );

	endif;

	$category_string = ( isset( $category_string ) && $category_string ) ? $category_string : 'uncategorized';
	
	$link = jhp_get_single_permastruct();
	
	$link = str_replace( '%category%', $category_string, $link );
	$link = str_replace( '%post_name%', $post->post_name, $link );
	
	return $link;

}
add_filter( 'post_type_link', 'jhp_post_link', 10, 2 );