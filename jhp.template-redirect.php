<?php
add_action('template_redirect', 'jhp_template_redirect', 2);

function jhp_template_redirect() {
	global $wp_query;
	
	$base = get_option('jhp_url_base', 'portfolio');
	
	// add the rewrites
	jhp_add_page_rule( "^/$base/?", array(get_stylesheet_directory() . '/portfolio.php', dirname( __FILE__ ) . '/template/portfolio.php'), 'Portfolio', array('is_page' => '1', 'is_portfolio' => '1'), array( 'post_type' => 'jh-portfolio' ) );
	jhp_add_page_rule( "^/$base/([^\/]*)/?", array(get_stylesheet_directory() . '/portfolio.category.php', dirname( __FILE__ ) . '/template/portfolio.category.php'), 'Portfolio Category', array( 'is_portfolio_category' => '1' ), array( 'term' => 0, 'taxonomy' => 'jh-portfolio-category' ) );
	jhp_add_page_rule( "^/$base/([^\/]*)/([^\/]*)/?", array(get_stylesheet_directory() . '/portfolio.single.php', dirname( __FILE__ ) . '/template/portfolio.single.php'), 'Portfolio Single', array( 'is_single' => '1', 'is_portfolio_single' => '1' ), array( 'name' => 1, 'post_type' => 'jh-portfolio' ) );
}

function jhp_add_page_rule( $regex, $files, $name, $query_vars = array(), $query = array() ) {

	if( !preg_match( '#' . $regex . '(\?[\s\S]*)?$' . '#', $_SERVER['REQUEST_URI'], $matches ) ) {
		return;
	}
	
	$files = (array) $files;
	
	foreach( $files as $file ) : if( file_exists( $file ) ) {
		global $wp_query;
		
		if( $query ) { 
			foreach( $query as $q => $number ) {
				$query_gen[$q] = is_int($number) ? $matches[$number + 1] : $number;
			} 
			
			global $wpdb;
			$wp_query = new WP_Query($query_gen);
		}
		
		if( is_array($query_vars) ) {
			//set any query_vars
			foreach( $query_vars as $count => $var ) {
				$wp_query->$var = $matches[$count + 1];
			}
		}
		$wp_query->is_404 = 0;

		include_once($file);
		exit;
	} endforeach;
	
}
?>