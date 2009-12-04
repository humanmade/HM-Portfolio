<?php
add_filter( 'post_link', 'jhp_post_link', 10, 2);
function jhp_post_link( $permalink, $post ) {
	if( $post->post_type !== 'jh-portfolio' )
		return $permalink;
	$link = trailingslashit(get_bloginfo('url')) . get_option('jhp_url_base', 'portfolio') . '/' . array_shift(wp_get_object_terms( $post->ID, 'jh-portfolio-category' ))->slug . '/' . $post->post_name . '/';
	return $link;

}
?>