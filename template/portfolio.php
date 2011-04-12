<?php 
add_filter( 'the_content', 'hmp_portfolio_content' );
function hmp_portfolio_content( $content ) {
	global $post, $done_hmp_selector_widget;
		
	if( $done_hmp_selector_widget === true || !in_the_loop() )
		return $content;
	ob_start();
	dynamic_sidebar('Portfolio Home');
	$sidebar = ob_get_contents();
	ob_end_clean(); 
		
	$done_hmp_selector_widget = true;

	return $sidebar;
}

add_filter( 'the_title', 'hmp_portfolio_title', 10, 2 );
function hmp_portfolio_title( $title, $post_id = null ) {
	
	//if the post id is not set, it is not coming from get_the_title (nasty hack but works)
	if( $post_id === null )
		return $title;

	global $wp_query, $wp_the_query, $post;
	
	if( $wp_query->query_vars['is_portfolio'] && $wp_query->in_the_loop && $wp_query == $wp_the_query )
		return get_option( 'hmp_title', 'Portfolio' );
	
	return $title;
}

add_filter( 'the_time', 'hmp_portfolio_time' );
function hmp_portfolio_time( $time ) {
	if( !in_the_loop() ) {
		return $time;
	} 
	return '';
}

if( get_option( 'hmp_use_styles', 'on' ) ) {
	wp_enqueue_style( 'jh-portfolio', JHPURL . 'template/styles/style.css' );
	wp_enqueue_style( 'lightbox.css', JHPURL . 'template/styles/jquery.lightbox-0.5.css' );
}
if( get_option( 'hmp_use_scripts', 'on' ) ) {
	wp_enqueue_script( 'lightbox', JHPURL . 'template/js/jquery.lightbox-0.5.min.js', array( 'jquery' ) );
}

if( file_exists( get_template_directory() . '/page.php' ) ) {
	include( get_template_directory() . '/page.php' );
}
else {
	include( get_template_directory() . '/index.php' );
}