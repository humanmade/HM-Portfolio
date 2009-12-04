<?php 
add_filter( 'the_content', 'jhp_single_content' );
function jhp_single_content( $content ) {
	global $post;
	
	ob_start();
	dynamic_sidebar('Portfolio Single');
	$sidebar = ob_get_contents();
	ob_end_clean(); 
	
	return $sidebar . ' ' . $content;
}
?>
<?php include( get_template_directory() . '/single.php' ) ?>