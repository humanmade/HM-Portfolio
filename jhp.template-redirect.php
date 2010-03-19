<?php
add_action('template_redirect', 'jhp_template_redirect', 2);

function jhp_template_redirect() {
	global $wp_query;
	
	$portfolio_base = get_option('jhp_url_base', 'portfolio');
		 
	$single_base = untrailingslashit(get_option('jhp_single_base', '%category%'));
	$single_base = trim( str_ireplace( '%category%', '[^\/]*', $single_base ), '/' );
	
	$portfolio_files = array();
	if( $file = get_option( 'jhp_template_home', 'portfolio-home.php' ) )
		$portfolio_files[] = get_template_directory() . '/' . $file;
	$portfolio_files[] = dirname( __FILE__ ) . '/template/portfolio.php';
	
	$portfolio_single_files = array();
	if( $file = get_option( 'jhp_template_single', 'portfolio-single.php' ) )
		$portfolio_single_files[] = get_template_directory() . '/' . $file;
	$portfolio_single_files[] = dirname( __FILE__ ) . '/template/portfolio.single.php';
	
	// only set up the main query if they are using custom templates
	if( ($file = get_option( 'jhp_template_home', 'portfolio-home.php')) && file_exists( $file ) ) {
		$portfolio_query = array( 'post_type' => 'jh-portfolio', 'paged' => 1 );
	} else {
		$portfolio_query = array( 'post_type' => 'jh-portfolio', 'showposts' => '1' );
	}
			
	// add the rewrites
	tj_add_page_rule( "^/$portfolio_base(/page/([0-9]*))?/?", $portfolio_files, 'Portfolio', null, false, array('is_page' => '1', 'is_portfolio' => '1'), $portfolio_query );
	tj_add_page_rule( "^/$portfolio_base" . ( $single_base ? "/$single_base" : "" ) . "/([^\/]*)/?", $portfolio_single_files, 'Portfolio Single', null, false, array( 'is_single' => '1', 'is_page' => '1', 'is_portfolio_single' => '1' ), array( 'name' => 0, 'post_type' => 'jh-portfolio' ) );
	tj_add_page_rule( "^/$portfolio_base/([^/]*)/?", $portfolio_files, 'Portfolio', null, false, array('is_page' => '1', 'is_portfolio' => '1'), array( 'taxonomy' => 'jh-portfolio-category', 'term' => 0, 'post_type' => 'jh-portfolio' ) );
}
?>