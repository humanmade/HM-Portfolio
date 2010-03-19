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

add_filter( 'the_title', 'jhp_portfolio_title', 10, 2 );
function jhp_portfolio_title( $title, $post_id = null ) {
	
	//if the post id is not set, it is not coming from get_the_title (nasty hack but works)
	if( $post_id === null )
		return $title;

	global $wp_query, $wp_the_query, $post;
		
	if( $wp_query !== $wp_the_query || !in_the_loop() || $post->post_type !== 'jh-portfolio' ) {
		return $title;
	} 
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

if( file_exists( get_template_directory() . '/page.php' ) ) {
	include( get_template_directory() . '/page.php' );
}
else {
	include( get_template_directory() . '/index.php' );
}