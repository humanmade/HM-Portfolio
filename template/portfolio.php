<?php 
add_filter( 'the_content', 'jhp_single_content' );
function jhp_single_content( $content ) {
	global $post, $done_jhp_selector_widget;
	if( $done_jhp_selector_widget === true )
		return $content;
	ob_start();
	dynamic_sidebar('Portfolio');
	ob_end_clean(); 
	
	$done_jhp_selector_widget = true;
	return $sidebar . ' ' . $content;
}
?>
<?php include( get_template_directory() . '/single.php' ) ?>