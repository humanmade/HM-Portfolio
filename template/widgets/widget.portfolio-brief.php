<?php
### Class: HM Portfolio Selector
 class WP_Widget_hmp_Portfolio_Brief extends WP_Widget {
	// Constructor
	function WP_Widget_hmp_Portfolio_Brief() {
		$widget_ops = array( 'description' => __( 'Shows the portfolio entry\'s brief', 'table_rss_news' ) );
		$this->WP_Widget( 'hmp_portfolio_brief', __( 'HMP Entry Brief' ), $widget_ops );
	}
 
	// Display Widget
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
				
		echo $before_widget;
		global $hmp_portfolio;
		
		?>
		<!-- Brief -->
		<?php if( $brief = hmp_get_brief() ) : ?>
			<div id="hmp-portfolio-brief">
				<h4>The Brief</h4>
				<p><?php echo $brief ?></p>
			</div>
		<?php endif; ?>
		<?php
		echo $after_widget;
	
	}
}
 
 
### Function: Init Table News Widget
add_action('widgets_init', 'widget_hmp_portfolio_brief');
function widget_hmp_portfolio_brief() {
	register_widget( 'WP_Widget_hmp_Portfolio_Brief' );
}
?>