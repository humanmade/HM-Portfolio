<?php 

add_filter( 'the_content', 'jh_portfolio_insert_sidebar' );

function jh_portfolio_insert_sidebar($content) {
	global $post;
	
	if( $post->post_name != 'portfolio' )
		return $content;
		
		
	ob_start();
	dynamic_sidebar('Portfolio');
	$sidebar = ob_get_contents();
	ob_end_clean(); 
	
	
	return $sidebar . ' ' . $content;
}

?>