<?php 
add_filter( 'the_content', 'jhp_portfolio_content' );
function jhp_portfolio_content( $content ) {
	global $post, $done_jhp_selector_widget;
	if( $done_jhp_selector_widget === true || !in_the_loop() )
		return $content;
	ob_start();
	dynamic_sidebar('Portfolio Home');
	$sidebar = ob_get_contents();
	ob_end_clean(); 
	
	$done_jhp_selector_widget = true;
	return $sidebar;
}

add_filter( 'the_title', 'jhp_portfolio_title' );
function jhp_portfolio_title( $title ) {
	global $done_jhp_portfolio_title;
	if( $done_jhp_portfolio_title || !in_the_loop() ) {
		return $title;
	} 
	$done_jhp_portfolio_title = true;
	return get_option( 'jhp_title', 'Portfolio' );
}

add_filter( 'the_time', 'jhp_portfolio_time' );
function jhp_portfolio_time( $time ) {
	if( !in_the_loop() ) {
		return $time;
	} 
	return '';
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

include( get_template_directory() . '/archive.php' ); ?>