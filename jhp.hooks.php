<?php
add_filter( 'post_link', 'jhp_post_link', 10, 3);
function jhp_post_link( $permalink, $post, $leavename = false ) {	
	if( $post->post_type !== 'jh-portfolio' )
		return $permalink;
	
	//hack for drafts have no post_name
	if( $post->post_title && !$post->post_name )
		$post->post_name = sanitize_title( $post->post_title );
				
	$portfolio_base = get_option('jhp_url_base', 'portfolio');
	if( $portfolio_base != '' )
		 $portfolio_base .= '/';
	
	$single_base = untrailingslashit(get_option('jhp_single_base', '%category%'));
	$single_base = str_ireplace( '%category%', array_shift(wp_get_object_terms( $post->ID, 'jh-portfolio-category' ))->slug, $single_base );
	if( $single_base != '' )
		 $single_base .= '/';
		 
	$link = trailingslashit(get_bloginfo('url')) . $portfolio_base . $single_base . ( $leavename ? '%postname%' : $post->post_name ) . '/';
	return $link;

}

//add the portfoli link to wp_list_pages
if( get_option( 'jhp_add_page_link', 'on' ) )
	add_filter( 'get_pages', 'jhp_add_link_to_get_pages', 10, 2);
	
function jhp_add_link_to_get_pages( $data, $arg ) {
	
	$found = false;
	foreach( debug_backtrace() as $call ) {
		if( $call['function'] == 'wp_list_pages' ) {
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
		'post_title' => 'Portfolio',
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
return apply_filters('page_link', $link, $id);

?>