<?php

// Register the global sidebar, needs low priority to register after other sidebar widgets
add_action( 'init', 'hmp_portfolio_register_sidebar', 99 );

function hmp_portfolio_register_sidebar() {
	register_sidebar( array(
        'before_widget' => '<div class="widget">',
        'after_widget' 	=> '</div>',
        'before_title' 	=> '<h2>',
        'after_title' 	=> '</h2>',
        'name'			=> 'Portfolio Home',
        'id'			=> 'hmp-portfolio'
	));
	register_sidebar( array(
        'before_widget' => '<div class="widget">',
        'after_widget' 	=> '</div>',
        'before_title' 	=> '<h2>',
        'after_title' 	=> '</h2>',
        'name'			=> 'Portfolio Single',
        'id'			=> 'hmp-portfolio-single'
	));
}

//widgets
include_once('template/widgets/widget.portfolio-selector.php');
include_once('template/widgets/widget.portfolio-grid.php');
include_once('template/widgets/widget.portfolio-title.php');
include_once('template/widgets/widget.portfolio-brief.php');
include_once('template/widgets/widget.portfolio-content.php');
include_once('template/widgets/widget.portfolio-gallery.php');
include_once('template/widgets/widget.portfolio-additional-info.php');
include_once('template/widgets/widget.portfolio-main-image.php');
include_once('template/widgets/widget.portfolio-extra-taxonomy.php');
?>