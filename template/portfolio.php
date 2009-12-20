<?php 
add_filter( 'the_content', 'jhp_portfolio_content' );
function jhp_portfolio_content( $content ) {
	global $post, $done_jhp_selector_widget;
	if( $done_jhp_selector_widget === true )
		return $content;
	ob_start();
	dynamic_sidebar('Portfolio Home');
	$sidebar = ob_get_contents();
	ob_end_clean(); 
	
	$done_jhp_selector_widget = true;
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

include( get_template_directory() . '/page.php' ); ?>