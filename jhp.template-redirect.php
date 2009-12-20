<?php
add_action('template_redirect', 'jhp_template_redirect', 2);

function jhp_template_redirect() {
	global $wp_query;
	
	$base = untrailingslashit(get_option('jhp_url_base', 'portfolio'));
	
	// add the rewrites
	tj_add_page_rule( "^/$base/?", array(get_stylesheet_directory() . '/' . get_option( 'jhp_template_home', 'portfolio.home.php' ), dirname( __FILE__ ) . '/template/portfolio.php'), 'Portfolio', null, false, array('is_page' => '1', 'is_portfolio' => '1'), array( 'post_type' => 'jh-portfolio' ) );
	tj_add_page_rule( "^/$base/([^\/]*)/?", array(get_stylesheet_directory() . '/portfolio.category.php', dirname( __FILE__ ) . '/template/portfolio.category.php'), 'Portfolio Category', null, false, array( 'is_portfolio_category' => '1' ), array( 'term' => 0, 'taxonomy' => 'jh-portfolio-category' ) );
	tj_add_page_rule( "^/$base/([^\/]*)/([^\/]*)/?", array(get_stylesheet_directory() . '/' . get_option( 'jhp_template_single', 'portfolio.single.php' ), dirname( __FILE__ ) . '/template/portfolio.single.php'), 'Portfolio Single', null, false, array( 'is_single' => '1', 'is_portfolio_single' => '1' ), array( 'name' => 1, 'post_type' => 'jh-portfolio' ) );
}
?>