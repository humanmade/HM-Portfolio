<?php
add_filter( 'post_link', 'jhp_post_link', 10, 2);
function jhp_post_link( $permalink, $post ) {
	if( $post->post_type !== 'jh-portfolio' )
		return $permalink;
	$link = trailingslashit(get_bloginfo('url')) . get_option('jhp_url_base', 'portfolio') . '/' . array_shift(wp_get_object_terms( $post->ID, 'jh-portfolio-category' ))->slug . '/' . $post->post_name . '/';
	return $link;

}

//add the portfoli link to wp_list_pages
if( get_option( 'jhp_add_page_link', 'on' ) )
	add_filter( 'wp_list_pages', 'jhp_add_link_to_wp_list_pages', 10, 2);
	
function jhp_add_link_to_wp_list_pages( $data, $args ) {
	$li = '<li class="page_item"><a href="' . trailingslashit(get_bloginfo('url')) . get_option('jhp_url_base', 'portfolio') . '">Portfolio</a></li>';
	
	if( strrpos( $data, '</ul></li>' ) === (strlen( $data ) - 10) ) {
		$data = substr( $data, 0, strrpos( $data, '</ul></li>' ) );
		return $data . $li . '</ul></li>';
	} else if( strrpos( $data, '</ul>' ) === (strlen( $data ) - 5) ) {
		$data = substr( $data, 0, strrpos( $data, '</ul>' ) );
		return $data . $li . '</ul>';
	}
	
	return $data . $li;
	
	
}
?>