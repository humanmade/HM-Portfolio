<?php
### Class: JH Portfolio Selector
 class WP_Widget_JH_Portfolio_Title extends WP_Widget {
	// Constructor
	function WP_Widget_JH_Portfolio_Title() {
		$widget_ops = array( 'description' => __( 'Shows the portfolio entry\'s title', 'table_rss_news' ) );
		$this->WP_Widget( 'jh_portfolio_title', __( 'JH Portfolio Entry Title' ), $widget_ops );
	}
 
	// Display Widget
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		echo $before_widget;
		
		?>
		<!-- Title -->
		<h3><?php the_title() ?></h3>
		<?php if( $byline = jhp_get_byline() ) : ?>
			<p id="jh-portfolio-byline"><?php echo $byline ?></p>
		<?php endif; ?>	
		<?php
		echo $after_widget;
	
	}
}
 
 
### Function: Init Table News Widget
add_action('widgets_init', 'widget_jh_portfolio_title');
function widget_jh_portfolio_title() {
	register_widget( 'WP_Widget_JH_Portfolio_Title' );
}
?>