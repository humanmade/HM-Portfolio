<?php 
add_filter( 'the_content', 'jhp_single_content' );
function jhp_single_content( $content ) {
	global $post;
	
	ob_start();
	dynamic_sidebar('Portfolio Single');
	$sidebar = ob_get_contents();
	ob_end_clean(); 
	return $sidebar;
}
?>
<?php 
if( get_option( 'jhp_use_styles', 'on' ) ) {
	wp_enqueue_style( 'jh-portfolio', JHPURL . 'template/styles/style.css' );
	wp_enqueue_style( 'lightbox.css', JHPURL . 'template/styles/jquery.lightbox-0.5.css' );
}
if( get_option( 'jhp_use_scripts', 'on' ) ) {
	wp_enqueue_script( 'lightbox', JHPURL . 'template/js/jquery.lightbox-0.5.min.js', array( 'jquery' ) );
}
if( file_exists( $file = get_template_directory() . '/single.php' ) ) {
	include( $file );  
} else {
	include( get_template_directory() . '/index.php' );
}
?>