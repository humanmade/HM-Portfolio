<?php

/*
Plugin Name: JH Portfolio
Plugin URI: http://jh-portfolio.joehoyle.co.uk/
Description: Web/Print Portfolio plugin
Author: Joe Hoyle
Version: 0.9.1
Author URI: http://www.joehoyle.co.uk/
*/

define( 'JHPURL', str_replace( ABSPATH, trailingslashit(get_bloginfo('wpurl')), dirname( __FILE__ ) ) . '/' );

//Add Rewrite rules
add_action('init', 'jh_portfolio_init', 0, 0);
function jh_portfolio_init() {
	//register extra taxonomy
	register_taxonomy( 'jh-portfolio-category', 'jh-portfolio', array( 'hierarchical' => false ) );
	register_taxonomy( 'jh-portfolio-tag', 'jh-portfolio' );
}

//Template rewrite
include_once('jhp.functions.php');
include_once('jhp.template-redirect.php');
include_once('jhp.classes.php');
include_once('templates/hooks.php');
include_once('admin/admin.php');
include_once('jhp.hooks.php');
include_once('phpthumb/plugin.php');

//Widgets etc
include_once('jhp.widgets.php');

?>